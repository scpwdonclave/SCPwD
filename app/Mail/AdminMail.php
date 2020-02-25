<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $email = $this->view('emails.email-support-onclave')
        ->subject('Support Request From SCPwD')
        ->with(compact('data'));

        foreach($data->complainfile as $filePath){
            $email->attachFromStorageDisk('myDisk',$filePath->screen_shot);
        }

        return $email;
    }
}
