<?php

namespace App\Actions\API\V1\Driver;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetDriversAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function execute(array $data): LengthAwarePaginator
    {
        return User::query()
            ->role('Driver')
            ->with('car')
            ->when($data['search'] ?? null, function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->orWhere('name', 'ilike', "%{$search}%")
                            ->orWhere('surname', 'ilike', "%{$search}%")
                            ->orWhereHas('car', function ($query) use ($search) {
                                $query->where('plate_number', 'ilike', "%{$search}%");
                            });
                    });
                })->paginate($data['per_page'] ?? 15)->withQueryString();
    }
}
