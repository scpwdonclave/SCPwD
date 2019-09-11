<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disability extends Model
{
    public function jobrole(){
        return $this->belongsToMany('App\JobRole')->withTimestamps();
    }
}
