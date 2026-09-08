<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Tariff extends Model
{
    use SoftDeletes,
        Userstamps,
        LogsActivity;

    protected $table = 'tariffs';

    protected $fillable = [
        'name',
        'number_of_seats',
        'description'
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'number_of_seats',
                'description'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
    /**
     * One tariff has many prices
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    /**
     * One tariff can be associated to several drivers
     */
    public function drivers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'driver_tariff', 'tariff_id', 'driver_id');
    }
}
