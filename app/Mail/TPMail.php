<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TPMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
    
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
            case 'tpverifiation':
                $dataToSend = [
                    'initial' => 'Let\'s Get Started.',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Please log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->email."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>".$this->data->password."</span></strong></p><br><p>Once you Logged in, You Need to Complete Your <strong><i>Profile Setup</i></strong>, Once Admin review it, you will get notified here.</p>",
                    'confirmBtnText' => 'Get Started',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Partner Account Verification | SCPwD";
                break;
            case 'tpaccept':
                $dataToSend = [
                    'initial' => 'Let\'s Begin',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account has been Approved by SCPwD. Please log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->tp_id."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>your existing password</span></strong></p><br><p>You can only use these <strong><i>above credentials</i></strong> to login, From now onwords your email id will <strong><i>not be accepted</i></strong> as a <strong><i>valid</i></strong> credentials for Login.</p>",
                    'confirmBtnText' => 'Get Started',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Partner Account Request Accepted | SCPwD";
                break;
            case 'tpreject':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account Request has been Rejected by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>You can start over again whenever you want.</p>",
                    'confirmBtnText' => 'Start Over',
                    'confirmBtnLink' => route('partner.register'),
                ];
                $subject = "Training Partner Account Request Rejected | SCPwD";        
                break;
            case 'tpactive':
                $dataToSend = [
                    'initial' => 'Let\'s Begin',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account has been Re-Activated by SCPwD. Now you can log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style='color:#0000CD;'>".$this->data->tp_id."</span></strong></p><p >Password: <strong><span style='color:#0000FF;'>your existing password</span></strong></p>",
                    'confirmBtnText' => 'Get Started',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Partner Account Re-Activated | SCPwD";
                break;
            case 'tpdeactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Account has been Deactivated by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>If you think this is by mistake. Please Contact SCPwD.</p>",
                    'confirmBtnText' => 'Try Loging in',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Partner Account Deactivated | SCPwD";
                break;
            case 'tcaccept':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->tp_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Training Center Account (ID: <strong><span style='color:#0000CD;'>".$this->data->tc_id."</span></strong>) for <span style='color:#0000CD;'>".$this->data->spoc_name."</span> has been Approved by SCPwD. Please log in to your portal to Manage your Training Centers</p>",
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Center Account Request Accepted | SCPwD";
                break;
            case 'tcreject':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Training Center Account Request for <span style='color:#0000CD;'>".$this->data->tc_name."</span> has been Rejected by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>You can start over again whenever you want.</p>",
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Center Account Request Rejected | SCPwD";        
                break;
            case 'tcactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Training Center Account (ID: <span style='color:#0000CD'>".$this->data->tc_id."</span>) has been Re-Activated by SCPwD. For More Details on This Kindly login to your Account</p>",
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Center Account Re-Activated | SCPwD";
                break;
            case 'tcdeactive':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->spoc_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Training Center Account (ID: <span style='color:#0000CD'>".$this->data->tc_id."</span>) has been Deactivated by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>If you think this is by mistake. Please Contact SCPwD.</p>",
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Training Center Account Deactivated | SCPwD";
                break;
            case 'tracceptreject':
                if($this->data->status){
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Requested Trainer <span style='color:#0000CD;'>".$this->data->name."</span> (ID: <strong><span style='color:#0000CD;'>".$this->data->tr_id."</span></strong>) has been Approved by SCPwD. Please log in to your portal to Manage your Trainers</p>";
                    $subject = "Trainer Request Accepted | SCPwD";
                } else {
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Requested Trainer <span style='color:#0000CD;'>".$this->data->name."</span> has been Rejected by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>You can start over again whenever you want.</p>";
                    $subject = "Trainer Request Rejected | SCPwD";
                }
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->tp_name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                break;
            case 'tractivedeactive':
                if($this->data->status){
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Trainer ".$this->data->name." (ID: <span style='color:#0000CD'>".$this->data->tr_id."</span>) has been Re-Activated by SCPwD. For More Details on This Kindly login to your Account</p>";
                    $subject = "Trainer Re-Activated | SCPwD";
                } else {
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Trainer ".$this->data->name." (ID: <span style='color:#0000CD'>".$this->data->tr_id."</span>) has been Deactivated by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>If you think this is by mistake. Please Contact SCPwD.</p>";
                    $subject = "Trainer Deactivated | SCPwD";
                }
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->tp_name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                break;
            case 'trdelink':
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->tp_name,
                    'messagedata' => "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Trainer <span style='color:#0000CD;'>".$this->data->name."</span> (ID: <span style='color:blue'>".$this->data->tr_id."</span>) has been De Linked from your Registered Trainers List by SCPwD with Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>You can re-register them whenever you want.</p>",
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                $subject = "Trainer has been De Linked | SCPwD";        
                break;
            case 'btacceptreject':
                if($this->data->status){
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Requested Batch (ID: <span style='color:#0000CD'>".$this->data->bt_id."</span>) has been Approved by SCPwD. For More Details on This Kindly login to your Account</p>";
                    $subject = "Batch Requested Approved | SCPwD";
                } else {
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Requested Batch has been Rejected by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>You can start over again whenever you want.</p>";
                    $subject = "Batch Request Rejected | SCPwD";
                }
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->tp_name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
            break;
            case 'btupdateacceptreject':
                if($this->data->status){
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Requested Update for Batch (ID: <span style='color:#0000CD'>".$this->data->bt_id."</span>) has been Approved by SCPwD. For More Details on This Kindly login to your Account</p>";
                    $subject = "Batch Update Requested Approved | SCPwD";
                } else {
                    $messagedata = "<p>Welcome to Skill Council for Persons with Disability (SCPwD). Your Requested Update for Batch (ID: <span style='color:#0000CD'>".$this->data->bt_id."</span>) has been Rejected by SCPwD for Following Reason.</p><br><p><strong><span style='color:#0000CD;'>Reason:</span><br><i>".$this->data->reason."</i> </span></strong></p><br><p>You can request again whenever you want.</p>";
                    $subject = "Batch Update Request Rejected | SCPwD";
                }
                $dataToSend = [
                    'initial' => 'Important',
                    'name' => $this->data->tp_name,
                    'messagedata' => $messagedata,
                    'confirmBtnText' => 'Login Securely',
                    'confirmBtnLink' => route('partner.login'),
                ];
                break;
        }
        
        return $this->view('emails.email')->subject($subject)->with($dataToSend);
    }
}
