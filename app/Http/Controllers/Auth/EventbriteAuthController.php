<?php
declare(strict_types=1);

/**
 * EventbriteAuthController
 *
 * Handles attendee OAuth login via Eventbrite:
 *  - GET /auth/eventbrite/redirect
 *  - GET /auth/eventbrite/callback
 *
 * Behavior:
 *  - Creates/links a local user (by provider id, fallback by email)
 *  - Stores tokens in user_identities
 *  - Logs the user in
 *  - Appends a CSV row to storage/app/eventbrite/oauth_users.csv (append-only)
 *  - Redirects to ?next=... or to route('admin.dashboard') by default
 *
 * Note: This controller is for attendee login UX only.
 *       For org-level data sync (orders/attendees/events), use the organizer token server-side.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserIdentity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class EventbriteAuthController extends Controller
{
    /**
     * Redirect the browser to Eventbrite for OAuth consent.
     */
    public function redirect(): RedirectResponse
    {
        // Remember the post-login destination (optional)
        if (request()->filled('next')) {
            session(['next_url' => (string) request()->query('next')]);
        }

        return Socialite::driver('eventbrite')->redirect();
        // If you ever face session/proxy issues during callback, you can switch to:
        // return Socialite::driver('eventbrite')->stateless()->redirect();
    }

    /**
     * OAuth callback: create/link user, store tokens, login, CSV log, redirect.
     */
    public function callback(): RedirectResponse
    {
        try {
            $ebUser = Socialite::driver('eventbrite')->user(); // calls /users/me
            // For stateless mode (if needed):
            // $ebUser = Socialite::driver('eventbrite')->stateless()->user();
        } catch (\Throwable $e) {
            Log::warning('Eventbrite OAuth callback error', ['error' => $e->getMessage()]);
            return redirect()->route('admin.dashboard')
                ->with('error', 'Eventbrite sign-in failed. Please try again.');
        }

        $email = $ebUser->getEmail() ?: null;
        $name  = $ebUser->getName() ?: ($email ? Str::before($email, '@') : 'Guest');
        $pid   = (string) $ebUser->getId();

        // 1) Resolve the local user (by provider id first, then email)
        $identity = UserIdentity::query()
            ->where(['provider' => 'eventbrite', 'provider_id' => $pid])
            ->first();

        $user = $identity?->user
            ?: ($email ? User::query()->where('email', $email)->first() : null);

        // 2) Create a new user if none found
        if (!$user) {
            $user = User::query()->create([
                'name'     => $name,
                'email'    => $email ?: "no-email+eb-{$pid}@example.invalid",
                'password' => bcrypt(Str::random(40)), // user can set real password later
            ]);
        }

        // 3) Link or refresh the identity tokens (do not write tokens to CSV)
        UserIdentity::updateOrCreate(
            ['provider' => 'eventbrite', 'provider_id' => $pid],
            [
                'user_id'          => $user->id,
                'access_token'     => $ebUser->token ?? null,
                'refresh_token'    => $ebUser->refreshToken ?? null,
                'token_expires_at' => isset($ebUser->expiresIn) ? now()->addSeconds((int) $ebUser->expiresIn) : null,
            ]
        );

        // 4) Sign in locally
        Auth::login($user, remember: true);

        // 5) Append CSV log (append-only, never overwrite)
        $this->csvAppend(
            'oauth_users.csv',
            ['time','user_id','name','email','provider_id','token_present'],
            [now()->toDateTimeString(), (string) $user->id, $name, (string) $email, $pid, $ebUser->token ? 'yes' : 'no']
        );

        // 6) Redirect
        $to = session()->pull('next_url') ?: route('admin.dashboard');
        return redirect()->to($to)->with('ok', 'Signed in with Eventbrite');
    }

    /**
     * Append a row to CSV under storage/app/eventbrite/
     *
     * @param  string $filename  e.g. oauth_users.csv
     * @param  array  $headers   header columns (written once if file new)
     * @param  array  $row       values (must align with headers)
     */
    private function csvAppend(string $filename, array $headers, array $row): void
    {
        $disk = Storage::disk('local'); // storage/app
        if (!$disk->exists('eventbrite')) {
            $disk->makeDirectory('eventbrite');
        }
        $path  = 'eventbrite/' . ltrim($filename, '/');
        $full  = storage_path('app/' . $path);
        $isNew = !file_exists($full);

        $fh = fopen($full, 'ab');       // binary-safe append
        if ($fh === false) {
            Log::warning('Unable to open CSV for append', ['path' => $full]);
            return;
        }

        if ($isNew) {
            fputcsv($fh, $headers);
        }
        fputcsv($fh, $row);
        fclose($fh);
    }
}
