<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Center;

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

    protected function partnerscheme($id){
        $c = Center::find($id);
        foreach ($c->center_jobroles as $cjob) {
            if ($cjob->partnerjobrole->status) {
                return true;
            }
        }
        return false;
    }

    public function CenterProfileVerifiedAndActive($center){
        if ($center->verified && $center->status && $this->partnerscheme($center->id)) {
            return true;
        } else {
            return false;
        }
    }
}
