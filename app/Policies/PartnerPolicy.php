<?php

namespace App\Policies;

use App\User;
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

    public function PartnerUpdate($user){
        if (!$user->pending_verify && $user->complete_profile) {
            return true;
        } else {
            return false;
        }
    }

    public function PartnerUpdatePending($user){
        
        if ($this->PartnerUpdate($user)) {
            $tp_id = $user->tp_id;
            $partner = DB::table('partner_update')->where('tp_id', '=', $tp_id)->latest('id')->first();
            if ($partner) {
                if ($partner->action) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
