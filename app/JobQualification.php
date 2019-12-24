<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class JobQualification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function job(){
        return $this->belongsTo('App\JobRole', 'job_id');
    }
}
