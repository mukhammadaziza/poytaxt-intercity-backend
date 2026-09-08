<?php

namespace App\Actions\API\V1\Pools;

use App\Models\Pool;
use Illuminate\Support\Facades\DB;

class CreatePoolAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $data
     */
    public function execute(array $data)
    {
        return DB::transaction(function () use ($data) {

            $pool = Pool::create([
                'name' => $data['name'],
                'priority_level' => $data['priority_level'],
                'description' => $data['description'],
            ]);

            return $pool;
        });
    }
}
