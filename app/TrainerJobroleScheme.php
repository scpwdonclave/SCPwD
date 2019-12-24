<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TrainerJobroleScheme extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function jobrole(){
        return $this->belongsTo('App\TrainerJobRole','tr_job_id');
    }

    public function scheme(){
        return $this->belongsTo('App\Scheme','scheme_id');
    }
}
