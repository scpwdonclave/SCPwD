<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Trainer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
    public function centers(){
        return $this->belongsTo('App\Center', 'tp_id');
    }
}
