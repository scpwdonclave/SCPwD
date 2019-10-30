<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerJobRole extends Model
{
     public function jobrole(){
        return $this->belongsTo('App\JobRole', 'jobrole_id');
    }

    public function schemes(){
        return $this->hasMany('App\TrainerJobroleScheme', 'tr_job_id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'sector_id');
    }

    public function trainer(){
        return $this->belongsTo('App\Trainer', 'tr_id');
    }
    public function dlinktrainer(){
        return $this->belongsTo('App\TrainerStatus', 'prv_id');
    }
}
