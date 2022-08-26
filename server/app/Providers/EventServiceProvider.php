<?php

namespace App\Providers;

use App\Events\AdminProfileUpdate;
use App\Events\AdminEmailVerification;
use App\Events\UserEmailVerification;
use App\Listeners\AdminProfileUpdateLogging;
use App\Listeners\AdminEmailVerificationLogging;
use App\Listeners\UserEmailVerificationLogging;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AdminEmailVerification::class => [
            AdminEmailVerificationLogging::class,
        ],
        UserEmailVerification::class => [
            UserEmailVerificationLogging::class,
        ],
        AdminProfileUpdate::class => [
            AdminProfileUpdateLogging::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
