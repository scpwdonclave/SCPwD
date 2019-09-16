<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expository extends Model
{
    public function job_roles(){
        return $this->belongsToMany('App\JobRole')->withTimestamps();
    }
}
