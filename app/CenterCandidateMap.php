<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CenterCandidateMap extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function jobrole(){
        return $this->belongsTo('App\CenterJobRole', 'tc_job_id');
    }

    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }

    public function disability(){
        return $this->belongsTo('App\Expository', 'd_type');
    }

    public function batchcandidate(){ 
        return $this->hasOne('App\BatchCenterCandidateMap', 'candidate_id')->latest();
    }
    
    public function candidate()
    {
        return $this->belongsTo('App\Candidate','cd_id');
    }
    public function candidateMark()
    {
        return $this->hasOne('App\CandidateMark','candidate_id');
    }
    public function candidateReMark()
    {
        return $this->hasMany('App\CandidateReMark','candidate_id');
    }

    public function placement()
    {
        return $this->hasOne('App\Placement','ccd_id');
    }
}
