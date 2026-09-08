<?php

namespace App\Jobs;

use App\Events\OfferOrderToDriver;
use App\Models\DriverRoute;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

use function PHPSTORM_META\type;

class FindMatchingDriverJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Order $order
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('🔥 ABOUT TO OFFER ORDER');
        
        $matchingDriver = User::find(2);

        if (!$matchingDriver) {
            Log::warning('No matching driver');

            return;
        }

        Log::info('🔥 ABOUT TO OFFER ORDER', [
            'order_id' => $this->order->id,
            'driver_id' => $matchingDriver->id,
        ]);

        event(new OfferOrderToDriver(
            $this->order,
            $matchingDriver
        ));

        OrderNotAcceptedJob::dispatch(
            $this->order,
            $matchingDriver
        )->delay(now()->addSeconds(10));
    }
}
