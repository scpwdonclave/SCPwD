<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public function jobrole(){
        return $this->belongsTo('App\CenterJobRole', 'tc_job_id');
    }

    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }

    public function disability(){
        return $this->belongsTo('App\Expository', 'd_type');
    }

    public function batchmap(){
        return $this->hasMany('App\BatchCandidateMap', 'candidate_id');
    }
    
}
