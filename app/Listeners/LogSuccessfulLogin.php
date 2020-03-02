<?php

namespace App\Listeners;

use App\LoginAudit;
use Illuminate\Support\Facades\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    
    public function handle($event)
    {
        switch ($event->guard) {
            case 'admin':
                $name = $event->user->name;
                $display_id = $event->user->email;
                break;
            case 'partner':
                $name = $event->user->spoc_name;
                $display_id = $event->user->tp_id;
                break;
            case 'center':
                $name = $event->user->spoc_name;
                $display_id = $event->user->tc_id;
                break;
            case 'agency':
                $name = $event->user->name;
                $display_id = $event->user->aa_id;
                break;
            case 'assessor':
                $name = $event->user->name;
                $display_id = $event->user->as_id;
                break;            
            default:
                $name = NULL;
                $display_id = NULL;
        }

        LoginAudit::create([
            'name' => $name,
            'display_id' => $display_id,
            'user_type' => $event->guard,
            'user_id' => $event->user->id,
            'event' => 1,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent')
        ]);
    }
}
