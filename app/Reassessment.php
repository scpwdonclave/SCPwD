<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Reassessment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function candidates()
    {
        return $this->hasMany('App\ReassessmentCandidate', 'ras_id');
    }

    public function batch()
    {
        return $this->belongsTo('App\Batch', 'bt_id');
    }
}
