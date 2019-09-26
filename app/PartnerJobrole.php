<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PartnerJobrole extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    
    public function jobrole(){
        return $this->belongsTo('App\JobRole', 'jobrole_id');
    }

    public function scheme(){
        return $this->belongsTo('App\Scheme', 'scheme_id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'sector_id');
    }

    public function centerjoroles(){
        return $this->hasMany('App\CenterJobRole', 'tp_job_id');
    }

    public function reasons(){
        return $this->hasMany('App\PartnerJobRoleReason', 'partner_job_id');
    }

}
