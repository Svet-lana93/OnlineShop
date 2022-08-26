<?php

namespace App\Listeners;

use App\Mail\AdminProfileUpdated;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;

class AdminProfileUpdateLogging
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
        Mail::to($event->admin)->send(new AdminProfileUpdated($event->admin));
    }
}
