<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TrainerStatus extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function trainer_jobroles(){
        return $this->hasMany('App\TrainerJobRole', 'tr_id');
    }
}
