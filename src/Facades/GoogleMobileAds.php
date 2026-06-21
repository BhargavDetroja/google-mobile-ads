<?php

namespace NativePHP\GoogleMobileAds\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void initialize(array $options = [])
 * @method static void showBanner(array $options = [])
 * @method static void hideBanner()
 * @method static void loadInterstitial(array $options = [])
 * @method static void showInterstitial()
 * @method static void loadRewarded(array $options = [])
 * @method static void showRewarded()
 * @method static void loadRewardedInterstitial(array $options = [])
 * @method static void showRewardedInterstitial()
 * @method static void loadAppOpen(array $options = [])
 * @method static void showAppOpen()
 *
 * @see \NativePHP\GoogleMobileAds\GoogleMobileAds
 */
class GoogleMobileAds extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'google-mobile-ads';
    }
}
