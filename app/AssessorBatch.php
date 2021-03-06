<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AssessorBatch extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
    public function assessor(){
        return $this->belongsTo('App\Assessor', 'as_id');
    }
    public function reassessment(){
        return $this->belongsTo('App\Reassessment', 'reass_id');
    }

    public function agencyBatch()
    {
        return $this->belongsTo('App\AgencyBatch','aa_bt_id');
    }
    
}
