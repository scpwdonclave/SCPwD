<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use App\Notifications\AgencyResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agency extends Authenticatable implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
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
    public function agencyBatch(){
        return $this->hasMany('App\AgencyBatch', 'aa_id');
    }
}
