<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserIdentity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class EventbriteAuthController extends Controller
{
    /** Start OAuth */
    public function redirect(): RedirectResponse
    {
        if (request()->filled('next')) {
            session(['next_url' => (string) request()->query('next')]);
        }
        return Socialite::driver('eventbrite')->redirect();
        // If you ever face state/proxy issues:
        // return Socialite::driver('eventbrite')->stateless()->redirect();
    }

    /** Callback: upsert user, store tokens, login, CSV append (non-fatal), redirect */
    public function callback(): RedirectResponse
    {
        try {
            $ebUser = Socialite::driver('eventbrite')->user();
        } catch (\Throwable $e) {
            Log::warning('Eventbrite OAuth callback error', ['error' => $e->getMessage()]);
            return redirect()->to($this->fallbackUrl())
                ->with('error', 'Eventbrite sign-in failed. Please try again.');
        }

        $email = $ebUser->getEmail() ?: null;
        $name  = $ebUser->getName() ?: ($email ? Str::before($email, '@') : 'Guest');
        $pid   = (string) $ebUser->getId();

        // Resolve/link user
        $identity = UserIdentity::where(['provider' => 'eventbrite', 'provider_id' => $pid])->first();
        $user     = $identity?->user ?: ($email ? User::where('email', $email)->first() : null);

        if (!$user) {
            $user = User::create([
                'name'     => $name,
                'email'    => $email ?: "no-email+eb-{$pid}@example.invalid",
                'password' => bcrypt(Str::random(40)),
            ]);
        }

        // Store/refresh tokens (not written to CSV)
        UserIdentity::updateOrCreate(
            ['provider' => 'eventbrite', 'provider_id' => $pid],
            [
                'user_id'          => $user->id,
                'access_token'     => $ebUser->token ?? null,
                'refresh_token'    => $ebUser->refreshToken ?? null,
                'token_expires_at' => isset($ebUser->expiresIn) ? now()->addSeconds((int) $ebUser->expiresIn) : null,
            ]
        );

        // Login
        Auth::login($user, true);

        // Append CSV (non-fatal on any error)
        try {
            $this->csvAppendTo(
                'oauth_users.csv',
                ['time','user_id','name','email','provider_id','token_present'],
                [now()->toDateTimeString(), (string) $user->id, $name, (string) $email, $pid, $ebUser->token ? 'yes' : 'no']
            );
        } catch (\Throwable $e) {
            Log::warning('CSV append failed (oauth_users.csv)', ['error' => $e->getMessage()]);
            // Don’t throw—login should still succeed
        }

        // Redirect (?next → admin.dashboard → dashboard → /)
        $to = session()->pull('next_url');
        if (!$to) {
            $to = Route::has('admin.dashboard') ? route('admin.dashboard')
                : (Route::has('dashboard') ? route('dashboard') : url('/'));
        }
        return redirect()->to($to)->with('ok', 'Signed in with Eventbrite');
    }

    /** Append a row to CSV under storage/app/eventbrite/ (creates dir/file as needed) */
    private function csvAppendTo(string $filename, array $headers, array $row): void
    {
        $disk = Storage::disk('local');   // storage/app
        $dir  = 'eventbrite';
        $path = $dir . '/' . ltrim($filename, '/');

        // Ensure directory exists (recursive)
        if (!$disk->exists($dir)) {
            // recursive + force create; visibility handled by default local driver
            $disk->makeDirectory($dir, 0755, true, true);
        }

        // If file is new, write headers
        if (!$disk->exists($path)) {
            $head = $this->csvLine($headers);
            $disk->put($path, $head);
        }

        // Append the data row
        $disk->append($path, rtrim($this->csvLine($row), "\r\n"));
    }

    /** Build a CSV line in memory */
    private function csvLine(array $fields): string
    {
        $fp = fopen('php://temp', 'r+');
        fputcsv($fp, $fields);
        rewind($fp);
        $line = (string) stream_get_contents($fp);
        fclose($fp);
        return $line;
    }

    private function fallbackUrl(): string
    {
        return Route::has('admin.dashboard') ? route('admin.dashboard')
            : (Route::has('dashboard') ? route('dashboard') : url('/'));
    }
}
