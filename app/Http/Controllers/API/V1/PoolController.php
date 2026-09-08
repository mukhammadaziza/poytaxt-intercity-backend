<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\API\V1\Pools\CreatePoolAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Pools\StorePoolRequest;
use App\Http\Resources\API\V1\PoolResource;
use App\Models\Pool;
use Illuminate\Http\Request;

class PoolController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PoolResource::collection(Pool::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StorePoolRequest $storePoolRequest, 
        CreatePoolAction $createPoolAction)
    {
        
        $pool = $createPoolAction->execute($storePoolRequest->validated());

        return response()->json([
            'message' => 'Pool created successfully.',
            'pool' => $pool,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pool $pool)
    {
        return new PoolResource($pool);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pool $pool)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'number_of_seats' => ['nullable'],
            'description' => ['nullable']
        ]);

        $pool->update($validated);

        return response()->json([
            'message' => 'Pool updated successfully.',
            'pool' => $pool,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pool $pool)
    {
        $pool->delete();

        return response()->noContent();
    }
}
