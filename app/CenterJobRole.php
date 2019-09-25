<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenterJobRole extends Model
{
    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }

    public function partnerjobrole(){
        return $this->belongsTo('App\PartnerJobrole', 'tp_job_id');
    }
}
