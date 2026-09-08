<?php

namespace App\Models;

use App\Enums\CommissionType;
use App\Enums\DriverProfileStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class DriverProfile extends Model
{
    use LogsActivity;
    
    protected $table = 'driver_profiles';

    protected $fillable = [
        'driver_id',
        'pool_id',
        'status',
        'driver_balance',
        'commission_type',
        'commission_value'
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'driver_id',
                'pool_id',
                'status',
                'driver_balance',
                'commission_type',
                'commission_value'
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
            'commission_type' => CommissionType::class,
            'status' => DriverProfileStatus::class
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * One driver profile belongs to only one pool
     */
    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
}
