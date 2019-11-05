<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    public function agencySector(){
        return $this->hasMany('App\AgencySector', 'aa_id');
    }
}
