<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentAssessor extends Model
{
    public function agency()
    {
        return $this->belongsTo('App\Agency', 'aa_id');
    }

    public function batches()
    {
        return $this->hasMany('App\ToaBatchAssessmentAssessorMap', 'as_id');
    }

    public function batchlatest()
    {
        return $this->hasOne('App\ToaBatchAssessmentAssessorMap', 'as_id')->latest();
    }

    public function statedistrict()
    {
        return $this->belongsTo('App\StateDistrict', 'state_district');
    }
}
