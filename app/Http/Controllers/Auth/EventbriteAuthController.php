<?php
/**
 * EventbriteAuthController
 *
 * Handles OAuth login via Eventbrite:
 *  - /auth/eventbrite/redirect → sends user to Eventbrite consent
 *  - /auth/eventbrite/callback → receives profile, upserts identity, logs in
 *
 * After successful login, redirects to a protected route (e.g., dashboard).
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserIdentity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class EventbriteAuthController extends Controller
{
    /**
     * Redirect the browser to Eventbrite for OAuth consent.
     *
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('eventbrite')->redirect();
    }

    /**
     * OAuth callback handler from Eventbrite.
     *
     * Creates or links a local user using the provider id/email, persists
     * tokens in user_identities, logs the user in, and redirects.
     *
     * @return RedirectResponse
     */
    public function callback(): RedirectResponse
    {
        $ebUser = Socialite::driver('eventbrite')->user();

        $email = $ebUser->getEmail() ?: null;
        $name  = $ebUser->getName() ?: ($email ? Str::before($email, '@') : 'Guest');
        $pid   = (string) $ebUser->getId();

        $identity = UserIdentity::query()
            ->where(['provider' => 'eventbrite', 'provider_id' => $pid])
            ->first();

        $user = $identity?->user
            ?: ($email ? User::query()->where('email', $email)->first() : null);

        if (!$user) {
            $user = User::query()->create([
                'name'     => $name,
                'email'    => $email ?: "no-email+eb-{$pid}@example.invalid",
                'password' => bcrypt(Str::random(40)),
            ]);
        }

        UserIdentity::updateOrCreate(
            ['provider' => 'eventbrite', 'provider_id' => $pid],
            [
                'user_id'          => $user->id,
                'access_token'     => $ebUser->token ?? null,
                'refresh_token'    => $ebUser->refreshToken ?? null,
                'token_expires_at' => isset($ebUser->expiresIn) ? now()->addSeconds($ebUser->expiresIn) : null,
            ]
        );

        Auth::login($user, true);

        return redirect()->route('dashboard')->with('ok', 'Signed in with Eventbrite');
    }
}
