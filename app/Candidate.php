<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    public function batches()
    {
        return $this->hasMany('App\BatchCandidateMap');
    }

    public function centermap()
    {
        return $this->hasMany('App\CenterCandidateMap', 'cd_id');
    }

    public function centerlatest()
    {
        return $this->hasOne('App\CenterCandidateMap', 'cd_id')->latest();
    }
    
}
