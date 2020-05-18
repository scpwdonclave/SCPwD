<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToaBatchAssessmentAssessorMap extends Model
{
    protected $fillable = ['percentage','qr_id','digital_key','bt_tot_id','grade','validity'];

    public function batch()
    {
        return $this->belongsTo('App\ToaBatch', 'bt_id');
    }

    public function assessor()
    {
        return $this->belongsTo('App\AssessmentAssessor', 'as_id');
    }
}
