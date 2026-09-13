<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\CarController;
use App\Http\Controllers\API\V1\CarModelController;
use App\Http\Controllers\API\V1\DriverController;
use App\Http\Controllers\API\V1\DriverRouteController;
use App\Http\Controllers\API\V1\ExtraServiceController;
use App\Http\Controllers\API\V1\LocationController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\PoolController;
use App\Http\Controllers\API\V1\PriceController;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\TariffController;
use App\Http\Controllers\API\V1\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/login',    [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        // Route::get('/', [AuthController::class, 'welcome']);
        // Route::apiResource('users', UserController::class);
        // Users
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/get-user-by-phone', [UserController::class, 'getUserByPhone']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::post('/users/{user}/deactivate', [UserController::class, 'deactivateUser']);
        Route::post('/users/{user}/activate', [UserController::class, 'activateUser']);
        Route::post('/users/{user}/blockUserByDate', [UserController::class, 'blockUserByDate']);
        Route::post('/users/{user}/blockForever', [UserController::class, 'blockForever']);
        
        // Roles
        Route::get('/roles', [RoleController::class, 'index']);
        Route::get('/roles/{role}', [RoleController::class, 'show']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::put('/roles/{role}', [RoleController::class, 'update']);
        Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

        // Locations
        Route::get('/locations', [LocationController::class, 'index']);
        Route::get('/locations/{location}', [LocationController::class, 'show']);
        Route::post('/locations', [LocationController::class, 'store']);
        Route::put('/locations/{location}', [LocationController::class, 'update']);
        Route::delete('/locations/{location}', [LocationController::class, 'destroy']);

        // Tariffs
        Route::get('/tariffs', [TariffController::class, 'index']);
        Route::get('/tariffs/{tariff}', [TariffController::class, 'show']);
        Route::post('/tariffs', [TariffController::class, 'store']);
        Route::put('/tariffs/{tariff}', [TariffController::class, 'update']);
        Route::delete('/tariffs/{tariff}', [TariffController::class, 'destroy']);

        // Pools
        Route::get('/pools', [PoolController::class, 'index']);
        Route::get('/pools/{pool}', [PoolController::class, 'show']);
        Route::post('/pools', [PoolController::class, 'store']);
        Route::put('/pools/{pool}', [PoolController::class, 'update']);
        Route::delete('/pools/{pool}', [PoolController::class, 'destroy']);

         // Cars
        Route::get('/cars', [CarController::class, 'index']);
        Route::get('/cars/{car}', [CarController::class, 'show']);
        Route::post('/cars', [CarController::class, 'store']);
        Route::put('/cars/{car}', [CarController::class, 'update']);
        Route::delete('/cars/{car}', [CarController::class, 'destroy']);

        // Prices
        Route::get('/prices', [PriceController::class, 'index']);
        Route::get('/prices/{price}', [PriceController::class, 'show']);
        Route::post('/prices', [PriceController::class, 'store']);
        Route::put('/prices/{price}', [PriceController::class, 'update']);
        Route::delete('/prices/{price}', [PriceController::class, 'destroy']);
        Route::post('/calculate-price', [PriceController::class, 'calculatePrice']);

        // Extra services
        Route::get('/extra-services', [ExtraServiceController::class, 'index']);
        Route::get('/extra-services/{extraService}', [ExtraServiceController::class, 'show']);
        Route::post('/extra-services', [ExtraServiceController::class, 'store']);
        Route::put('/extra-services/{extraService}', [ExtraServiceController::class, 'update']);
        Route::delete('/extra-services/{extraService}', [ExtraServiceController::class, 'destroy']);

        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::put('/orders/{order}', [OrderController::class, 'update']);
        Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

        // Car models
        Route::get('/car-models', [CarModelController::class, 'index']);
        Route::get('/car-models/{carModel}', [CarModelController::class, 'show']);
        Route::post('/car-models', [CarModelController::class, 'store']);
        Route::put('/car-models/{carModel}', [CarModelController::class, 'update']);
        Route::delete('/car-models/{carModel}', [CarModelController::class, 'destroy']);

        // Drivers app
        Route::prefix('driver')->group(function () {
            Route::get('/dashboard', [DriverController::class, 'dashboard']);
            Route::post('/rides/{order}/accept', [DriverController::class, 'acceptRide']);
            Route::post('/create-route', [DriverRouteController::class, 'createRoute']);
        });


         // Driver controller
        Route::get('/drivers', [DriverController::class, 'index']);
        Route::get('/drivers/{driver}', [DriverController::class, 'show']);
        Route::post('/drivers', [DriverController::class, 'store']);
        Route::put('/drivers/{driver}', [DriverController::class, 'update']);
        Route::delete('/drivers/{driver}', [DriverController::class, 'destroy']);

        Route::get('/drivers/{driver}/orders', [DriverController::class, 'orders']);
        Route::get('/drivers/{driver}/activities', [DriverController::class, 'activities']);

    });
});