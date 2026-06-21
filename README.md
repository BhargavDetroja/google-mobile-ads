# NativePHP Google Mobile Ads

Add **Google AdMob** ads to your [NativePHP Mobile](https://nativephp.com) app in minutes — no Kotlin, no Swift, no Gradle edits. Just install, configure, and start showing ads.

Works with **any frontend stack** — Livewire, React, Vue, Alpine.js, or plain JavaScript.

Supports **Banner**, **Interstitial**, **Rewarded**, **Rewarded Interstitial**, and **App Open** ad formats on both **Android** and **iOS**.

---

## Requirements

- PHP 8.2+
- Laravel 12+
- NativePHP Mobile 3+
- An [AdMob account](https://admob.google.com) (free)

> The Google Mobile Ads SDK is installed automatically on both platforms — no native files to edit.

---

## Installation

### Step 1 — Install the package

```bash
composer require bhargavdetroja/nativephp-google-mobile-ads
```

### Step 2 — Publish the config

```bash
php artisan vendor:publish --tag=google-mobile-ads-config
```

### Step 3 — Add your AdMob IDs to `.env`

```env
# Your AdMob App ID (from AdMob console → Apps)
ADMOB_APP_ID=ca-app-pub-XXXXXXXXXXXXXXXX~XXXXXXXXXX

# Ad Unit IDs
ADMOB_BANNER_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
ADMOB_INTERSTITIAL_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
ADMOB_REWARDED_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
ADMOB_REWARDED_INTERSTITIAL_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
ADMOB_APP_OPEN_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
ADMOB_ANCHORED_ADAPTIVE_BANNER_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
ADMOB_INLINE_ADAPTIVE_BANNER_AD_UNIT_ID=ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX
```

> Not ready for real IDs yet? Use the [test IDs below](#test-ids) — they show demo ads and never risk a policy violation.

### Step 4 — Set your iOS App ID

Open `vendor/bhargavdetroja/nativephp-google-mobile-ads/nativephp.json` and replace the iOS App ID:

```json
"ios": {
    "info_plist": {
        "GADApplicationIdentifier": "ca-app-pub-XXXXXXXXXXXXXXXX~XXXXXXXXXX"
    }
}
```

> iOS will **crash on launch** if this is missing or wrong. It must be your real iOS App ID from AdMob.

### Step 5 — Run native install

```bash
php artisan native:install --force
```

This automatically adds the SDK to Android and iOS, injects permissions, and merges the required `Info.plist` keys. No manual native file edits.

---

## Showing Ads

Import the JS bridge functions wherever your frontend lives — Blade, a React component, a Vue component, or a plain JS file.

```javascript
import {
    initialize,
    showBanner, hideBanner,
    loadInterstitial, showInterstitial,
    loadRewarded, showRewarded,
    loadRewardedInterstitial, showRewardedInterstitial,
    loadAppOpen, showAppOpen,
    onAdLoaded, onAdClosed, onRewardEarned,
} from 'vendor/bhargavdetroja/nativephp-google-mobile-ads/resources/js/index.js';
```

### Initialize the SDK

Call once when your app loads.

```javascript
document.addEventListener('DOMContentLoaded', () => initialize());
```

---

### Banner Ads

```javascript
// Show a banner at the bottom (stays visible until you hide it)
await showBanner({
    ad_unit_id: 'ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX',
    position: 'bottom',   // 'top' or 'bottom'
    size: 'adaptive',     // 'adaptive', 'banner', 'large_banner', 'medium_rectangle'
});

// Remove the banner
await hideBanner();
```

---

### Interstitial Ads

Full-screen ads shown at natural breaks (between levels, after completing a task). Always load before showing.

```javascript
// Load early so it's ready when you need it
await loadInterstitial({ ad_unit_id: 'ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX' });

// Wait for it to be ready, then show
const unsubscribe = onAdLoaded(({ adType }) => {
    if (adType === 'interstitial') {
        unsubscribe();
        showInterstitial();
    }
});
```

---

### Rewarded Ads

Users watch an ad to earn in-app rewards (coins, lives, hints).

```javascript
await loadRewarded({ ad_unit_id: 'ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX' });
await showRewarded();

// Listen for the reward — works in any framework
onRewardEarned(({ rewardType, rewardAmount }) => {
    console.log(`User earned ${rewardAmount} ${rewardType}`);
    // Update UI, call your API, etc.
});
```

---

### Rewarded Interstitial Ads

Like rewarded ads but shown between content — no opt-in required from the user.

```javascript
await loadRewardedInterstitial({ ad_unit_id: 'ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX' });
await showRewardedInterstitial();

onRewardEarned(({ rewardType, rewardAmount }) => {
    console.log(`User earned ${rewardAmount} ${rewardType}`);
});
```

---

### App Open Ads

Shown when the user opens your app or returns from the background.

```javascript
await loadAppOpen({ ad_unit_id: 'ca-app-pub-XXXXXXXXXXXXXXXX/XXXXXXXXXX' });
await showAppOpen();
```

---

## Listening to Events

Ad events fire in two ways — use whichever fits your stack.

### Option 1 — JavaScript (works everywhere)

Use the built-in helper functions from the JS bridge. They listen to DOM `CustomEvent` dispatches from the native layer.

```javascript
import { onAdLoaded, onAdClosed, onRewardEarned, onAdEvent } from '...';

// Convenience helpers
const stop = onAdLoaded(({ adType, adUnitId }) => {
    console.log(`${adType} ad is ready`);
});

onAdClosed(({ adType }) => {
    if (adType === 'interstitial') loadInterstitial({ ad_unit_id: '...' }); // pre-load next
});

onRewardEarned(({ rewardType, rewardAmount }) => {
    grantUserReward(rewardType, rewardAmount);
});

// Call stop() to remove a listener
stop();

// Listen to any ad event by its full class name
onAdEvent('NativePHP\\GoogleMobileAds\\Events\\AdFailedToLoad', ({ adType, errorMessage }) => {
    console.error(`${adType} failed: ${errorMessage}`);
});
```

**React example:**

```jsx
import { useEffect } from 'react';
import { loadRewarded, showRewarded, onRewardEarned, onAdLoaded } from '...';

export default function RewardButton() {
    useEffect(() => {
        loadRewarded({ ad_unit_id: 'ca-app-pub-...' });

        const stopLoaded = onAdLoaded(({ adType }) => {
            if (adType === 'rewarded') setAdReady(true);
        });

        const stopReward = onRewardEarned(({ rewardAmount }) => {
            addCoins(rewardAmount);
        });

        return () => { stopLoaded(); stopReward(); }; // clean up on unmount
    }, []);

    return <button onClick={showRewarded}>Watch ad for coins</button>;
}
```

**Vue example:**

```vue
<script setup>
import { onMounted, onUnmounted } from 'vue';
import { loadRewarded, showRewarded, onRewardEarned } from '...';

let stopReward;

onMounted(() => {
    loadRewarded({ ad_unit_id: 'ca-app-pub-...' });
    stopReward = onRewardEarned(({ rewardAmount }) => addCoins(rewardAmount));
});

onUnmounted(() => stopReward?.());
</script>

<template>
    <button @click="showRewarded">Watch ad for coins</button>
</template>
```

**Alpine.js example:**

```html
<div x-data="{
    init() {
        loadRewarded({ ad_unit_id: 'ca-app-pub-...' });
        onRewardEarned(({ rewardAmount }) => this.coins += rewardAmount);
    },
    coins: 0
}">
    <button @click="showRewarded()">Watch ad — you have <span x-text="coins"></span> coins</button>
</div>
```

---

### Option 2 — PHP / Laravel (server-side)

Ad events are also standard Laravel events, dispatched from native code to your backend. Use them in event listeners, queued jobs, or Livewire components.

**Any Laravel listener:**

```bash
php artisan make:listener GrantRewardOnAdWatched
```

```php
use NativePHP\GoogleMobileAds\Events\RewardEarned;
use Illuminate\Contracts\Queue\ShouldQueue;

class GrantRewardOnAdWatched implements ShouldQueue
{
    public function handle(RewardEarned $event): void
    {
        // $event->rewardType   → e.g. "coins"
        // $event->rewardAmount → e.g. 50
        auth()->user()->increment('coins', $event->rewardAmount);
    }
}
```

Register it in `AppServiceProvider`:

```php
use Illuminate\Support\Facades\Event;

Event::listen(RewardEarned::class, GrantRewardOnAdWatched::class);
```

**Livewire component:**

```php
use NativePHP\GoogleMobileAds\Events\AdLoaded;
use NativePHP\GoogleMobileAds\Events\AdClosed;
use NativePHP\GoogleMobileAds\Events\RewardEarned;

protected $listeners = [
    AdLoaded::class    => 'onAdLoaded',
    AdClosed::class    => 'onAdClosed',
    RewardEarned::class => 'onRewardEarned',
];

public function onAdLoaded(AdLoaded $event): void { /* ... */ }
public function onAdClosed(AdClosed $event): void { /* ... */ }
public function onRewardEarned(RewardEarned $event): void
{
    auth()->user()->increment('coins', $event->rewardAmount);
}
```

---

## All Events

| Event class | Properties | When it fires |
|---|---|---|
| `AdLoaded` | `$adType`, `$adUnitId` | Ad finished loading and is ready to show |
| `AdFailedToLoad` | `$adType`, `$adUnitId`, `$errorCode`, `$errorMessage` | Ad failed to load |
| `AdOpened` | `$adType` | Full-screen ad appeared on screen |
| `AdClosed` | `$adType` | Full-screen ad was dismissed |
| `AdImpression` | `$adType` | Ad recorded an impression |
| `AdClicked` | `$adType` | User tapped an ad |
| `RewardEarned` | `$rewardType`, `$rewardAmount` | User completed a rewarded ad |

`$adType` is one of: `banner`, `interstitial`, `rewarded`, `rewarded_interstitial`, `app_open`

---

## Test IDs

Use these during development. They display real demo ads — no policy risk.

### Android

| Format | Test Ad Unit ID |
|---|---|
| App Open | `ca-app-pub-3940256099942544/9257395921` |
| Adaptive Banner | `ca-app-pub-3940256099942544/9214589741` |
| Fixed Banner | `ca-app-pub-3940256099942544/6300978111` |
| Interstitial | `ca-app-pub-3940256099942544/1033173712` |
| Rewarded | `ca-app-pub-3940256099942544/5224354917` |
| Rewarded Interstitial | `ca-app-pub-3940256099942544/5354046379` |
| Native | `ca-app-pub-3940256099942544/2247696110` |

Android test App ID: `ca-app-pub-3940256099942544~3347511713`

### iOS

| Format | Test Ad Unit ID |
|---|---|
| App Open | `ca-app-pub-3940256099942544/5575463023` |
| Banner | `ca-app-pub-3940256099942544/2934735716` |
| Interstitial | `ca-app-pub-3940256099942544/4411468910` |
| Rewarded | `ca-app-pub-3940256099942544/1712485313` |
| Rewarded Interstitial | `ca-app-pub-3940256099942544/6978759866` |
| Native | `ca-app-pub-3940256099942544/3986624511` |

iOS test App ID: `ca-app-pub-3940256099942544~1458002511`

> Test ads only work on **real devices**. iOS Simulator does not support the Google Mobile Ads SDK. Android emulators must use a **Google APIs** system image (not plain Android or Google Play images).

---

## Going to Production

1. Replace all test IDs in `.env` with your real Ad Unit IDs from the [AdMob console](https://admob.google.com).
2. Update `vendor/bhargavdetroja/nativephp-google-mobile-ads/nativephp.json` with your real iOS App ID.
3. Run `php artisan native:install --force` to rebuild native configurations.

---

## Troubleshooting

**App crashes on iOS launch**
Your `GADApplicationIdentifier` is wrong or missing. Open `vendor/bhargavdetroja/nativephp-google-mobile-ads/nativephp.json`, set the correct iOS App ID, then run `php artisan native:install --force`.

**Ads are not showing**
- Make sure you called `initialize()` before requesting any ads.
- For interstitial, rewarded, and app open — you must call `load*()` and wait for `AdLoaded` before calling `show*()`.
- Test ads do not work on iOS Simulator — use a real device.
- On Android emulator, use a **Google APIs** AVD image.

**`No interstitial ad loaded` error**
You called `showInterstitial()` before the ad finished loading. Wait for the `AdLoaded` event with `adType === 'interstitial'` before calling show.

**Changes not showing after editing `.env`**
Run `php artisan native:install --force` then `php artisan native:run android` or `php artisan native:run ios`.

**Validate plugin setup**
```bash
php artisan native:plugin:validate
```

---

## License

MIT
