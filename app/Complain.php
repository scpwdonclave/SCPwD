<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Complain extends Model implements Auditable

{ 
    use \OwenIt\Auditing\Auditable;

    public function complainfile(){
        return $this->hasMany('App\ComplainFile', 'cmp_id');
    }

    public function agency(){
        return $this->belongsTo('App\Agency', 'rel_id');
    }
    public function assessor(){
        return $this->belongsTo('App\Assessor', 'rel_id');
    }
    public function partner(){
        return $this->belongsTo('App\Partner', 'rel_id');
    }
    public function center(){
        return $this->belongsTo('App\Center', 'rel_id');
    }
}
