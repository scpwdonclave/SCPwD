<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Trainer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    // public function centers(){
    //     return $this->belongsTo('App\Center', 'tp_id');
    // }
    // public function partner_jobrole(){
    //     return $this->belongsTo('App\PartnerJobrole','tp_job_id');
    // }

    public function jobroles(){
        return $this->hasMany('App\TrainerJobrole', 'tr_id');
    }

    public function batches(){
        return $this->hasMany('App\Batch', 'tr_id');
    }

    
}
