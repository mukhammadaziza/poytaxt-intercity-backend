<?php

namespace App\Http\Controllers\API\V1;

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CreateRouteRequest;
use App\Models\DriverRoute;
use App\Models\Order;
use App\Services\API\V1\DriverRouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverRouteController extends Controller
{
    /**
     * 
     */
    public function createRoute(CreateRouteRequest $createRouteRequest, DriverRouteService $driverRouteService)
    {
        $driverRoute = $driverRouteService->createRoute($createRouteRequest->validated());

        return response()->json([
            'message' => 'Route created for driver',
            'route' => $driverRoute
        ], 201);
    }

    // app/Http/Controllers/Api/V1/DriverRouteController.php
public function acceptOrder(Order $order)
{
    $this->authorize('driver-accept-order');

    DB::transaction(function () use ($order) {
        $route = DriverRoute::where('id', $order->driver_route_id ?? request('driver_route_id'))
            ->lockForUpdate()
            ->first();

        if (! $route->hasAvailableSeat($order->seat_type)) {
            throw new NotEnoughSeatsException('This seat is no longer available.');
        }

        $occupied = collect($route->occupied_seats)
            ->push(['type' => $order->seat_type, 'order_id' => $order->id])
            ->values();

        $route->update(['occupied_seats' => $occupied]);

        $order->update([
            'status' => 'assigned',
            'driver_route_id' => $route->id,
        ]);

        // tell the accepting driver, tell the dispatcher, withdraw from everyone else
        broadcast(new OrderStatusUpdated($order));

        foreach ($order->offered_driver_ids as $driverId) {
            if ($driverId !== $route->driver_id) {
                broadcast(new OrderOfferWithdrawn($driverId, $order->id));
            }
        }
    });

    return response()->json(['message' => 'Order accepted']);
}
}
