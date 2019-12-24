<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Scheme extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function sectors(){
        return $this->hasMany('App\Sector');
    }

    public function partners(){
        return $this->hasMany('App\PartnerJobrole', 'scheme_id');
    }
    public function department(){
        return $this->belongsTo('App\Department', 'dept_id');
    }
   
}
