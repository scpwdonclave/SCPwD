<?php

namespace App;

use App\Notifications\CenterResetPassword;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Center extends Authenticatable implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;
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
    
    public function center_jobroles(){
        return $this->hasMany('App\CenterJobrole', 'tc_id');
    }

    public function center_docs(){
        return $this->hasMany('App\CenterDoc', 'tc_id');
    }

    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function trainers(){
        return $this->hasMany('App\Trainer', 'tp_id');
    }
    
    public function candidatesmap(){
        return $this->hasMany('App\CenterCandidateMap', 'tc_id');
    }

    public function batches(){
        return $this->hasMany('App\Batch', 'tc_id');
    }

}
