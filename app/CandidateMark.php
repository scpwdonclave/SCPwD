<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CandidateMark extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    public function centerCandidate(){
        return $this->belongsTo('App\CenterCandidateMap', 'candidate_id');
    }
    public function batchAssessment(){
        return $this->belongsTo('App\BatchAssessment', 'bt_assessment_id');
    }
}
