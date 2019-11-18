<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessorJobRole extends Model
{
    public function jobRoles(){
        return $this->belongsTo('App\jobRole', 'job_role_id');
    }
}
