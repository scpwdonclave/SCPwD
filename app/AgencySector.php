<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencySector extends Model
{
    public function sectors(){
        return $this->belongsTo('App\Sector', 'sector');
    }
}
