<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Sector extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function job_roles(){
        return $this->hasMany('App\JobRole');
    }

    public function partners(){
        return $this->hasMany('App\PartnerJobrole', 'sector_id');
    }
}
