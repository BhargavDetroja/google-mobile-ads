<?php

namespace NativePHP\GoogleMobileAds\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RewardEarned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly string $rewardType,
        public readonly int $rewardAmount,
    ) {}
}
