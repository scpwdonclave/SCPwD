<?php

namespace App;

use App\Notifications\AgencyResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agency extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aa_id', 'name', 'email', 'password',
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
        $this->notify(new AgencyResetPassword($token));
    }

    public function agencySector(){
        return $this->hasMany('App\AgencySector', 'aa_id');
    }
    public function assessors(){
        return $this->hasMany('App\Assessor', 'aa_id');
    }
}
