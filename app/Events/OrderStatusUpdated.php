<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Order $order) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('dispatch-board');
    }

    public function broadcastAs(): string { return 'order.status.updated'; }

    public function broadcastWith(): array
    {
        return ['order_id' => $this->order->id, 'status' => $this->order->status];
    }
}
