<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    //
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function centers(){
        return $this->belongsTo('App\Center', 'tp_id');
    }
}
