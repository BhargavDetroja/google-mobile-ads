<?php

namespace NativePHP\GoogleMobileAds;

class GoogleMobileAds
{
    /**
     * Initialize the Google Mobile Ads SDK.
     *
     * Must be called once before showing any ads. Fires AdLoaded event on success.
     *
     * @param  array{app_id?: string}  $options
     */
    public function initialize(array $options = []): void
    {
        $appId = $options['app_id'] ?? config('google-mobile-ads.app_id');

        $this->bridgeCall('GoogleMobileAds.Initialize', ['app_id' => $appId]);
    }

    /**
     * Show a banner ad anchored to the given position.
     *
     * @param  array{ad_unit_id?: string, position?: string, size?: string}  $options
     *   position: 'top' | 'bottom' (default: 'bottom')
     *   size: 'banner' | 'large_banner' | 'medium_rectangle' | 'adaptive' (default: 'adaptive')
     */
    public function showBanner(array $options = []): void
    {
        $this->bridgeCall('GoogleMobileAds.ShowBanner', [
            'ad_unit_id' => $options['ad_unit_id'] ?? config('google-mobile-ads.banner_ad_unit_id'),
            'position'   => $options['position'] ?? 'bottom',
            'size'       => $options['size'] ?? 'adaptive',
        ]);
    }

    /**
     * Hide and destroy the currently displayed banner ad.
     */
    public function hideBanner(): void
    {
        $this->bridgeCall('GoogleMobileAds.HideBanner', []);
    }

    /**
     * Pre-load an interstitial ad so it is ready to show instantly.
     *
     * @param  array{ad_unit_id?: string}  $options
     */
    public function loadInterstitial(array $options = []): void
    {
        $this->bridgeCall('GoogleMobileAds.LoadInterstitial', [
            'ad_unit_id' => $options['ad_unit_id'] ?? config('google-mobile-ads.interstitial_ad_unit_id'),
        ]);
    }

    /**
     * Show a previously loaded interstitial ad.
     */
    public function showInterstitial(): void
    {
        $this->bridgeCall('GoogleMobileAds.ShowInterstitial', []);
    }

    /**
     * Pre-load a rewarded ad.
     *
     * @param  array{ad_unit_id?: string}  $options
     */
    public function loadRewarded(array $options = []): void
    {
        $this->bridgeCall('GoogleMobileAds.LoadRewarded', [
            'ad_unit_id' => $options['ad_unit_id'] ?? config('google-mobile-ads.rewarded_ad_unit_id'),
        ]);
    }

    /**
     * Show a previously loaded rewarded ad. Fires RewardEarned event when the user completes the ad.
     */
    public function showRewarded(): void
    {
        $this->bridgeCall('GoogleMobileAds.ShowRewarded', []);
    }

    /**
     * Pre-load a rewarded interstitial ad.
     *
     * @param  array{ad_unit_id?: string}  $options
     */
    public function loadRewardedInterstitial(array $options = []): void
    {
        $this->bridgeCall('GoogleMobileAds.LoadRewardedInterstitial', [
            'ad_unit_id' => $options['ad_unit_id'] ?? config('google-mobile-ads.rewarded_interstitial_ad_unit_id'),
        ]);
    }

    /**
     * Show a previously loaded rewarded interstitial ad. Fires RewardEarned event when the user completes the ad.
     */
    public function showRewardedInterstitial(): void
    {
        $this->bridgeCall('GoogleMobileAds.ShowRewardedInterstitial', []);
    }

    /**
     * Pre-load an app open ad.
     *
     * @param  array{ad_unit_id?: string}  $options
     */
    public function loadAppOpen(array $options = []): void
    {
        $this->bridgeCall('GoogleMobileAds.LoadAppOpen', [
            'ad_unit_id' => $options['ad_unit_id'] ?? config('google-mobile-ads.app_open_ad_unit_id'),
        ]);
    }

    /**
     * Show a previously loaded app open ad.
     */
    public function showAppOpen(): void
    {
        $this->bridgeCall('GoogleMobileAds.ShowAppOpen', []);
    }

    /**
     * @param  array<string, mixed>  $params
     */
    private function bridgeCall(string $method, array $params): void
    {
        // The JS bridge handles the actual HTTP call to /_native/api/call.
        // In PHP context this is a no-op; calls originate from the JS layer.
    }
}
