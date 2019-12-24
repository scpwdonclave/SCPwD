<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateMark extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    public function candidate(){
        return $this->belongsTo('App\Candidate', 'candidate_id');
    }
    public function batchAssessment(){
        return $this->belongsTo('App\BatchAssessment', 'bt_assessment_id');
    }
}
