<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        'App\Events\TesEvent' => [
            'App\Listeners\TesListener',
        ],
        'App\Events\MahasiswaInputEvent' => [
            'App\Listeners\DosenNotifListener',
            'App\Listeners\AllNotifListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    /* public function boot()
    {
        parent::boot();

        //
    } */
}
