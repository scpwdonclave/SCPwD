<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function job_roles(){
        return $this->hasMany('App\JobRole');
    }
}
