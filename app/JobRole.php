<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    public function sector(){
        return $this->belongsTo('App\Sector');
    }

    public function expositories(){
        return $this->belongsToMany('App\Expository')->withTimestamps();
    }

    public function partners(){
        return $this->hasMany('App\PartnerJobrole', 'jobrole_id');
    }
}
