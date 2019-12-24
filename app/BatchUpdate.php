<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BatchUpdate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function batch(){
        return $this->belongsTo('App\Batch', 'bt_id');
    }
    public function trainer(){
        return $this->belongsTo('App\Trainer', 'tr_id');
    }
    public function new_trainer(){
        return $this->belongsTo('App\Trainer', 'new_tr_id');
    }
    public function partner(){
        return $this->belongsTo('App\Partner', 'tp_id');
    }
}
