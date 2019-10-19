<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    //
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }
    public function trainer(){
        return $this->belongsTo('App\Trainer', 'tr_id');
    }
}
