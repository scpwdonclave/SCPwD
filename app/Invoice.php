<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }
    public function scheme(){
        return $this->belongsTo('App\Scheme', 'scheme_id');
    }

    public function invoice_job(){
        return $this->hasMany('App\InvoiceJobRole', 'inv_id');
    }
}
