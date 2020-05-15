<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotBatch extends Model
{
    public function trainers()
    {
        return $this->hasMany('App\TotBatchAssessmentTrainerMap', 'bt_id');
    }
}
