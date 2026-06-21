<?php

namespace NativePHP\GoogleMobileAds;

use Illuminate\Support\ServiceProvider;

class GoogleMobileAdsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/google-mobile-ads.php', 'google-mobile-ads');

        $this->app->singleton('google-mobile-ads', fn () => new GoogleMobileAds);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/google-mobile-ads.php' => config_path('google-mobile-ads.php'),
        ], 'google-mobile-ads-config');
    }
}
