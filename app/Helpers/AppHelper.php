<?php
namespace App\Helpers;

use App\Center;
use App\Partner;
use App\Trainer;
use App\Candidate;
use App\TrainerStatus;

class AppHelper
{
    public static function instance()
    {
        return new AppHelper();
    }

    public function checkEmail($email){
        $candidate = Candidate::where('email', $email)->first();
        if ($candidate) {
            return array('status' => false, 'user' => 'candidate', 'userid' => $candidate->id);
        } else {
            $center = Center::where('email', $email)->first();
            if ($center) {
                return array('status' => false, 'user' => 'center', 'userid' => $center->id);
            } else {
                $partner = Partner::where('email', $email)->first();
                if ($partner) {
                    return array('status' => false, 'user' => 'partner', 'userid' => $partner->id);
                } else {
                    $trainer = Trainer::where('email', $email)->first();
                    if ($trainer) {
                        return array('status' => false, 'user' => 'trainer', 'userid' => $trainer->id);
                    } else {
                        $trainerstatus = TrainerStatus::where([['email','=', $email],['attached','=',0]])->first();
                        if ($trainerstatus) {
                            return array('status' => false, 'user' => 'trainerstatus', 'userid' => $trainerstatus->id);
                        } else {
                            return array('status' => true);
                        }
                    }
                }
            }
        }
    }
    public function checkContact($contact){
        $candidate = Candidate::where('contact', $contact)->first();
        if ($candidate) {
            return array('status' => false, 'user' => 'candidate', 'userid' => $candidate->id);
        } else {
            $center = Center::where('mobile', $contact)->first();
            if ($center) {
                return array('status' => false, 'user' => 'center', 'userid' => $center->id);
            } else {
                $partner = Partner::where('spoc_mobile', $contact)->first();
                if ($partner) {
                    return array('status' => false, 'user' => 'partner', 'userid' => $partner->id);
                } else {
                    $trainer = Trainer::where('mobile', $contact)->first();
                    if ($trainer) {
                        return array('status' => false, 'user' => 'trainer', 'userid' => $trainer->id);
                    } else {
                        $trainerstatus = TrainerStatus::where([['mobile','=', $contact],['attached','=',0]])->first();
                        if ($trainerstatus) {
                            return array('status' => false, 'user' => 'trainerstatus', 'userid' => $trainerstatus->id);
                        } else {
                            return array('status' => true);
                        }
                    }
                }
            }
        }
    }



    public function checkDoc($docno, $status = 'create'){

        // * Status = true : Doc No is Vacent 
        // * Status = false : Doc No is Occupied

        $candidate = Candidate::where('doc_no', $docno)->first();
        if ($candidate) {
            return array('status' => false, 'user' => 'candidate', 'userid' => $candidate->id);
        } else {
            $trainer = Trainer::where('doc_no', $docno)->first();
            if ($trainer) {
                return array('status' => false, 'user' => 'trainer', 'userid' => $trainer->id);
            } else {
                $trainerstatus = TrainerStatus::where([['doc_no','=', $docno],['attached','=',0]])->first();
                if ($trainerstatus) {
                    return array('status' => false, 'user' => 'trainerstatus', 'userid' => $trainerstatus->id);
                } else {
                    return array('status' => true);
                }
            }
        }
    }
}