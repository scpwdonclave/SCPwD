<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessor extends Model
{
    public function agency(){
        return $this->belongsTo('App\Agency', 'aa_id');
    }
    public function disability(){
        return $this->belongsTo('App\Expository', 'd_type');
    }
    public function relevantSectors(){
        return $this->belongsTo('App\Sector', 'relevant_sector');
    }
    public function sectors(){
        return $this->belongsTo('App\Sector', 'sector_id');
    }

    public function assessorJob(){
        return $this->hasMany('App\AssessorJobRole', 'as_id');
    }
    public function assessorLanguage(){
        return $this->hasMany('App\AssessorLanguage', 'as_id');
    }
}
