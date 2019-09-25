<?php

namespace App;

use App\Notifications\CenterResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Center extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array 
     */
    protected $fillable = [
        'tc_id', 'name', 'email', 'password',
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
        $this->notify(new CenterResetPassword($token));
    }

    public function center_docs(){
        return $this->hasMany('App\CenterDoc');
    }

    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function trainers(){
        return $this->hasMany('App\Trainer', 'tp_id');
    }
}
