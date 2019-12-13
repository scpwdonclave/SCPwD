<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TCMail extends Mailable
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
            case 'tcaccept':
                $dataToSend = [
                    'initial' => 'Let\'s Begin',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account has been Approved by SCPwD. Please log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->tc_id."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>".$this->data->password."</span></strong></p><br><p>You can now Manage your Account Details and also add Candidates</p>",
                    'confirmBtnText' => 'Get Started',
                    'confirmBtnLink' => route('center.login'),
                ];
                $subject = "Training Center Account Created and Approved | SCPwD";
                break;
            case 'tcactive':
                $dataToSend = [
                    'initial' => 'Let\'s Begin',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Traning Center Account (ID:<span style='color:#0000CD'>".$this->data->tc_id."</span>) has been Re-Activated by SCPwD. Now you can log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->tc_id."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>your existing password</span></strong></p>",
                    'confirmBtnText' => 'Get Started',
                    'confirmBtnLink' => route('center.login'),
                ];
                $subject = "Training Center Account Re-Activated | SCPwD";
                break;
            case 'tcdeactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Traning Center Account (ID:<span style='color:#0000CD'>".$this->data->tc_id."</span>) has been Deactivated by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>If you think this is by mistake. Please Contact your Training Partner.</p>",
                    'confirmBtnText' => 'Try Loging in',
                    'confirmBtnLink' => route('center.login'),
                ];
                $subject = "Training Center Account Deactivated | SCPwD";
                break;
            case 'tpactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Traning Partner Account has been Re-Activated by SCPwD.</p><br>All ongoing Progress on your account has been resumed. You can login to your Account from now onwards.",
                    'confirmBtnText' => 'Log in Securely',
                    'confirmBtnLink' => route('center.login'),
                ];
                $subject = "Training Center Account Resumed | SCPwD";
                break;
            case 'tpdeactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Traning Partner Account has been Deactivated by SCPwD.</p><br>All ongoing Progress on your account has been suspended. You do not have any access on your Account. for Further Clerification Please Contact your Training Partner.",
                    'confirmBtnText' => 'Try Loging in',
                    'confirmBtnLink' => route('center.login'),
                ];
                $subject = "Training Center Account Suspended | SCPwD";
                break;
        }
        
        return $this->view('emails.email')->subject($subject)->with($dataToSend);
    }
}
