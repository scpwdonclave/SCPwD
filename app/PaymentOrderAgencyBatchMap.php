<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentOrderAgencyBatchMap extends Model
{
    public function agencyBatch(){
        return $this->belongsTo('App\AgencyBatch', 'aa_batch_id');
    }
}
