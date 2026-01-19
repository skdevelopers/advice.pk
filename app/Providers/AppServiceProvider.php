<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Eventbrite\EventbriteExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Listens for Socialite's provider registration event and attaches the
     * Eventbrite driver, so Socialite::driver('eventbrite') works.
     *
     * @return void
     */
    public function boot(): void
    {
        // Registers components in resources/views/admin/components under the 'admin' namespace
        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');
        Event::listen(SocialiteWasCalled::class, [EventbriteExtendSocialite::class, 'handle']);
    }
}
