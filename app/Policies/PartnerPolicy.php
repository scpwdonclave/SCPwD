<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;
use App\TrainerJobRole;
use App\Partner;
use App\Trainer;

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

    public function PartnerHasAccessToFile(Partner $partner, String $file, Trainer $trainer){

        if ($trainer->tp_id == $partner->id) {
            if ($trainer->doc_file === 'trainers/'.$file) {
                return true;
            } elseif ($trainer->scpwd_doc === 'trainers/'.$file) {
                return true;
            } elseif ($trainer->resume === 'trainers/'.$file) {
                return true;
            } elseif ($trainer->other_doc === 'trainers/'.$file) {
                return true;
            }
            
            $jobroles = TrainerJobRole::where('tr_id', $trainer->id)->get();
    
            foreach ($jobroles as $job) {
                if ($job->ssc_doc === 'trainers/'.$file) {
                    return true;
                }
            }
            return false;    
        } else {
            return false;
        }
    }
}
