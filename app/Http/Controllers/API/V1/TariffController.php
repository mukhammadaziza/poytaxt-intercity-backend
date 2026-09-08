<?php

namespace App\Http\Controllers\API\V1;

use App\Events\TariffUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\TariffResource;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TariffResource::collection(Tariff::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'number_of_seats' => ['nullable'],
            'description' => ['nullable'],
        ]);

        $tariff = Tariff::create([
            'name' => $validated['name'],
            'number_of_seats' => $validated['number_of_seats'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'message' => 'Tariff created successfully.',
            'tariff' => $tariff,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tariff $tariff)
    {
        return new TariffResource($tariff);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tariff $tariff)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'number_of_seats' => ['nullable'],
            'description' => ['nullable']
        ]);

        $tariff->update($validated);

                event(new TariffUpdated($tariff->fresh()));
                // broadcast(new TariffUpdated($tariff))->toOthers();


        return response()->json([
            'message' => 'Tariff updated successfully.',
            'tariff' => $tariff,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tariff $tariff)
    {
        $tariff->delete();

        return response()->noContent();
    }
}
