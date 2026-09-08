<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class CarModel extends Model
{
    use Userstamps,
        LogsActivity;

    protected $table = 'car_models';

    protected $fillable = [
        'name',
        'description',
        'seats'
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'seats'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
