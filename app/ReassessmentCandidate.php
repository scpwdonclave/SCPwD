<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReassessmentCandidate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function reassessment()
    {
        return $this->belongsTo('App\Reassessment', 'ras_id');
    }
    public function centercandidate()
    {
        return $this->belongsTo('App\CenterCandidateMap', 'ccd_id');
    }

    public function candidateMark()
    {
        return $this->hasOne('App\CandidateReMark', 'reass_candidate_id');
    }
}
