<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CenterDoc extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function center(){
        return $this->belongsTo('App\Center', 'tc_id');
    }
}
