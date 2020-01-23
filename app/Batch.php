<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Batch extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }
    public function trainer(){
        return $this->belongsTo('App\Trainer', 'tr_id');
    }
    public function scheme(){
        return $this->belongsTo('App\Scheme', 'scheme_id');
    }
    public function jobrole(){
        return $this->belongsTo('App\JobRole', 'jobrole_id');
    }
    public function tpjobrole(){
        return $this->belongsTo('App\PartnerJobrole', 'tp_job_id');
    }
    public function candidatesmap(){
        return $this->hasMany('App\BatchCenterCandidateMap', 'bt_id');
    }
    public function batchassessment(){
        return $this->hasOne('App\BatchAssessment', 'bt_id');
    } 
    public function batchreassessments(){
        return $this->hasMany('App\BatchReAssessment', 'bt_id');
    } 
    public function agencybatch(){
        return $this->hasOne('App\AgencyBatch', 'bt_id');
    } 
    public function assessorbatch(){
        return $this->hasOne('App\AssessorBatch', 'bt_id');
    } 
}
