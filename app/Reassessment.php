<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Reassessment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['aa_id'];
    
    public function candidates()
    {
        return $this->hasMany('App\ReassessmentCandidate', 'ras_id');
    }

    public function batch()
    {
        return $this->belongsTo('App\Batch', 'bt_id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Agency', 'aa_id');
    }

    public function assessor()
    {
        return $this->belongsTo('App\Assessor', 'as_id');
    }
    
    public function partner()
    {
        return $this->belongsTo('App\Partner', 'tp_id');
    }

    public function center()
    {
        return $this->belongsTo('App\Center', 'tc_id');
    }

    public function batchreassessment()
    {
        return $this->hasOne('App\BatchReAssessment', 'bt_reassid');
    }

}
