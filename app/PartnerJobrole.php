<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerJobrole extends Model
{
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
}
