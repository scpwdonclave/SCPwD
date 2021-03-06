<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use App\Notifications\AssessorResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Assessor extends Authenticatable implements Auditable
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'as_id', 'name', 'email', 'password',
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
        $this->notify(new AssessorResetPassword($token));
    }

    public function agency(){
        return $this->belongsTo('App\Agency', 'aa_id');
    }
    public function disability(){
        return $this->belongsTo('App\Expository', 'd_type');
    }
    public function relevantSectors(){
        return $this->belongsTo('App\Sector', 'relevant_sector');
    }
    public function sectors(){
        return $this->belongsTo('App\Sector', 'sector_id');
    }

    public function assessorJob(){
        return $this->hasMany('App\AssessorJobRole', 'as_id');
    }
    public function assessorLanguage(){
        return $this->hasMany('App\AssessorLanguage', 'as_id');
    }

    public function assessorBatch(){
        return $this->hasMany('App\AssessorBatch', 'as_id');
    }

    public function reassessments(){
        return $this->hasMany('App\Reassessment', 'as_id');
    }
}
