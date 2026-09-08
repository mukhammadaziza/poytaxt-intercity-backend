<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Jobs\FindMatchingDriverJob;
use App\Models\DriverRoute;
use App\Services\API\V1\DrivingMatchingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class FindMatchingDriver
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event, DrivingMatchingService $drivingMatching): void
    {
        $drivingMatching->matchDriver();
        FindMatchingDriverJob::dispatch($event->order);
    }
}
