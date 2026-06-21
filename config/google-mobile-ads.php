<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AdMob App ID
    |--------------------------------------------------------------------------
    |
    | Your AdMob App ID from the AdMob console. Must match GADApplicationIdentifier
    | in nativephp.json for iOS. Format: ca-app-pub-XXXXXXXXXXXXXXXX~XXXXXXXXXX
    |
    */

    'app_id' => env('ADMOB_APP_ID'),

    /*
    |--------------------------------------------------------------------------
    | Ad Unit IDs
    |--------------------------------------------------------------------------
    |
    | Set your ad unit IDs from the AdMob console per format.
    | The defaults below are Google's official Android demo/test IDs — safe to
    | use during development without risking policy violations.
    |
    | Android demo IDs                              iOS demo IDs
    | ─────────────────────────────────────────     ────────────────────────────────────────
    | App Open:              9257395921             App Open:          5575463023
    | Anchored Adaptive:     9214589741             Banner:            2934735716
    | Inline Adaptive:       9214589741             Interstitial:      4411468910
    | Fixed Size Banner:     6300978111             Rewarded:          1712485313
    | Interstitial:          1033173712             Rewarded Interst.: 6978759866
    | Rewarded:              5224354917             Native:            3986624511
    | Rewarded Interstitial: 5354046379
    | Native:                2247696110
    | Native Video:          1044960115
    |
    | All Android IDs are prefixed with: ca-app-pub-3940256099942544/
    | All iOS IDs are prefixed with:     ca-app-pub-3940256099942544/
    |
    */

    // Banner
    'banner_ad_unit_id' => env('ADMOB_BANNER_AD_UNIT_ID', 'ca-app-pub-3940256099942544/6300978111'),

    // Anchored Adaptive Banner (auto-sizes to screen width, best for most cases)
    'anchored_adaptive_banner_ad_unit_id' => env('ADMOB_ANCHORED_ADAPTIVE_BANNER_AD_UNIT_ID', 'ca-app-pub-3940256099942544/9214589741'),

    // Inline Adaptive Banner (expands to content height, for scrollable feeds)
    'inline_adaptive_banner_ad_unit_id' => env('ADMOB_INLINE_ADAPTIVE_BANNER_AD_UNIT_ID', 'ca-app-pub-3940256099942544/9214589741'),

    // Interstitial
    'interstitial_ad_unit_id' => env('ADMOB_INTERSTITIAL_AD_UNIT_ID', 'ca-app-pub-3940256099942544/1033173712'),

    // Rewarded
    'rewarded_ad_unit_id' => env('ADMOB_REWARDED_AD_UNIT_ID', 'ca-app-pub-3940256099942544/5224354917'),

    // Rewarded Interstitial (full-screen rewarded, no opt-out required)
    'rewarded_interstitial_ad_unit_id' => env('ADMOB_REWARDED_INTERSTITIAL_AD_UNIT_ID', 'ca-app-pub-3940256099942544/5354046379'),

    // App Open
    'app_open_ad_unit_id' => env('ADMOB_APP_OPEN_AD_UNIT_ID', 'ca-app-pub-3940256099942544/9257395921'),

    // Native Advanced
    'native_ad_unit_id' => env('ADMOB_NATIVE_AD_UNIT_ID', 'ca-app-pub-3940256099942544/2247696110'),

    // Native Video
    'native_video_ad_unit_id' => env('ADMOB_NATIVE_VIDEO_AD_UNIT_ID', 'ca-app-pub-3940256099942544/1044960115'),

];
