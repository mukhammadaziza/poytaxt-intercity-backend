<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ExtraService extends Model
{
    use Userstamps,
        LogsActivity;
    
    protected $table = 'extra_services';

    protected $fillable = [
        'name',
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
                'price',
                'description'
            ])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
