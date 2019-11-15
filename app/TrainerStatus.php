<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerStatus extends Model
{
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function trainer_jobroles(){
        return $this->hasMany('App\TrainerJobRole', 'tr_id');
    }
}
