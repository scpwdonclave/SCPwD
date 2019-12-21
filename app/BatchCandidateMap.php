<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BatchCandidateMap extends Model
{
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
