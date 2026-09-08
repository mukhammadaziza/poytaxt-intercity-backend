<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Car extends Model
{
    use Userstamps,
        LogsActivity;

    protected $table = 'cars';

    protected $fillable = [
        'driver_id',
        'car_model_id',
        'plate_number',
        'production_year',
        'technical_pass_number'
    ];
    
    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'driver_id',
                'car_model_id',
                'plate_number',
                'production_year',
                'technical_pass_number'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    /**
     * One car can have only one driver
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One car can have only one car model
     */
    public function carModel(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }
}
