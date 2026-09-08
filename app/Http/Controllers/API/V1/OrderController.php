<?php

namespace App\Http\Controllers\API\V1;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\OrderRequest;
use App\Http\Resources\API\V1\OrderResource;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\API\V1\OrderService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // event(new OrderCreated());
        return OrderResource::collection(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->createOrder($request->validated());

        return response()->json([
            'message' => 'Order created',
            'order' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
