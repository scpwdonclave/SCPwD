<?php

namespace App;

use App\Notifications\PartnerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Partner extends Authenticatable
{
    use Notifiable;

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
}
