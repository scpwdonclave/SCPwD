<?php

namespace App\Listeners;

use App\Mail\ASMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ASMailListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    
    public function handle($event)
    {
        sleep(2); // 2 Sec Delay
        Mail::to($event->data->email)->send(new ASMail($event->data));
    }
}
