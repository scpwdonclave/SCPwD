<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BatchCandidateMap extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //
    // public function centercandidate(){
    //     return $this->belongsTo('App\CenterCandidateMap', 'candidate_id');
    // }
    public function candidate(){
        return $this->belongsTo('App\Candidate');
    }
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
}
