<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class DriverRoute extends Model
{
    use Userstamps,
        LogsActivity;

    protected $table = 'driver_routes';

    protected $fillable = [
        'driver_id',
        'from_location_id',
        'to_location_id',
        'start_time',
        'end_time',
        'seats',
        'occupied_seats'
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'driver_id',
                'from_location_id',
                'to_location_id',
                'start_time',
                'end_time',
                'seats',
                'occupied_seats'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'occupied_seats' => 'array'
        ];
    }

    /**
     * Route beginning belongs to one location (route beginning)
     */
    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    /**
     * Driver route ending belongs to one location (route ending)
     */
    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    /**
     * Driver belongs to one user
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
