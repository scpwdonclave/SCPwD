<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class JobRole extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function sector(){
        return $this->belongsTo('App\Sector');
    }

    public function expositories(){
        return $this->belongsToMany('App\Expository')->withTimestamps();
    }

    public function partners(){
        return $this->hasMany('App\PartnerJobrole', 'jobrole_id');
    }

    public function qualifications(){
        return $this->hasMany('App\JobQualification', 'job_id');
    }
}
