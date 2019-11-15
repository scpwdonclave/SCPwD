<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;
use App\TrainerJobRole;
use App\Partner;
use App\Trainer;
use App\Center;
use App\BatchUpdate;

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

    protected function partnerscheme($id){
        $c = Center::find($id);
        foreach ($c->center_jobroles as $cjob) {
            if ($cjob->partnerjobrole->status) {
                return true;
            }
        }
        return false;
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

    public function PartnerBatchUpdate($partner, $batch){

        $result = BatchUpdate::where([['bt_id', $batch],['tp_id', $partner->id],['action', 0]])->first();
        if ($result) {
            return false;
        } else {
            return true;
        }   
    }

    public function CenterProfileVerifiedAndActive($partner, $center){
        if (($center->tp_id == $partner->id) && $center->verified && $center->status && $this->partnerscheme($center->id)) {
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
