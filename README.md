# NativePHP Google Mobile Ads

Add **Google AdMob** ads to your [NativePHP Mobile](https://nativephp.com) app in minutes — no Kotlin, no Swift, no Gradle edits. Just install, configure, and start showing ads.

Supports **Banner**, **Interstitial**, **Rewarded**, **Rewarded Interstitial**, and **App Open** ad formats on both **Android** and **iOS**.

---

## Requirements

- PHP 8.2+
- Laravel 12+
- NativePHP Mobile 3+
- An [AdMob account](https://admob.google.com) (free)

> The Google Mobile Ads SDK is installed automatically on both platforms — you don't touch any native files.

---

## Installation

### Step 1 — Install the package

```bash
composer require nativephp/google-mobile-ads
```

### Step 2 — Publish the config

```bash
php artisan vendor:publish --tag=google-mobile-ads-config
```

### Step 3 — Add your AdMob IDs to `.env`

```env
# Your AdMob App IDs (one per platform — from AdMob console → Apps)
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

> **Not ready for production yet?** Use the [test IDs below](#test-ids) — they show real demo ads and never risk a policy violation.

### Step 4 — Set your iOS App ID

Open `vendor/nativephp/google-mobile-ads/nativephp.json` and replace the iOS App ID:

```json
"ios": {
    "info_plist": {
        "GADApplicationIdentifier": "ca-app-pub-XXXXXXXXXXXXXXXX~XXXXXXXXXX"
    }
}
```

> iOS will **crash on launch** if this value is wrong or missing. It must match the App ID from your AdMob console.

### Step 5 — Run native install

```bash
php artisan native:install --force
```

This automatically:
- Adds the Google Mobile Ads SDK to Android (Gradle) and iOS (CocoaPods)
- Injects the required permissions into `AndroidManifest.xml`
- Merges `GADApplicationIdentifier` and ATT tracking description into `Info.plist`

That's it. No native files to edit manually.

---

## Showing Ads

### Initialize the SDK

Call this once when your app loads — a Livewire `mount()` or a `DOMContentLoaded` listener works well.

```javascript
import { initialize } from 'vendor/nativephp/google-mobile-ads/resources/js/index.js';

document.addEventListener('DOMContentLoaded', () => initialize());
```

Or from PHP via the Facade:

```php
use NativePHP\GoogleMobileAds\Facades\GoogleMobileAds;

GoogleMobileAds::initialize();
```

---

### Banner Ads

A persistent banner that sits at the top or bottom of the screen.

```javascript
import { showBanner, hideBanner } from 'vendor/nativephp/google-mobile-ads/resources/js/index.js';

// Show a banner at the bottom of the screen
await showBanner({
    ad_unit_id: '{{ config("google-mobile-ads.banner_ad_unit_id") }}',
    position: 'bottom',  // 'top' or 'bottom'
    size: 'adaptive',    // 'adaptive', 'banner', 'large_banner', 'medium_rectangle'
});

// Remove the banner
await hideBanner();
```

---

### Interstitial Ads

Full-screen ads shown at natural transition points (between levels, after completing a task).

**Load it early, show it later:**

```javascript
import { loadInterstitial, showInterstitial } from 'vendor/nativephp/google-mobile-ads/resources/js/index.js';

// Load when the page opens (or before you need it)
await loadInterstitial({ ad_unit_id: '{{ config("google-mobile-ads.interstitial_ad_unit_id") }}' });

// Show it at the right moment
await showInterstitial();
```

Listen for the `AdLoaded` event to know when it's ready before calling `showInterstitial()`.

---

### Rewarded Ads

Users watch an ad in exchange for in-app rewards (coins, lives, hints).

```javascript
import { loadRewarded, showRewarded } from 'vendor/nativephp/google-mobile-ads/resources/js/index.js';

await loadRewarded({ ad_unit_id: '{{ config("google-mobile-ads.rewarded_ad_unit_id") }}' });
await showRewarded();
```

Handle the reward in PHP:

```php
use NativePHP\GoogleMobileAds\Events\RewardEarned;

// In a Livewire component:
protected $listeners = [
    RewardEarned::class => 'handleReward',
];

public function handleReward(RewardEarned $event): void
{
    // $event->rewardType   → e.g. "coins"
    // $event->rewardAmount → e.g. 50
    auth()->user()->increment('coins', $event->rewardAmount);
}
```

---

### Rewarded Interstitial Ads

Like rewarded ads, but shown between content without requiring the user to opt in.

```javascript
import { loadRewardedInterstitial, showRewardedInterstitial } from 'vendor/nativephp/google-mobile-ads/resources/js/index.js';

await loadRewardedInterstitial({ ad_unit_id: '{{ config("google-mobile-ads.rewarded_interstitial_ad_unit_id") }}' });
await showRewardedInterstitial();
```

The `RewardEarned` event fires when the user earns their reward, same as rewarded ads.

---

### App Open Ads

Shown when the user opens your app or returns to it from the background.

```javascript
import { loadAppOpen, showAppOpen } from 'vendor/nativephp/google-mobile-ads/resources/js/index.js';

// Load on app start
await loadAppOpen({ ad_unit_id: '{{ config("google-mobile-ads.app_open_ad_unit_id") }}' });

// Show when ready
await showAppOpen();
```

---

## Listening to Events

All events are standard Laravel events. Use them in Livewire, event listeners, or queued jobs.

| Event | Properties | When it fires |
|---|---|---|
| `AdLoaded` | `$adType`, `$adUnitId` | Ad finished loading and is ready to show |
| `AdFailedToLoad` | `$adType`, `$adUnitId`, `$errorCode`, `$errorMessage` | Ad failed to load |
| `AdOpened` | `$adType` | Full-screen ad appeared |
| `AdClosed` | `$adType` | Full-screen ad was dismissed |
| `AdImpression` | `$adType` | Ad recorded an impression |
| `AdClicked` | `$adType` | User tapped an ad |
| `RewardEarned` | `$rewardType`, `$rewardAmount` | User completed a rewarded ad |

`$adType` is one of: `banner`, `interstitial`, `rewarded`, `rewarded_interstitial`, `app_open`

### Example: pre-load the next interstitial after one is dismissed

```php
use NativePHP\GoogleMobileAds\Events\AdLoaded;
use NativePHP\GoogleMobileAds\Events\AdClosed;

protected $listeners = [
    AdLoaded::class => 'onAdLoaded',
    AdClosed::class => 'onAdClosed',
];

public function onAdLoaded(AdLoaded $event): void
{
    $this->adReady = true;
}

public function onAdClosed(AdClosed $event): void
{
    if ($event->adType === 'interstitial') {
        $this->loadNextInterstitial();
    }
}
```

---

## Test IDs

Use these during development and testing. They show real demo ads so you can verify everything works without risking an AdMob policy violation.

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

**Android test App ID:** `ca-app-pub-3940256099942544~3347511713`

### iOS

| Format | Test Ad Unit ID |
|---|---|
| App Open | `ca-app-pub-3940256099942544/5575463023` |
| Banner | `ca-app-pub-3940256099942544/2934735716` |
| Interstitial | `ca-app-pub-3940256099942544/4411468910` |
| Rewarded | `ca-app-pub-3940256099942544/1712485313` |
| Rewarded Interstitial | `ca-app-pub-3940256099942544/6978759866` |
| Native | `ca-app-pub-3940256099942544/3986624511` |

**iOS test App ID:** `ca-app-pub-3940256099942544~1458002511`

> Test ads only work on real devices. **iOS Simulator does not support the Google Mobile Ads SDK** — use a physical iPhone. Android emulators work if the AVD uses a **Google APIs** system image.

---

## Going to Production

When you're ready to publish your app:

1. Replace all test IDs in `.env` with your real Ad Unit IDs from the [AdMob console](https://admob.google.com).
2. Update the iOS App ID in `vendor/nativephp/google-mobile-ads/nativephp.json` to your real iOS App ID.
3. Run `php artisan native:install --force` to rebuild native configurations.
4. Build your release: `php artisan native:run android --release` or `php artisan native:run ios`.

---

## Troubleshooting

**App crashes on iOS launch**
Your `GADApplicationIdentifier` is wrong or missing. Open `vendor/nativephp/google-mobile-ads/nativephp.json`, set the correct iOS App ID under `ios.info_plist.GADApplicationIdentifier`, then run `php artisan native:install --force`.

**Ads are not showing**
- Make sure you called `initialize()` before requesting any ads.
- For interstitial, rewarded, and app open — you must call `load*()` and wait for the `AdLoaded` event before calling `show*()`.
- Test ads don't work on iOS Simulator. Use a real device.
- On Android emulator, only **Google APIs** AVD images support ads (not plain Android or Google Play images).

**`No interstitial ad loaded` error**
You called `showInterstitial()` before the ad finished loading. Listen for the `AdLoaded` event first, or add a delay.

**Changes not showing after editing config**
Run `php artisan native:install --force` followed by `php artisan native:run android` or `php artisan native:run ios`.

**Validate plugin setup**
```bash
php artisan native:plugin:validate
```

---

## License

MIT
