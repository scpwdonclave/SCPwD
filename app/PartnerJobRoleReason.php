<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerJobRoleReason extends Model
{
    public function jobrole(){
        return $this->belongsTo('App\PartnerJobRole', 'partner_job_id');
    }
}
