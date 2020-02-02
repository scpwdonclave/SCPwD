<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainFile extends Model
{
    public function complain(){
        return $this->belongsTo('App\Complain', 'cmp_id');
    }
}
