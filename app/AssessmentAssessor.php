<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentAssessor extends Model
{
    public function agency()
    {
        return $this->belongsTo('App\Agency', 'aa_id');
    }
}
