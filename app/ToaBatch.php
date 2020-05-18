<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToaBatch extends Model
{
    public function assessors()
    {
        return $this->hasMany('App\ToaBatchAssessmentAssessorMap', 'bt_id');
    }
}
