<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Expository extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function job_roles(){
        return $this->belongsToMany('App\JobRole')->withTimestamps();
    }

    public function candidates(){
        return $this->hasMany('App\Candidate', 'd_type');
    }
}
