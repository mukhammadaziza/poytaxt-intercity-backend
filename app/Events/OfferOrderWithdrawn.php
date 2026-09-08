<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferOrderWithdrawn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public int $driverId, public int $orderId) {}

    public function broadcastOn(): PrivateChannel { return new PrivateChannel("driver.{$this->driverId}"); }
    public function broadcastAs(): string { return 'order.withdrawn'; }
    public function broadcastWith(): array { return ['order_id' => $this->orderId]; }
}
