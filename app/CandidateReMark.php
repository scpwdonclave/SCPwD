<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CandidateReMark extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function centerCandidate(){
        return $this->belongsTo('App\CenterCandidateMap', 'candidate_id');
    }
    public function batchReAssessment(){
        return $this->belongsTo('App\BatchReAssessment', 'bt_reassessment_id');
    }
}
