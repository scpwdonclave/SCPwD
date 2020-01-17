<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AssessorJobRole extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
 
    public function jobRoles(){
        return $this->belongsTo('App\JobRole', 'job_role_id');
    }
}
