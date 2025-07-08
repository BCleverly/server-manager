<?php

declare(strict_types=1);

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserLeft implements ShouldBroadcast
{
    use SerializesModels;

    public array $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        return [new Channel('GlobalChat')];
    }
} 