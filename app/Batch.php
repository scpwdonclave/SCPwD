<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
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
        return $this->hasMany('App\BatchCandidateMap', 'bt_id');
    }
}
