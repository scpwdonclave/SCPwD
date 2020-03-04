<?php
namespace App\Helpers;

use App\Admin;
use App\Agency;
use App\Center;
use App\Partner;
use App\Trainer;
use App\Assessor;
use App\Candidate;
use App\Notification;
use App\TrainerStatus;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AppHelper
{
    public static function instance()
    {
        return new AppHelper();
    }

    public function writeNotification($relid,$relwith,$title,$msg,$url = NULL){
        $notification = new Notification;
        $notification->rel_id = $relid;
        $notification->rel_with = $relwith;
        $notification->title = $title;
        $notification->message = $msg;
        $notification->url = $url;
        $notification->save();
    }

    public function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function checkEmail($email){
        $admin = Admin::where('email', $email)->first();
        if ($admin) {
            return array('status' => false, 'user' => 'admin', 'userid' => $admin->id);
        } else {
            $candidate = Candidate::where('email', $email)->first();
            if ($candidate) {
                return array('status' => false, 'user' => 'candidate', 'userid' => $candidate->id, 'docno' => $candidate->doc_no);
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
    }
    public function checkContact($contact){
        $candidate = Candidate::where('contact', $contact)->first();
        if ($candidate) {
            return array('status' => false, 'user' => 'candidate', 'userid' => $candidate->id, 'docno' => $candidate->doc_no);
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
                        return array('status' => false, 'user' => 'trainer', 'userid' => $trainerstatus->id, 'attached' => $trainerstatus->attached, 'trainer_status' => $trainerstatus->status);
                    } else {
                        return array('status' => true);
                    }        
                }
            }
        }
    }
}