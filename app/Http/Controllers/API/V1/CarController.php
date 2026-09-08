<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\API\V1\Cars\CreateCarAction;
use App\Actions\API\V1\Cars\DeleteCarAction;
use App\Actions\API\V1\Cars\UpdateCarAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Cars\DestroyCarRequest;
use App\Http\Requests\API\V1\Cars\ShowCarRequest;
use App\Http\Requests\API\V1\Cars\StoreCarRequest;
use App\Http\Requests\API\V1\Cars\UpdateCarRequest;
use App\Http\Resources\API\V1\CarResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return CarResource::collection(Car::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreCarRequest $storeCarRequest,
        CreateCarAction $createCarAction
    ): JsonResponse
    {
        $car = $createCarAction->execute($storeCarRequest->validated());

        return response()->json([
            'message' => 'Car created succesfully',
            'data' => new CarResource($car)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(
        ShowCarRequest $showCarRequest, 
        Car $car
    ): JsonResponse
    {
        return new CarResource($car)->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCarRequest $updateCarRequest,
        Car $car,
        UpdateCarAction $updateCarAction
    ): JsonResponse
    {

        $car = $updateCarAction->execute($updateCarRequest->validated(), $car);

        return response()->json([
            'message' => 'Car updated succesfully',
            'data' => new CarResource($car)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        DestroyCarRequest $destroyCarRequest,
        Car $car,
        DeleteCarAction $deleteCarAction
    ): Response
    {
        $deleteCarAction->execute($car);

        return response()->noContent();
    }
}
