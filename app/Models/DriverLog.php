<?php

namespace App\Models;

use App\Enums\DriverLogStatus;
use Illuminate\Database\Eloquent\Model;

class DriverLog extends Model
{
    /**
     * Related table
     */
    protected $table = 'driver_logs';

    /**
     * Fillable properities
     */
    protected $fillable = [
        'driver_id',
        'status',
        'details'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => DriverLogStatus::class,
            'details' => 'array'
        ];
    }
}
