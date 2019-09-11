<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    public function sector(){
        return $this->belongsTo('App\Sector');
    }

    public function disabilities(){
        return $this->belongsToMany('App\Disability')->withTimestamps();
    }
}
