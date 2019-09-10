<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRole extends Model
{
    public function sector(){
        $this->belongsTo('App\Sector');
    }
}
