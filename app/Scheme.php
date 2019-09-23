<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    public function sectors(){
        return $this->hasMany('App\Sector');
    }

    public function partners(){
        return $this->hasMany('App\PartnerJobrole', 'scheme_id');
    }
}
