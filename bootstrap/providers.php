<?php

use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\Event;

return [
    AppServiceProvider::class,
    // bootstrap/app.php or EventServiceProvider
    // Event::listen(OrderCreated::class, FindMatchingDriverRoutesListener::class)
];
