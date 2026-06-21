@php
    /** @var string $slot      Named slot from config or raw ad unit ID */
    /** @var string $position  'top' or 'bottom' (default: 'bottom') */
    /** @var string $size      'adaptive', 'banner', 'large_banner', 'medium_rectangle' */
    $adUnitId = app('google-mobile-ads')->resolveAdUnitId($slot);
@endphp

@if(config('google-mobile-ads.enabled'))
<div
    x-data
    x-init="
        $nextTick(() => {
            fetch('/_native/api/call', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    method: 'GoogleMobileAds.ShowBanner',
                    params: {
                        ad_unit_id: '{{ $adUnitId }}',
                        position: '{{ $position }}',
                        size: '{{ $size }}',
                    }
                })
            });
        })
    "
    x-destroy="
        fetch('/_native/api/call', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ method: 'GoogleMobileAds.HideBanner', params: {} })
        })
    "
    style="display:none"
    aria-hidden="true"
></div>
@endif
