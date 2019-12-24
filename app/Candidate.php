<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Candidate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    // public function batches()
    // {
    //     return $this->hasMany('App\BatchCenterCandidateMap');
    // }

    public function centermap()
    {
        return $this->hasMany('App\CenterCandidateMap', 'cd_id');
    }

    public function centerlatest()
    {
        return $this->hasOne('App\CenterCandidateMap', 'cd_id')->latest();
    }
    
}
