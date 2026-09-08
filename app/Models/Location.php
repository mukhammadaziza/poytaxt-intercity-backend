<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Location extends Model
{
    use SoftDeletes,
        Userstamps,
        LogsActivity;

    protected $table = 'locations';

    protected $fillable = [
        'name',
        'type',
        'latitude',
        'longitude',
        'parent_id'
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'type',
                'latitude',
                'longitude',
                'parent_id'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    /**
     * Location has parent
     */
    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    /**
     * Location has children
     */
    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    /**
     * Location has many prices (route beginning)
     */
    public function fromPrices()
    {
        return $this->hasMany(Price::class, 'from_location_id');
    }

    /**
     * Location has many prices (route ending)
     */
    public function toPrices()
    {
        return $this->hasMany(Price::class, 'to_location_id');
    }

    /**
     * Orders from locations
     */
    public function ordersFrom()
    {
        return $this->hasMany(Order::class, 'from_location_id');
    }


    /**
     * Orders to locations
     */
    public function ordersTo()
    {
        return $this->hasMany(Order::class, 'to_location_id');
    }
}
