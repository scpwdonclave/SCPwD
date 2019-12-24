<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AgencySector extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function sectors(){
        return $this->belongsTo('App\Sector', 'sector');
    }
}
