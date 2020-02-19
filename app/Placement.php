<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Placement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function partner()
    {
        return $this->belongsTo('App\Partner','tp_id');
    }

    public function center()
    {
        return $this->belongsTo('App\Center','tc_id');
    }

    public function centercandidate()
    {
        return $this->belongsTo('App\CenterCandidateMap','ccd_id');
    }
}
