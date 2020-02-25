<?php

namespace App\Listeners;

use App\Mail\AdminMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminMailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function handle($event)
    {
        sleep(2); // 2 Sec Delay
        Mail::to(Config::get('constants.onclave-support-mail'))->send(new AdminMail($event->data));
    }
}
