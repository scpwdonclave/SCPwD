<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BatchUpdate extends Model
{
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
    public function trainer(){
        return $this->belongsTo('App\Trainer', 'tr_id');
    }
    public function new_trainer(){
        return $this->belongsTo('App\Trainer', 'new_tr_id');
    }
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
}
