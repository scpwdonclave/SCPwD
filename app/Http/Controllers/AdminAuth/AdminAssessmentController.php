<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use App\AgencyBatch;
use App\BatchAssessment;
use App\Notification;
use Auth;
use Crypt;
use PDF;
use DB;

class AdminAssessmentController extends Controller
{   
    public function __construct()
    {
        $this->middleware('admin'); 
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function allAssessment(){
        $agencyBatch=AgencyBatch::all();

        return view('admin.assessment.all-assessment')->with(compact('agencyBatch'));
    }

    public function pendingAssessment(){
        $agencyBatch=AgencyBatch::all();

        return view('admin.assessment.pending-assessment')->with(compact('agencyBatch'));
    }
    public function viewAssessment($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        return view('common.view-assessment')->with(compact('batchAssessment'));
    }

    public function assessmentAccept($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        if (($batchAssessment->aa_verified==1 && ($batchAssessment->admin_verified==0 || ($batchAssessment->admin_verified==2 && $batchAssessment->recheck==1) )) || ($batchAssessment->aa_verified==1 && $batchAssessment->admin_verified==1 && ($batchAssessment->sup_admin_verified==0 || ($batchAssessment->sup_admin_verified==2 && $batchAssessment->recheck==1) )) ){

            if(!$this->guard()->user()->supadmin){
                $batchAssessment->admin_verified=1;

                /* Notification For Super Admin */
                $batch_no=$batchAssessment->batch->batch_id;
                $notification = new Notification;
                $notification->rel_id =2;
                $notification->rel_with = 'admin';
                $notification->title = 'Assessment Approved by Admin';
                $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment approved by Admin";
                $notification->save();
                /* End Notification For Super Admin */
                
            }else{
                $batchAssessment->sup_admin_verified=1;

                 /* Notification For Admin */
                 $batch_no=$batchAssessment->batch->batch_id;
                 $notification = new Notification;
                 $notification->rel_with = 'admin';
                 $notification->title = 'Certificate Release Request';
                 $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment approved by Super Admin,Please request for certificate release";
                 $notification->save();
                 /* End Notification For Admin */
            }
            $batchAssessment->recheck=0;
            $batchAssessment->reject_note=null;
            $batchAssessment->save();
    
            alert()->success("Assessment has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
             return Redirect()->back();
        }else{
            abort(404);
        }
    }

    public function assessmentReject(Request $request){
        $batchAssessment=BatchAssessment::findOrFail($request->id);
        if(!$this->guard()->user()->supadmin){
            $batchAssessment->admin_verified=2;

                /* Notification For Assessor */
                $batch_no=$batchAssessment->batch->batch_id;
                $notification = new Notification;
                $notification->rel_id = $batchAssessment->batch->assessorbatch->as_id;
                $notification->rel_with = 'assessor';
                $notification->title = 'Assessment Rejected by Admin';
                $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment rejected by Admin";
                $notification->save();
                /* End Notification For Assessor */

        }else{
            $batchAssessment->sup_admin_verified=2;

            /* Notification For Assessor */
            $batch_no=$batchAssessment->batch->batch_id;
            $notification = new Notification;
            $notification->rel_id = $batchAssessment->batch->assessorbatch->as_id;
            $notification->rel_with = 'assessor';
            $notification->title = 'Assessment Rejected by Super Admin';
            $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment rejected by Super Admin";
            $notification->save();
            /* End Notification For Assessor */

        }
        $batchAssessment->reject_note=$request->note;
        $batchAssessment->save();

        return response()->json(['success' => true], 200);
    }

    public function certificateRelease($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        if(($batchAssessment->aa_verified==1 && $batchAssessment->admin_verified==1 && $batchAssessment->sup_admin_verified==1 && (($batchAssessment->admin_cert_rel==0 && $batchAssessment->supadmin_cert_rel==0) ||($batchAssessment->admin_cert_rel==1 && $batchAssessment->supadmin_cert_rel==2))) || ($batchAssessment->aa_verified==1 && $batchAssessment->admin_verified==1 && $batchAssessment->sup_admin_verified==1 && $batchAssessment->admin_cert_rel==1 && $batchAssessment->supadmin_cert_rel==0)){
        if(!$this->guard()->user()->supadmin){
            $batchAssessment->admin_cert_rel=1;
            $batchAssessment->supadmin_cert_rel=0;
            $batchAssessment->reject_note=null;
            $text="<p>Assessment Certificate has been <span style='color:blue;font-weight:bold;'>Released</span> Wait for Super Admin <span style='color:red;font-weight:bold;'>Approval</span>.</p>";
            
            /* Notification For Super Admin */
            $batch_no=$batchAssessment->batch->batch_id;
            $notification = new Notification;
            $notification->rel_id =2;
            $notification->rel_with = 'admin';
            $notification->title = 'Certificate Release Request';
            $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) please release certificate";
            $notification->save();
            /* End Notification For Super Admin */
        
        }else{
            $i=1;
            foreach ($batchAssessment->candidateMarks as $keys=>$value) {
                if($value->passed){
                $data=DB::table('candidate_marks')
                ->select(\DB::raw('SUBSTRING(certi_no,7,5) as certi_no'))
                ->where("certi_no", "LIKE", "SCPwD/%")->get();
               
                $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');
                
                if (count($data) > 0) {
        
                    $priceprod = array();
                        foreach ($data as $key=>$data) {
                            $priceprod[$key]=$data->certi_no;
                        }
                        $lastid= max($priceprod);
                       
                        $new_certi_id = (substr($lastid,-5)== $fyear) ? 'SCPwD/'.($lastid + $i).'/'.$fyear : 'SCPwD/0000'.($i).'/'.$fyear ;
                   
                } else {
                    $new_certi_id = 'SCPwD/0000'.($i).'/'.$fyear;
                }

                $value->certi_no=$new_certi_id;
                $value->save();
                $i++;
                }
            }
            //$batchAssessment->candidateMarks
            $batchAssessment->supadmin_cert_rel=1;
            $batchAssessment->reject_note=null;
            $text="Assessment Certificate has been <span style='color:blue;font-weight:bold;'>Released</span>.";

             /* Notification For Admin */
             $batch_no=$batchAssessment->batch->batch_id;
             $notification = new Notification;
             $notification->rel_with = 'admin';
             $notification->title = 'Certificate Released';
             $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;'>Released</span>";
             $notification->save();
             /* End Notification For Admin */

             /* Notification For Agency */
             $batch_no=$batchAssessment->batch->batch_id;
             $notification = new Notification;
             $notification->rel_id = $batchAssessment->batch->agencybatch->aa_id;
             $notification->rel_with = 'agency';
             $notification->title = 'Certificate Released';
             $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;'>Released</span>";
             $notification->save();
             /* End Notification For Agency */

             /* Notification For Assessor */
             $batch_no=$batchAssessment->batch->batch_id;
             $notification = new Notification;
             $notification->rel_id = $batchAssessment->batch->assessorbatch->as_id;
             $notification->rel_with = 'assessor';
             $notification->title = 'Certificate Released';
             $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;'>Released</span>";
             $notification->save();
             /* End Notification For Assessor */

        }
        $batchAssessment->save();

        alert()->success($text, 'Job Done')->html()->autoclose(3000);
        return Redirect()->back();
        }else{
            abort(404);
        }
    }

    public function assessmentReleaseReject(Request $request){
        $batchAssessment=BatchAssessment::findOrFail($request->id);
        $batchAssessment->supadmin_cert_rel=2;
        $batchAssessment->reject_note=$request->note;
        $batchAssessment->save();

        return response()->json(['success' => true], 200);
    }

    public function  certificatePrint($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        if ($batchAssessment->aa_verified==1 && $batchAssessment->admin_verified==1 && $batchAssessment->sup_admin_verified==1 && $batchAssessment->admin_cert_rel==1 && $batchAssessment->supadmin_cert_rel==1){
            $pdf=PDF::loadView('common.certificate', compact('batchAssessment'))->setPaper('a4','landscape'); 
            return $pdf->stream($batchAssessment->id.'.pdf');
        }else{
            abort(404);
        }

    }
}
