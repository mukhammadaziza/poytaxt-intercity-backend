<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Pool extends Model
{
    use SoftDeletes,
        Userstamps,
        LogsActivity;

    protected $table = 'pools';

    protected $fillable = [
        'name',
        'priority_level',
        'price',
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
                'priority_level',
                'price',
                'description'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    /**
     * Pool has many driver profiles
     */
    public function driverProfiles()
    {
        return $this->hasMany(DriverProfile::class);
    }
}
