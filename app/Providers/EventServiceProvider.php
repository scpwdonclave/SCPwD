<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \App\Events\TPMailEvent::class => [
            \App\Listeners\TPMailListener::class
        ],
        \App\Events\TCMailEvent::class => [
            \App\Listeners\TCMailListener::class
        ],
        \App\Events\AAMailEvent::class => [
            \App\Listeners\AAMailListener::class
        ],
        \App\Events\ASMailEvent::class => [
            \App\Listeners\ASMailListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
