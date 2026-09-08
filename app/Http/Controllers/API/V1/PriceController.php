<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PriceResource;
use App\Models\Location;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PriceController extends Controller
{
    public function calculatePrice1(Request $request)
    {
        // $validated = $request->validate([
        //     'from_location_id' => ['required'],
        //     'to_location_id' => ['required'],
        //     'tariff_id' => ['required'],
        // ]);
        
        $price = Price::where([
            'tariff_id' => $request->tariff_id,
            'from_location_id' => $request->from_location_id,
            'to_location_id' => $request->to_location_id,
        ])->first();
        
        Log::info([
            $request->from_location_id,
            $request->to_location_id,
            $request->tariff_id
        ]);

        if(!$price){
            $fromLocation = Location::find($request->from_location_id);
            $parentIdFromLocation = $fromLocation?->parent_id;

            $toLocation = Location::find($request->to_location_id);
            $parentIdToLocation = $toLocation?->parent_id;

            $price = Price::where([
                'tariff_id' => $request->tariff_id,
                'from_location_id' => $parentIdFromLocation,
                'to_location_id' => $parentIdToLocation,
            ])->first();

            if(empty($price)){
                return response()->json([
                    'message' => "No related price found"
                ], 404);
            }
        }
        
        return new PriceResource($price);
    }


    public function calculatePrice(Request $request)
    {
        $validated = $request->validate([
            'from_location_id' => ['required', 'integer', 'exists:locations,id'],
            'to_location_id' => ['required', 'integer', 'exists:locations,id'],
            'tariff_id' => ['required', 'integer', 'exists:tariffs,id'],
        ]);

        $fromLocationId = $validated['from_location_id'];
        $toLocationId = $validated['to_location_id'];
        $tariffId = $validated['tariff_id'];


        while ($fromLocationId && $toLocationId) {
            $price = Price::where([
                'from_location_id' => $fromLocationId,
                'to_location_id' => $toLocationId,
                'tariff_id' => $tariffId,
            ])->first();

            if ($price) {
                break;
            }

            $fromLocationId = Location::find($fromLocationId)?->parent_id;
            $toLocationId = Location::find($toLocationId)?->parent_id;
        }

        if (!$price) {
            return response()->json([
                'message' => 'No price configured for this route and tariff.',
            ], 404);
        }

        return new PriceResource($price);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = Price::with(['tariff', 'fromLocation'])->get();
        return PriceResource::collection($prices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_location_id' => ['required'],
            'to_location_id' => ['nullable'],
            'tariff_id' => ['required'],
            'base_price' => ['required', 'integer'],
            'front_seat_price' => ['required', 'integer'],
            'whole_car_price' => ['required', 'integer'],
            'peak_time_price' => ['nullable'],
            'peak_time_start_date' =>['nullable'],
            'peak_time_end_date' =>['nullable']
        ]);

        $price = Price::create([
            'from_location_id' => $validated['from_location_id'],
            'to_location_id' => $validated['to_location_id'],
            'tariff_id' => $validated['tariff_id'],
            'base_price' => $validated['base_price'],
            'front_seat_price' => $validated['front_seat_price'],
            'whole_car_price' => $validated['whole_car_price'],
            'peak_time_price' => $validated['peak_time_price'],
            'peak_time_start_date' => $validated['peak_time_start_date'],
            'peak_time_end_date' => $validated['peak_time_end_date'],
        ]);

        return response()->json([
            'message' => 'Price created successfully.',
            'price' => $price,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        return new PriceResource($price);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Price $price)
    {
        Log::info($request->all());
        $validated = $request->validate([
            'from_location_id' => ['required'],
            'to_location_id' => ['nullable'],
            'tariff_id' => ['required'],
            'base_price' => ['required', 'integer'],
            'front_seat_price' => ['required', 'integer'],
            'whole_car_price' => ['required', 'integer'],
            'peak_time_price' => ['nullable', 'integer'],
            'peak_time_start_date' =>['nullable'],
            'peak_time_end_date' =>['nullable']
        ]);

        $price->update([
            'from_location_id' => $validated['from_location_id'],
            'to_location_id' => $validated['to_location_id'],
            'tariff_id' => $validated['tariff_id'],
            'base_price' => $validated['base_price'],
            'front_seat_price' => $validated['front_seat_price'],
            'whole_car_price' => $validated['whole_car_price'],
            'peak_time_price' => $validated['peak_time_price'],
            'peak_time_start_date' => $validated['peak_time_start_date'],
            'peak_time_end_date' => $validated['peak_time_end_date'],
        ]);

        return response()->json([
            'message' => 'Price updated successfully.',
            'price' => $price,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {
        $price->delete();

        return response()->noContent();
    }
}
