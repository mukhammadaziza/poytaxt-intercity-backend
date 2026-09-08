<?php

namespace App\Services\API\V1;

use App\Actions\API\V1\CreateOrderAction;
use App\Events\OrderCreated;
use App\Models\Order;
use Laravel\Reverb\Loggers\Log;
use Symfony\Component\HttpFoundation\ChainRequestMatcher;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected CreateOrderAction $createOrderAction
    )
    {
        //
    }

    /**
     * Order creation
     */

    public function createOrder(array $data)
    {
        $order = $this->createOrderAction->execute($data);

        // Log::info('service');
        
        event(new OrderCreated($order));

        return $order;
    }
}
