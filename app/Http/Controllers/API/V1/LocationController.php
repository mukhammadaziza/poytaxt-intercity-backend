<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LocationResource::collection(Location::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'type' => ['required'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
            'parent_id' => ['nullable'],
        ]);
        
        $location = Location::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'parent_id' => $validated['parent_id']
        ]);

        return response()->json([
            'message' => 'Location created succesfully',
            'location' => $location
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return new LocationResource($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'type' => ['required'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
            'parent_id' => ['nullable']
        ]);


        $location->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'parent_id' => $validated['parent_id']
        ]);

        return response()->json([
            'message' => 'Location updated succesfully',
            'location' => $location
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return response()->noContent();
    }
}
