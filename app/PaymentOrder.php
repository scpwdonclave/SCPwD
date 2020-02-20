<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    public function agency(){
        return $this->belongsTo('App\Agency', 'aa_id');
    }
    public function paymentorder(){
        return $this->hasMany('App\PaymentOrderAgencyBatchMap', 'po_id');
    }
}
