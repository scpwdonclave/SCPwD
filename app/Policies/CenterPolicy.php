<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CenterPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    public function CenterProfileVerifiedAndActive($center){
        if ($center->verified && $center->status && $center->ind_status) {
            return true;
        } else {
            return false;
        }
    }
}
