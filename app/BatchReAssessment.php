<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BatchReAssessment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function candidateMarks(){
        return $this->hasMany('App\CandidateReMark', 'bt_reassessment_id');
    }
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }

    public function reassessment(){
        return $this->belongsTo('App\Reassessment', 'bt_reassid');
    }
}
