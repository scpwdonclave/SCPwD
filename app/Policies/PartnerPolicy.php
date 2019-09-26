<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;

class PartnerPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function PartnerProfileVerified($user){
        if (!$user->pending_verify && $user->complete_profile) {
            return true;
        } else {
            return false;
        }
    }

    public function PartnerHasJobRole($user){
        if (count($user->partner_jobroles)) {
            return true;
        } else {
            return false;
        }   
    }

    public function CenterProfileVerifiedAndActive($partner, $center){
        if (($center->tp_id == $partner->id) && $center->verified && $center->status && $center->ind_status) {
            return true;
        } else {
            return false;
        }
    }
}
