<?php
namespace App\Helpers;

use App\Admin;
use Throwable;
use App\Agency;
use App\Center;
use App\Partner;
use App\Trainer;
use App\Assessor;
use App\Candidate;
use Carbon\Carbon;
use App\Notification;
use App\TrainerStatus;
use App\CenterCandidateMap;
use Illuminate\Support\Facades\DB;
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

    public function aadhaarVerify($stan, $doc_no, $transmission_datetime, $user, $userid, $username, $gender, $dob, $ccid = NULL)
    {
        try {
            $ab_url = "https://sandbox.aadhaarbridge.com/service/api/1.0/verifyUserIdDoc";
            $client_code = 'ONCL7673';
            $sub_client_code = 'ONCL7673';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $ab_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>"{\n    \"headers\": {\n        \"client_code\": \"$client_code\",\n        \"sub_client_code\": \"$sub_client_code\",\n        \"channel_code\": \"WEB_SDK\",\n        \"stan\": \"$stan\",\n        \"transmission_datetime\": \"$transmission_datetime\",\n        \"operation_mode\": \"DEFAULT\",\n        \"run_mode\": \"DEFAULT\",\n        \"actor_type\": \"DEFAULT\",\n        \"user_handle_type\": \"DEFAULT\",\n        \"user_handle_value\": \"DEFAULT\",\n        \"function_code\": \"VERIFY_AADHAAR\",\n        \"function_sub_code\": \"DATA\"\n    },\n    \"request\": {\n        \"aadhaar_details\": {\n            \"aadhaar_number\": \"$doc_no\"\n        }\n    }\n}",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $data = json_decode($response, true);
            
            DB::table('aadhaar_requests')->insert(
                ['guard' => $user, 'userid' => $userid, 'username' => $username, 'stan' => $stan, 'doc_no' => $doc_no, 'verification_code' => $data['verification_code'], 'created_at' => Carbon::now()]
            );

            if ($data['verification_code']==="000" && $data['verification_status']==="SUCCESS" && $data['response_status']['code']==="000" && $data['response_status']['status'] == "SUCCESS") {
                
                $aadhaar_response_data =  json_decode($data['verified_data'], true);

                if (!($aadhaar_response_data['Gender'] == strtoupper($gender)) && !($gender == 'Transgender')) {
                    return response()->json(['success' => false, 'message' => 'Candidate Gender Mismatch Found with Aadhaar Data'], 200);
                }

                $ageBand = explode('-', $aadhaar_response_data['Age Band']);
                if (($ageBand[0] > Carbon::parse($dob)->age) || ($ageBand[1] < Carbon::parse($dob)->age)) {
                    return response()->json(['success' => false, 'message' => 'Age Group Mismatch Found with Aadhaar Data'], 200);
                }

                if ($user === 'admin') {
                    $ccm = CenterCandidateMap::find($ccid);
                    $ccm->cd_verified = 1;
                    $ccm->save();
                }
                
                return response()->json(['success' => true, 'message' => 'Document No is Verified with Govt. Database'], 200);
            } else {
                if ($data['verified_data'] === "") {
                    if ($data['response_status']['message'] === "") {
                        return response()->json(['success' => false, 'message' => "Something Wrong with Aadhaar Verification Procees, Try Again Later"], 200);
                    } else {
                        return response()->json(['success' => false, 'message' => $data['response_status']['message']], 200);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => $data['verified_data']], 200);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something Wrong with Aadhaar Verification Procees, Try Again Later'], 200);
        }
    }
}