<?php

namespace App\Jobs;

use App\Events\OfferOrderToDriver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OrderNotAcceptedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order,
        public User $matchingDriver
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $nextDriver = User::find(3);

        event(new OfferOrderToDriver(
            $this->order,
            $nextDriver
        ));
    }
}
