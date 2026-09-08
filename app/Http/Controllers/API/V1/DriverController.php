<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\API\V1\Driver\GetDriverAction;
use App\Actions\API\V1\Driver\GetDriverOrdersAction;
use App\Actions\API\V1\Driver\GetDriversAction;
use App\Actions\API\V1\Driver\UpdateDriverAction;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Drivers\GetDriverOrdersRequest;
use App\Http\Requests\API\V1\Drivers\IndexDriverRequest;
use App\Http\Requests\API\V1\Drivers\ShowDriverRequest;
use App\Http\Requests\API\V1\Drivers\StoreDriverRequest;
use App\Http\Requests\API\V1\Drivers\UpdateDriverRequest;
use App\Http\Resources\API\V1\DriverResource;
use App\Http\Resources\API\V1\OrderResource;
use App\Models\Order;
use App\Models\User;
use App\Services\API\V1\DriverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DriverController extends Controller
{
    public function index(
        IndexDriverRequest $indexDriverRequest,
        GetDriversAction $getDriversAction
    ): JsonResponse
    {
        $drivers = $getDriversAction->execute($indexDriverRequest->validated());
        
        return DriverResource::collection($drivers)->response();
    }

    public function store(
        StoreDriverRequest $storeDriverRequest,
        DriverService $driverService
    ): JsonResponse
    {
        Log::info('sd');
        
        $driver = $driverService->createDriver($storeDriverRequest->validated());

        return response()->json([
            'message' => 'Driver created successfully.',
            'driver' => $driver,
        ], 201);

    }

    /**
     * 
     */
    public function show(
        ShowDriverRequest $showDriverRequest, 
        GetDriverAction $getDriverAction,
        User $driver)
    {
        $driver = $getDriverAction->execute($driver);

        return new DriverResource($driver);
    }

    public function update(
        UpdateDriverRequest $updateDriverRequest, 
        User $user,
        UpdateDriverAction $updateDriverAction
    )
    {
        $validated = $updateDriverRequest->validated();

        // only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']); // remove it so current password stays
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully.',
            'user'    => $user,
        ], 200);
    }

    public function deactivateUser(User $user)
    {
        $user->update([
            'status' => UserStatus::NonActive->value
        ]);
        
        // writing to driver_logs table when driver is deactivated but when regular dispatcher deactivated where it is gong to be written and how can I know that it is driver deactivated or regular disatcher if he has both roles

        return response()->json([
            'message' => 'User deactivated successfully'
        ], 200);
    }

    public function activateUser(User $user)
    {
        $user->update([
            'status' => UserStatus::Active->value
        ]);
        
        return response()->json([
            'message' => 'User activated successfully'
        ], 200);
    }

    public function blockUserByDate(Request $request, User $user)
    {
        $validated = $request->validate([
            'comment' => ['required'],
            'blocked_until' => ['required']
        ]);

        $user->update([
            'status' => UserStatus::Blocked->value
        ]);
        
        return response()->json([
            'message' => 'User blocked successfully'
        ], 200);
    }

    public function unblockUser(User $user)
    {
        $user->update([
            'status' => UserStatus::Active->value
        ]);
        
        return response()->json([
            'message' => 'User unblocked successfully'
        ], 200);
    }

    /**
     * Get drivers order history
     */
    public function orders(
        GetDriverOrdersRequest $getDriverOrdersRequest, 
        GetDriverOrdersAction $getDriverOrdersAction,
        User $driver)
    {
        $orders = $getDriverOrdersAction->execute($driver);

        return new OrderResource($orders);
    }
    /**
     * 
     */
    public function dashboard()
    {
        return OrderResource::collection(Order::all());
    }
}
