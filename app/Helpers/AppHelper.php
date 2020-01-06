<?php
namespace App\Helpers;

use App\Agency;
use App\Center;
use App\Partner;
use App\Trainer;
use App\Assessor;
use App\Candidate;
use App\Notification;
use App\TrainerStatus;

class AppHelper
{
    public static function instance()
    {
        return new AppHelper();
    }

    public function writeNotification($relid,$relwith,$title,$msg){
        $notification = new Notification;
        $notification->rel_id = $relid;
        $notification->rel_with = $relwith;
        $notification->title = $title;
        $notification->message = $msg;
        $notification->save();
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
                $agency = Agency::where('email', $email)->first();
                if ($agency) {
                    return array('status' => false, 'user' => 'agency', 'userid' => $agency->id);
                } else {
                    $assessor = Assessor::where('email', $email)->first();
                    if ($assessor) {
                        return array('status' => false, 'user' => 'assessor', 'userid' => $assessor->id);
                    } else {
                        $partner = Partner::where('email', $email)->first();
                        if ($partner) {
                            return array('status' => false, 'user' => 'partner', 'userid' => $partner->id);
                        } else {
                            $trainerstatus = TrainerStatus::where('email', $email)->latest()->first();
                            if ($trainerstatus) {
                                return array('status' => false, 'user' => 'trainer', 'userid' => $trainerstatus->id, 'attached' => $trainerstatus->attached, 'docno' => $trainerstatus->doc_no);
                            } else {
                                return array('status' => true);
                            }
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
                $agency = Agency::where('mobile', $contact)->first();
                if ($agency) {
                    return array('status' => false, 'user' => 'agency', 'userid' => $agency->id);
                } else {
                    $assessor = Assessor::where('mobile', $contact)->first();
                    if ($assessor) {
                        return array('status' => false, 'user' => 'assessor', 'userid' => $assessor->id);
                    } else {
                        $partner = Partner::where('spoc_mobile', $contact)->first();
                        if ($partner) {
                            return array('status' => false, 'user' => 'partner', 'userid' => $partner->id);
                        } else {
                            $trainerstatus = TrainerStatus::where('mobile', $contact)->latest()->first();
                            if ($trainerstatus) {
                                return array('status' => false, 'user' => 'trainer', 'userid' => $trainerstatus->id, 'attached' => $trainerstatus->attached, 'docno' => $trainerstatus->doc_no);
                            } else {
                                return array('status' => true);
                            }
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
            $agency = Agency::where('aadhaar', $docno)->first();
            if ($agency) {
                return array('status' => false, 'user' => 'agency', 'userid' => $agency->id);
            } else {
                $assessor = Assessor::where('aadhaar', $docno)->first();
                if ($assessor) {
                    return array('status' => false, 'user' => 'assessor', 'userid' => $assessor->id);
                } else {
                    $trainerstatus = TrainerStatus::where('doc_no', $docno)->latest()->first();
                    if ($trainerstatus) {
                        return array('status' => false, 'user' => 'trainer', 'userid' => $trainerstatus->id, 'attached' => $trainerstatus->attached);
                    } else {
                        return array('status' => true);
                    }        
                }
            }
        }
    }
}