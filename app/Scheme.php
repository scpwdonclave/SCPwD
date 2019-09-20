<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
   public function sectors(){
       return $this->hasMany('App\Sector');
   }
}
