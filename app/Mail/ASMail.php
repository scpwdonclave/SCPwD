<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ASMail extends Mailable
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
        switch ($this->data->tag) {
            case 'aaactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Assessment Agency Account has been Re-Activated by SCPwD.</p><br>All ongoing Progress on your account has been resumed. You can login to your Account from now onwards.",
                    'confirmBtnText' => 'Log in Securely',
                    'confirmBtnLink' => route('assessor.login'),
                ];
                $subject = "Assessor Account Resumed | SCPwD";
                break;
            case 'aadeactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Assessment Agency Account has been Deactivated by SCPwD.</p><br>All ongoing Progress on your account has been suspended. You do not have any access on your Account. for Further Clerification Please Contact your Assessment Agency.",
                    'confirmBtnText' => 'Try Loging in',
                    'confirmBtnLink' => route('assessor.login'),
                ];
                $subject = "Assessor Account Suspended | SCPwD";
                break;
        }
        return $this->view('emails.email')->subject($subject)->with($dataToSend);
    }
}
