<?php

namespace App;

use App\Notifications\PartnerResetPassword;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Partner extends Authenticatable implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tp_id', 'spoc_name', 'email', 'spoc_mobile', 'password', 'incorp_doc'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PartnerResetPassword($token));
    }

    public function partner_jobroles(){
        return $this->hasMany('App\PartnerJobrole', 'tp_id');
    }
    
    public function centers(){
        return $this->hasMany('App\Center', 'tp_id');
    }
    public function trainers(){
        return $this->hasMany('App\Trainer', 'tp_id');
    }

    public function batches(){
        return $this->hasMany('App\Batch', 'tp_id');
    }

    public function reassessments(){
        return $this->hasMany('App\Reassessment', 'tp_id');
    }
}
