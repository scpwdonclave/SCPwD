<?php

namespace App\Listeners;

use App\Mail\TCMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TCMailLIstener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function handle($event)
    {
        sleep(2); // 2 Sec Delay
        Mail::to($event->data->email)->send(new TCMail($event->data));
    }
}
