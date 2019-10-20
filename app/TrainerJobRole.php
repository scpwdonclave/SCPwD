<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainerJobRole extends Model
{
     public function jobrole(){
        return $this->belongsTo('App\JobRole', 'jobrole_id');
    }

    public function scheme(){
        return $this->belongsTo('App\Scheme', 'scheme_id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'sector_id');
    }

    public function trainer(){
        return $this->belongsTo('App\Trainer', 'tr_id');
    }
}
