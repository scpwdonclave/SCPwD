<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AAMail extends Mailable
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
            case 'aaconfirmation':
                $dataToSend = [
                    'initial' => 'Let\'s Get Started.',
                    'name' => $this->data->name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your acoount has been created with SCPwD. Please log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->aaid."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>".$this->data->password."</span></strong></p><br><p>Once you have Logged In, You can add Assessors to your account, manage Batches, Assessors etc.",
                    'confirmBtnText' => 'Get Started',
                    'confirmBtnLink' => route('agency.login'),
                ];
                $subject = "Assessment Agency Account Confirmation | SCPwD";
                break;
            case 'aaactive':
                $dataToSend = [
                    'initial' => 'Let\'s Begin',
                    'name' => $this->data->name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account has been Re-Activated by SCPwD. Now you can log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->aa_id."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>your existing password</span></strong></p>",
                    'confirmBtnText' => 'Get Started',
                    'confirmBtnLink' => route('agency.login'),
                ];
                $subject = "Assessment Agency Account Re-Activated | SCPwD";
                break;
            case 'aadeactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account has been Deactivated by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>If you think this is by mistake. Please Contact SCPwD.</p>",
                    'confirmBtnText' => 'Try Loging in',
                    'confirmBtnLink' => route('agency.login'),
                ];
                $subject = "Assessment Agency Account Deactivated | SCPwD";
                break;
        }
        return $this->view('emails.email')->subject($subject)->with($dataToSend);
    }
}
