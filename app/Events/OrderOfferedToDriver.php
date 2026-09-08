<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderOfferedToDriver
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public int $driverId, public array $payload) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("driver.{$this->driverId}");
    }

    public function broadcastAs(): string { return 'order.offered'; }

    public function broadcastWith(): array { return $this->payload; }
}
