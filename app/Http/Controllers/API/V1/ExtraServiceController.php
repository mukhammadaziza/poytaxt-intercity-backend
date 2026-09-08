<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\ExtraServiceResource;
use App\Models\ExtraService;
use Illuminate\Http\Request;

class ExtraServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ExtraServiceResource::collection(ExtraService::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'price' => ['required'],
            'description' => ['nullable'],
        ]);

        $extraService = ExtraService::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'message' => 'Extra service created successfully.',
            'extraService' => $extraService,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExtraService $tariff)
    {
        return new ExtraServiceResource($tariff);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExtraService $extraService)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'price' => ['required'],
            'description' => ['nullable']
        ]);

        $extraService->update($validated);

        return response()->json([
            'message' => 'Extra service updated successfully.',
            'extraService' => $extraService,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExtraService $extraService)
    {
        $extraService->delete();

        return response()->noContent();
    }
}
