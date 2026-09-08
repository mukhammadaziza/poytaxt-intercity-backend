<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Gender;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'surname', 'address', 'email', 'password', 'status', 'gender', 'phone', 'date_of_birth', 'balance'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, 
        Notifiable, 
        HasApiTokens, 
        HasRoles, 
        LogsActivity;

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'surname',
                'date_of_birth',
                'gender',
                'address',
                'email',
                'phone',
                'balance',
                'status'
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'gender' => Gender::class,
            'date_of_birth' => 'date'
        ];
    }

    /**
     * One driver has many orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    /**
     * One driver has only one car
     */
    public function car(): HasOne
    {
        return $this->hasOne(Car::class, 'driver_id');
    }

    /**
     * One user can have many tariffs
     */
    public function tariffs(): BelongsToMany
    {
        return $this->belongsToMany(Tariff::class, 'driver_tariff', 'driver_id', 'tariff_id');
    }

    /**
     * One user can have only one profile
     */
    public function profile(): HasOne
    {
        return $this->hasOne(DriverProfile::class, 'driver_id');
    }

    /**
     * One driver can have only one driver route
     */
    public function driverRoute(): HasOne
    {
        return $this->hasOne(DriverRoute::class, 'driver_id');
    }
}
