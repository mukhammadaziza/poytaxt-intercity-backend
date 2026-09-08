<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// routes/channels.php
Broadcast::channel('driver.{driverId}', function (User $user, int $driverId) {
    return $user->id === $driverId && $user->hasRole('Driver');
});

// Broadcast::channel('dispatch-board', function (User $user) {
//     return $user->hasAnyRole(['operator', 'coordinator', 'super_admin']);
// });