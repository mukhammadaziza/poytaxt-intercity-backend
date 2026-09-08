<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Order extends Model
{
    use SoftDeletes,
        Userstamps,
        LogsActivity;

    protected $table = 'orders';

    protected $fillable = [
        'order_type',
        'driver_id',
        'tariff_id',
        'departure_time',
        'from_location_id',
        'to_location_id',
        'phone_1',
        'phone_2',
        'status',
        'number_of_people',
        'total_price',
        'comment',
        'details'
    ];

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'order_type',
                'driver_id',
                'tariff_id',
                'departure_time',
                'from_location_id',
                'to_location_id',
                'phone_1',
                'phone_2',
                'status',
                'number_of_people',
                'total_price',
                'comment',
                'details'
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
            'order_type' => OrderType::class,
            'status' => OrderStatus::class,
            'details' => 'array'
        ];
    }

    /**
     * One order belongs to one driver
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One order belongs to one from location point
     */
    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    /**
     * One order belongs to one to location point
     */
    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    /**
     * One order belongs to one to tariff
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }
}
