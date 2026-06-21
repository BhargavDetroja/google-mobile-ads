async function bridgeCall(method, params = {}) {
    const response = await fetch('/_native/api/call', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ method, params }),
    });
    return response.json();
}

/**
 * Initialize the Google Mobile Ads SDK.
 * Must be called once before showing any ads.
 *
 * @param {{ app_id?: string }} options
 */
export async function initialize(options = {}) {
    return bridgeCall('GoogleMobileAds.Initialize', options);
}

/**
 * Show a banner ad.
 *
 * @param {{ ad_unit_id?: string, position?: 'top'|'bottom', size?: 'banner'|'large_banner'|'medium_rectangle'|'adaptive' }} options
 */
export async function showBanner(options = {}) {
    return bridgeCall('GoogleMobileAds.ShowBanner', options);
}

/**
 * Hide and destroy the current banner ad.
 */
export async function hideBanner() {
    return bridgeCall('GoogleMobileAds.HideBanner', {});
}

/**
 * Pre-load an interstitial ad.
 *
 * @param {{ ad_unit_id?: string }} options
 */
export async function loadInterstitial(options = {}) {
    return bridgeCall('GoogleMobileAds.LoadInterstitial', options);
}

/**
 * Show the pre-loaded interstitial ad.
 */
export async function showInterstitial() {
    return bridgeCall('GoogleMobileAds.ShowInterstitial', {});
}

/**
 * Pre-load a rewarded ad.
 *
 * @param {{ ad_unit_id?: string }} options
 */
export async function loadRewarded(options = {}) {
    return bridgeCall('GoogleMobileAds.LoadRewarded', options);
}

/**
 * Show the pre-loaded rewarded ad.
 */
export async function showRewarded() {
    return bridgeCall('GoogleMobileAds.ShowRewarded', {});
}

/**
 * Pre-load an app open ad.
 *
 * @param {{ ad_unit_id?: string }} options
 */
export async function loadAppOpen(options = {}) {
    return bridgeCall('GoogleMobileAds.LoadAppOpen', options);
}

/**
 * Show the pre-loaded app open ad.
 */
export async function showAppOpen() {
    return bridgeCall('GoogleMobileAds.ShowAppOpen', {});
}
