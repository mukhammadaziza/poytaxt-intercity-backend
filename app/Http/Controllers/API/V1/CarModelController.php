<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\API\V1\CarModel\StoreCarModelAction;
use App\Actions\API\V1\CarModels\CreateCarModelAction;
use App\Actions\API\V1\CarModels\DeleteCarModelAction;
use App\Actions\API\V1\CarModels\UpdateCarModelAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CarModels\DeleteCarModelRequest;
use App\Http\Requests\API\V1\CarModels\IndexCarModelRequest;
use App\Http\Requests\API\V1\CarModels\ShowCarModelRequest;
use App\Http\Requests\API\V1\CarModels\StoreCarModelRequest;
use App\Http\Requests\API\V1\CarModels\UpdateCarModelRequest;
use App\Http\Resources\API\V1\CarModelsResource;
use App\Models\CarModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CarModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexCarModelRequest $indexCarModelRequest): JsonResource
    {
        return CarModelsResource::collection(CarModel::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreCarModelRequest $storeCarModelRequest,
        CreateCarModelAction $createCarModelAction 
    ): JsonResponse
    {
        $carModel = $createCarModelAction->execute($storeCarModelRequest->validated());

        return response()->json([
            'message' => 'Car model created successfully.',
            'data' => new CarModelsResource($carModel)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(
        ShowCarModelRequest $showCarModelRequest,
        CarModel $carModel
    ): JsonResponse
    {
        return new CarModelsResource($carModel)->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateCarModelRequest $updateCarModelRequest, 
        CarModel $carModel,
        UpdateCarModelAction $updateCarModelAction
    ): JsonResponse
    {
        $carModel = $updateCarModelAction->execute($updateCarModelRequest->validated(), $carModel);

        return response()->json([
            'message' => 'Car model updated successfully.',
            'data' => new CarModelsResource($carModel)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        DeleteCarModelRequest $deleteCarModelRequest,
        CarModel $carModel,
        DeleteCarModelAction $deleteCarModelAction
    ): Response
    {
        $deleteCarModelAction->execute($carModel);

        return response()->noContent();
    }
}
