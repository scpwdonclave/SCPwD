<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgencyBatch extends Model
{
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
}
