<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerJobroleScheme extends Model
{
    public function jobrole(){
        return $this->belongsTo('App\TrainerJobRole','tr_job_id');
    }

    public function scheme(){
        return $this->belongsTo('App\Scheme','scheme_id');
    }
}
