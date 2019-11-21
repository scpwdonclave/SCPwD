<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessorBatch extends Model
{
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
    public function assessor(){
        return $this->belongsTo('App\Assessor', 'as_id');
    }
}
