<?php

namespace App\Actions\API\V1\CarModel;

use App\Models\CarModel;
use Illuminate\Database\Eloquent\Collection;

class GetCarModelsAction
{
    /**
     * Get all car models
     */
    public function execute(): Collection
    {
        return CarModel::all();
    }
}
