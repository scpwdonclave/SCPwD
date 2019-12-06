<?php

namespace App\Listeners;

use App\Mail\TPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TPMailListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        sleep(2); // 2 Sec Delay
        Mail::to($event->data->email)->send(new TPMail($event->data));
    }
}
