<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerJobRole extends Model
{
    public function trainer(){
        return $this->belongsTo('App\Trainer', 'tr_id');
    }

    public function partnerjobrole(){
        return $this->belongsTo('App\PartnerJobrole', 'tp_job_id');
    }

    public function dlinktrainer(){
        return $this->belongsTo('App\TrainerStatus', 'prv_id');
    }
}
