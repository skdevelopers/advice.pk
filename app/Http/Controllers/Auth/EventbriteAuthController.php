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

final class EventbriteAuthController extends Controller
{
    /**
     * Start the OAuth flow.
     * Stores an optional "next" URL in session so we can return after login.
     */
    public function redirect(): RedirectResponse
    {
        if (request()->filled('next')) {
            session(['next_url' => (string) request()->query('next')]);
        }

        // Use stateless if configured (helps diagnose session/state problems)
        if (config('services.eventbrite.stateless', env('EVENTBRITE_STATELESS', false))) {
            return Socialite::driver('eventbrite')->stateless()->redirect();
        }

        return Socialite::driver('eventbrite')->redirect();
    }

    /**
     * OAuth callback handler.
     * Upserts a local user, stores provider identity, logs the user in,
     * writes an append-only CSV row (non-fatal), and redirects.
     */
    public function callback(): RedirectResponse
    {
        // Try to get the Socialite user (detailed logging on failure)
        try {
            $stateless = config('services.eventbrite.stateless', env('EVENTBRITE_STATELESS', false));
            $ebUser = $stateless
                ? Socialite::driver('eventbrite')->stateless()->user()
                : Socialite::driver('eventbrite')->user();
        } catch (\Throwable $e) {
            // Full diagnostic log for debugging (do not expose tokens)
            Log::error('Eventbrite OAuth callback exception', [
                'exception_class' => get_class($e),
                'message'         => $e->getMessage(),
                'code'            => $e->getCode(),
                'trace'           => $e->getTraceAsString(),
                'request_query'   => request()->query(), // includes code/state if present
                'session_has'     => !! session()->all(),
                'server_time'     => now()->toDateTimeString(),
            ]);

            return redirect()->to($this->fallbackUrl())
                ->with('error', 'Eventbrite sign-in failed (check logs).');
        }

        // Normalize basic fields
        $email = $ebUser->getEmail() ?: null;
        $name  = $ebUser->getName() ?: ($email ? Str::before($email, '@') : 'Guest');
        $pid   = (string) $ebUser->getId();

        // Resolve existing identity or user
        $identity = UserIdentity::where(['provider' => 'eventbrite', 'provider_id' => $pid])->first();
        $user = $identity?->user ?: ($email ? User::where('email', $email)->first() : null);

        // Create user if not found
        if (! $user) {
            $user = User::create([
                'name'     => $name,
                'email'    => $email ?: "no-email+eb-{$pid}@example.invalid",
                'password' => bcrypt(Str::random(40)),
            ]);
        }

        // Persist identity and tokens (tokens stored server-side only)
        UserIdentity::updateOrCreate(
            ['provider' => 'eventbrite', 'provider_id' => $pid],
            [
                'user_id'          => $user->id,
                'access_token'     => $ebUser->token ?? null,
                'refresh_token'    => $ebUser->refreshToken ?? null,
                'token_expires_at' => isset($ebUser->expiresIn) ? now()->addSeconds((int) $ebUser->expiresIn) : null,
            ]
        );

        // Log the user in
        Auth::login($user, true);

        // Append audit CSV (non-fatal)
        try {
            $this->csvAppendTo(
                'oauth_users.csv',
                ['time','user_id','name','email','provider_id','token_present'],
                [now()->toDateTimeString(), (string) $user->id, $name, (string) $email, $pid, $ebUser->token ? 'yes' : 'no']
            );
        } catch (\Throwable $e) {
            Log::warning('CSV append failed (oauth_users.csv)', [
                'error' => $e->getMessage(),
            ]);
            // intentionally swallowed so login still works
        }

        // Determine where to send the user
        $to = session()->pull('next_url');
        if (! $to) {
            $to = Route::has('admin.dashboard') ? route('admin.dashboard')
                : (Route::has('dashboard') ? route('dashboard') : url('/'));
        }

        return redirect()->to($to)->with('ok', 'Signed in with Eventbrite');
    }

    /**
     * Append a CSV row under storage/app/eventbrite/.
     * Ensures directory/file exists. Will not throw.
     */
    private function csvAppendTo(string $filename, array $headers, array $row): void
    {
        try {
            $disk = Storage::disk('local'); // storage/app
            $dir = 'eventbrite';
            $path = $dir . '/' . ltrim($filename, '/');

            if (! $disk->exists($dir)) {
                $disk->makeDirectory($dir, 0755, true, true);
            }

            if (! $disk->exists($path)) {
                $disk->put($path, $this->csvLine($headers));
            }

            $disk->append($path, rtrim($this->csvLine($row), "\r\n"));
        } catch (\Throwable $e) {
            // log and swallow to prevent breaking the auth flow
            Log::warning('csvAppendTo failed', [
                'file'  => $filename,
                'error' => $e->getMessage(),
            ]);
        }
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

    /** Fallback URL if named routes missing */
    private function fallbackUrl(): string
    {
        return Route::has('admin.dashboard') ? route('admin.dashboard')
            : (Route::has('dashboard') ? route('profile') : url('/'));
    }
}
