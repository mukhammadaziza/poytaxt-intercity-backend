<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Price extends Model
{
    use Userstamps, 
        LogsActivity;

    protected $table = 'prices';

    protected $fillable = [
        'from_location_id',
        'to_location_id',
        'tariff_id',
        'base_price',
        'front_seat_price',
        'whole_car_price',
        'peak_time_price',
        'peak_time_start_date',
        'peak_time_end_date'
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'from_location_id',
                'to_location_id',
                'tariff_id',
                'base_price',
                'front_seat_price',
                'whole_car_price',
                'peak_time_price',
                'peak_time_start_date',
                'peak_time_end_date'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    /**
     * Price belongs to one location (route beginning)
     */
    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    /**
     * Price belongs to location (route ending)
     */
    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    /**
     * Price belongs to one tariff
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class);
    }
}
