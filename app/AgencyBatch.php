<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AgencyBatch extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
    public function agency(){
        return $this->belongsTo('App\Agency', 'aa_id');
    }
    public function reassessment(){
        return $this->belongsTo('App\Reassessment', 'reass_id');
    }
}
