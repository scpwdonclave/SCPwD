<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceJobRole extends Model
{
    public function jobrole(){
        return $this->belongsTo('App\JobRole', 'jobrole_id');
    }
}
