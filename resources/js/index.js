async function bridgeCall(method, params = {}) {
    const response = await fetch('/_native/api/call', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ method, params }),
    });
    return response.json();
}

// ── SDK ───────────────────────────────────────────────────────────────────────

export async function initialize(options = {}) {
    return bridgeCall('GoogleMobileAds.Initialize', options);
}

// ── Banner ────────────────────────────────────────────────────────────────────

export async function showBanner(options = {}) {
    return bridgeCall('GoogleMobileAds.ShowBanner', options);
}

export async function hideBanner() {
    return bridgeCall('GoogleMobileAds.HideBanner', {});
}

// ── Interstitial ──────────────────────────────────────────────────────────────

export async function loadInterstitial(options = {}) {
    return bridgeCall('GoogleMobileAds.LoadInterstitial', options);
}

export async function showInterstitial() {
    return bridgeCall('GoogleMobileAds.ShowInterstitial', {});
}

// ── Rewarded ──────────────────────────────────────────────────────────────────

export async function loadRewarded(options = {}) {
    return bridgeCall('GoogleMobileAds.LoadRewarded', options);
}

export async function showRewarded() {
    return bridgeCall('GoogleMobileAds.ShowRewarded', {});
}

// ── Rewarded Interstitial ─────────────────────────────────────────────────────

export async function loadRewardedInterstitial(options = {}) {
    return bridgeCall('GoogleMobileAds.LoadRewardedInterstitial', options);
}

export async function showRewardedInterstitial() {
    return bridgeCall('GoogleMobileAds.ShowRewardedInterstitial', {});
}

// ── App Open ──────────────────────────────────────────────────────────────────

export async function loadAppOpen(options = {}) {
    return bridgeCall('GoogleMobileAds.LoadAppOpen', options);
}

export async function showAppOpen() {
    return bridgeCall('GoogleMobileAds.ShowAppOpen', {});
}

// ── Event listeners ───────────────────────────────────────────────────────────

/**
 * Listen for any ad event dispatched from native code.
 *
 * Works with any frontend framework — React, Vue, Alpine, plain JS.
 * Returns an unsubscribe function you can call to remove the listener.
 *
 * Ad event names:
 *   NativePHP\GoogleMobileAds\Events\AdLoaded
 *   NativePHP\GoogleMobileAds\Events\AdFailedToLoad
 *   NativePHP\GoogleMobileAds\Events\AdOpened
 *   NativePHP\GoogleMobileAds\Events\AdClosed
 *   NativePHP\GoogleMobileAds\Events\AdImpression
 *   NativePHP\GoogleMobileAds\Events\AdClicked
 *   NativePHP\GoogleMobileAds\Events\RewardEarned
 *
 * @param {string} eventName - Fully-qualified PHP event class name
 * @param {(payload: object) => void} callback
 * @returns {() => void} unsubscribe function
 */
export function onAdEvent(eventName, callback) {
    const handler = (e) => {
        if (e.detail?.event === eventName) {
            callback(e.detail.payload ?? {});
        }
    };
    document.addEventListener('native-event', handler);
    return () => document.removeEventListener('native-event', handler);
}

/**
 * Convenience: listen for the RewardEarned event.
 * Returns an unsubscribe function.
 *
 * @param {(payload: { rewardType: string, rewardAmount: number }) => void} callback
 * @returns {() => void} unsubscribe function
 */
export function onRewardEarned(callback) {
    return onAdEvent('NativePHP\\GoogleMobileAds\\Events\\RewardEarned', callback);
}

/**
 * Convenience: listen for AdLoaded.
 * Returns an unsubscribe function.
 *
 * @param {(payload: { adType: string, adUnitId: string }) => void} callback
 * @returns {() => void} unsubscribe function
 */
export function onAdLoaded(callback) {
    return onAdEvent('NativePHP\\GoogleMobileAds\\Events\\AdLoaded', callback);
}

/**
 * Convenience: listen for AdClosed.
 * Returns an unsubscribe function.
 *
 * @param {(payload: { adType: string }) => void} callback
 * @returns {() => void} unsubscribe function
 */
export function onAdClosed(callback) {
    return onAdEvent('NativePHP\\GoogleMobileAds\\Events\\AdClosed', callback);
}
