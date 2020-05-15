<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotBatchAssessmentTrainerMap extends Model
{
    protected $fillable = ['percentage','qr_id','digital_key','bt_tot_id','grade','validity'];

    public function batch()
    {
        return $this->belongsTo('App\TotBatch', 'bt_id');
    }

    public function trainer()
    {
        return $this->belongsTo('App\AssessmentTrainer', 'tr_id');
    }
}
