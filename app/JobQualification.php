<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobQualification extends Model
{
    public function job(){
        return $this->belongsTo('App\JobRole', 'job_id');
    }
}
