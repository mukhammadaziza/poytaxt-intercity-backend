<?php

namespace App\Events;

use App\Models\Tariff;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TariffUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Tariff $tariff
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('tariffs'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'tariff.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->tariff->id,
            'number_of_seats' => $this->tariff->number_of_seats,
        ];
    }
}
