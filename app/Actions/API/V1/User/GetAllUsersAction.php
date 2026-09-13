<?php

namespace App\Actions\API\V1\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllUsersAction
{
    /**
     * Return all users who are not driver
     * 
     * @return LengthAwarePaginator
     */
    public function execute(): LengthAwarePaginator
    {
        return User::query()
            ->with('roles')
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'Driver');
            })
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
