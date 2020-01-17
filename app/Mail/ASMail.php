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
            case 'aaactivedeactive':
                if($this->data->status){
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Assessment Agency Account has been Re-Activated by SCPwD.</p><br>All ongoing Progress on your account has been resumed. You can login to your Account from now onwards.";
                    $subject = "Assessor Account Resumed | SCPwD";
                } else {
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Assessment Agency Account has been Deactivated by SCPwD.</p><br>All ongoing Progress on your account has been suspended. You do not have any access on your Account. for Further Clerification Please Contact your Assessment Agency.";
                    $subject = "Assessor Account Suspended | SCPwD";
                }
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('assessor.login'),
                ];
                break;
            case 'asacceptreject':
                $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account has been Approved by SCPwD. Please log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->as_id."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>".$this->data->password."</span></strong></p><br><p>You can now Manage your Account Details.</p>";
                $subject = "Assessor Account Created and Approved | SCPwD";
            
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('assessor.login'),
                ];
                break;
            case 'asactivedeactive':
                if($this->data->status){
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account (ID: <span style='color:#0000CD'>".$this->data->as_id."</span>) has been Re-Activated by SCPwD. For More Details on This Kindly login to your Account</p>";
                    $subject = "Assessor Account Re-Activated | SCPwD";
                } else {
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account (ID: <span style='color:#0000CD'>".$this->data->as_id."</span>) has been Deactivated by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>If you think this is by mistake. Please contact your Agency.</p>";
                    $subject = "Assessor Account Deactivated | SCPwD";
                }
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('assessor.login'),
                ];
                break;
            case 'btassignremove':
                if($this->data->status){
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Assessment Agency assigned you some Batch(es) for Assessment. For More Details on this Kindly login to your Account</p>";
                    $subject = "Batch Assigned by Agency | SCPwD";
                } else {
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Assessment Agency has Revoked a Batch (ID: <span style='color:#0000CD'>".$this->data->bt_id."</span>) from you.<br><p>For any kind of clearification on this Kindly contact your Agency.</p>";
                    $subject = "Batch Revoked By Agency | SCPwD";
                }
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('assessor.login'),
                ];
                break;
        }
        return $this->view('emails.email')->subject($subject)->with($dataToSend);
    }
}
