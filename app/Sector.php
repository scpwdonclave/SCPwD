<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function job_roles(){
        return $this->hasMany('App\JobRole');
    }

    public function partners(){
        return $this->hasMany('App\PartnerJobrole', 'sector_id');
    }
}
