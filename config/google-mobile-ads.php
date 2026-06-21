<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kill Switch
    |--------------------------------------------------------------------------
    | Set ADMOB_ENABLED=false to disable all ads globally — useful for
    | premium users, A/B testing, or debugging without removing any code.
    */

    'enabled' => env('ADMOB_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | App IDs
    |--------------------------------------------------------------------------
    | Your AdMob App IDs, one per platform. Found in AdMob console → Apps.
    | Both are read from .env — no need to edit any vendor files.
    */

    'android_app_id' => env('ADMOB_APP_ID'),
    'ios_app_id'     => env('ADMOB_IOS_APP_ID'),

    /*
    |--------------------------------------------------------------------------
    | Test Mode
    |--------------------------------------------------------------------------
    | When enabled, Google's official demo ad unit IDs are substituted
    | automatically — safe to leave on in development. Defaults to true
    | whenever APP_ENV is not "production".
    */

    'test_mode' => env('ADMOB_TEST_MODE', env('APP_ENV', 'production') !== 'production'),

    /*
    |--------------------------------------------------------------------------
    | Ad Slots
    |--------------------------------------------------------------------------
    | Name your ad placements. Use a plain string when both platforms share
    | the same ID, or an array to set different IDs per platform.
    |
    |   // Same ID on both platforms:
    |   'home_banner' => env('ADMOB_BANNER_AD_UNIT_ID'),
    |
    |   // Different ID per platform:
    |   'home_banner' => [
    |       'android' => env('ADMOB_BANNER_AD_UNIT_ID_ANDROID'),
    |       'ios'     => env('ADMOB_BANNER_AD_UNIT_ID_IOS'),
    |   ],
    */

    'slots' => [

        'banner'                   => env('ADMOB_BANNER_AD_UNIT_ID'),
        'anchored_adaptive_banner' => env('ADMOB_ANCHORED_ADAPTIVE_BANNER_AD_UNIT_ID'),
        'inline_adaptive_banner'   => env('ADMOB_INLINE_ADAPTIVE_BANNER_AD_UNIT_ID'),
        'interstitial'             => env('ADMOB_INTERSTITIAL_AD_UNIT_ID'),
        'app_open'                 => env('ADMOB_APP_OPEN_AD_UNIT_ID'),
        'rewarded'                 => env('ADMOB_REWARDED_AD_UNIT_ID'),
        'rewarded_interstitial'    => env('ADMOB_REWARDED_INTERSTITIAL_AD_UNIT_ID'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Test Ad Unit IDs
    |--------------------------------------------------------------------------
    | Google's official demo IDs used automatically in test_mode.
    | Do not change these.
    */

    'test_slots' => [

        'banner' => [
            'android' => 'ca-app-pub-3940256099942544/6300978111',
            'ios'     => 'ca-app-pub-3940256099942544/2934735716',
        ],
        'anchored_adaptive_banner' => [
            'android' => 'ca-app-pub-3940256099942544/9214589741',
            'ios'     => 'ca-app-pub-3940256099942544/2934735716',
        ],
        'inline_adaptive_banner' => [
            'android' => 'ca-app-pub-3940256099942544/9214589741',
            'ios'     => 'ca-app-pub-3940256099942544/2934735716',
        ],
        'interstitial' => [
            'android' => 'ca-app-pub-3940256099942544/1033173712',
            'ios'     => 'ca-app-pub-3940256099942544/4411468910',
        ],
        'app_open' => [
            'android' => 'ca-app-pub-3940256099942544/9257395921',
            'ios'     => 'ca-app-pub-3940256099942544/5575463023',
        ],
        'rewarded' => [
            'android' => 'ca-app-pub-3940256099942544/5224354917',
            'ios'     => 'ca-app-pub-3940256099942544/1712485313',
        ],
        'rewarded_interstitial' => [
            'android' => 'ca-app-pub-3940256099942544/5354046379',
            'ios'     => 'ca-app-pub-3940256099942544/6978759866',
        ],

    ],

];
