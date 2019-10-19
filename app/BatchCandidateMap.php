<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BatchCandidateMap extends Model
{
    //
    public function candidate(){
        return $this->belongsTo('App\Candidate', 'candidate_id');
    }
    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
}
