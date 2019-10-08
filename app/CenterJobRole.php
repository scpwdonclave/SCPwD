<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CenterJobRole extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }

    public function partnerjobrole(){
        return $this->belongsTo('App\PartnerJobrole', 'tp_job_id');
    }

    public function candidates(){
        return $this->hasMany('App\Candidate', 'tc_job_id');
    }

    
}
