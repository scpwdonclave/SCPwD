<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReassessmentCandidate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function reassessment()
    {
        return $this->belongsTo('App\Reassessment', 'ccd_id');
    }
}
