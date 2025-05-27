<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Define role/permission mappings or custom guards if needed.
     *
     * @return void
     */
    protected function configurePermissions(): void
    {
        // Optional: load permissions from config, or define directly
        Gate::define('admin-access', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('user-access', function ($user) {
            return $user->hasAnyRole(['user', 'subscriber']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Action classes
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Rate limiter for login attempts
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())).'|'.$request->ip()
            );
            return Limit::perMinute(5)->by($throttleKey);
        });

        // Rate limiter for 2FA
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Set Fortify views
        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn () => view('auth.signup'));

        // Load permissions configuration
        $this->configurePermissions();
    }
}
