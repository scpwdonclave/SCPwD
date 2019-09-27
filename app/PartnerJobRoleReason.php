<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PartnerJobRoleReason extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function jobrole(){
        return $this->belongsTo('App\PartnerJobRole', 'partner_job_id');
    }
}
