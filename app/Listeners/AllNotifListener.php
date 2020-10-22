<?php

namespace App\Listeners;

use App\Admin;
use App\Mail\AllNotifMail;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AllNotifListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $admins = User::where('role_id', 1)->get();

        foreach($admins as $admin){
            Mail::to($admin)->send(new AllNotifMail());
        }
        //echo $event->data . 'all';
    }
}
