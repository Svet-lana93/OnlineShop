<?php

namespace App\Listeners;

use App\Mail\AdminEmailVerificated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class AdminEmailVerificationLogging
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event): void
    {
        Mail::to($event->admin)->send(new AdminEmailVerificated($event->admin));
    }
}
