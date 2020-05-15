<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentTrainer extends Model
{
    public function batches()
    {
        return $this->hasMany('App\TotBatchAssessmentTrainerMap', 'tr_id');
    }

    public function batchlatest()
    {
        return $this->hasOne('App\TotBatchAssessmentTrainerMap', 'tr_id')->latest();
    }

    public function statedistrict()
    {
        return $this->belongsTo('App\StateDistrict', 'state_district');
    }
}
