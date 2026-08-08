<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\AspirationCreated;
use App\Events\AspirationStatusUpdated;
use App\Listeners\NotifyAdminsNewAspiration;
use App\Listeners\NotifyUserStatusChange;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        AspirationCreated::class => [
            NotifyAdminsNewAspiration::class,
        ],
        AspirationStatusUpdated::class => [
            NotifyUserStatusChange::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
