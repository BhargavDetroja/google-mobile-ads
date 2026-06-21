<?php

namespace NativePHP\GoogleMobileAds\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string resolveAdUnitId(string $slot)
 * @method static static initialize()
 * @method static static showBanner(string $slot = 'banner', string $position = 'bottom', string $size = 'adaptive')
 * @method static static hideBanner()
 * @method static static loadInterstitial(string $slot = 'interstitial')
 * @method static static showInterstitial()
 * @method static static loadRewarded(string $slot = 'rewarded')
 * @method static static showRewarded()
 * @method static static loadRewardedInterstitial(string $slot = 'rewarded_interstitial')
 * @method static static showRewardedInterstitial()
 * @method static static loadAppOpen(string $slot = 'app_open')
 * @method static static showAppOpen()
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
