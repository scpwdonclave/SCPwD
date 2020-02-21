<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use PDF;
use Auth;
use Crypt;
use Image;
use Carbon\Carbon;
use App\AgencyBatch;
use App\Notification;
use App\BatchAssessment;
use App\BatchReAssessment;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;

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
    protected function supadmin()
    {
        return DB::table('admins')->where('supadmin','=',1)->first();
        
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
                $notification->rel_id = $this->supadmin()->id;
                $notification->rel_with = 'admin';
                $notification->title = 'Assessment Approved by Admin';
                $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment approved by Admin";
                $notification->save();
                /* End Notification For Super Admin */
                
            }else{
                $batchAssessment->sup_admin_verified=1;

                //=====================
                foreach ($batchAssessment->candidateMarks as $key => $value) {

                        $eachcand= $value->centerCandidate;
                    if($value->attendence==='present'){
                     $eachcand->passed=$value->passed;
                     }else{
                        $eachcand->passed=2;

                     }
                    $eachcand->save();
                }

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



    public function assessmentApproveReject(Request $request)
    {
        if ($data=AppHelper::instance()->decryptThis($request->id)) {
            $id = explode(',', $data);

            if ($id[1]) {
                // Request for BatchAssessment Model (Assessment)
                $assessment=BatchAssessment::findOrFail($id[0]);
                $tag='Assessment';
            } else {
                // Request for BatchReAssessment Model (Re-Assessment)
                $assessment=BatchReAssessment::findOrFail($id[0]);
                $tag='Re-Assessment';
            }
        

            if ($this->guard()->user()->supadmin) {
                if ($request->action === 'accept') {
                    $batch_no=$assessment->batch->batch_id;

                    if ($assessment->aa_verified==1 && $assessment->admin_verified==1 && ($assessment->sup_admin_verified==0 || ($assessment->sup_admin_verified==2 && $assessment->recheck==1))) {
                
                        $assessment->sup_admin_verified=1;
                        $assessment->recheck=0;
                        $assessment->reject_note=null;
                        $assessment->save();

                        foreach ($assessment->candidateMarks as $key => $value) {

                            $eachcand= $value->centerCandidate;
                            if($value->attendence==='present'){
                                $eachcand->passed=$value->passed;
                                if ($value->passed) {
                                    $value->centerCandidate->assessment_certi_issued_on = Carbon::now();
                                    $value->centerCandidate->save();
                                }
                            }else{
                                $eachcand->passed=2;
        
                            }
                            $eachcand->save();
                        }

                        AppHelper::instance()->writeNotification(NULL,'admin',$tag.' Approved by Super Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag approved by Super Admin");
                        alert()->success("$tag has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
                    }
                } else {
                    if ($assessment->aa_verified==1 && $assessment->admin_verified==1 && ($assessment->sup_admin_verified==0 || ($assessment->sup_admin_verified==2 && $assessment->recheck==1))) {
                        
                        $assessment->sup_admin_verified=2;
                        $assessment->reject_note=$request->reason;
                        $assessment->save();
                        
                        AppHelper::instance()->writeNotification(($tag==='Assessment')?$assessment->batch->assessorbatch->as_id:$assessment->as_id,'assessor',$tag.' Rejected by Super Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag rejected by Super Admin");
                        alert()->success("$tag has been <span style='color:red;font-weight:bold;'> Rejected </span>", 'Job Done')->html()->autoclose(3000);
                    }
                }
            } else {
                if ($request->action === 'accept') {
                    $batch_no=$assessment->batch->batch_id;

                    if ($assessment->aa_verified==1 && ($assessment->admin_verified==0 || ($assessment->admin_verified==2 && $assessment->recheck==1))) {
                
                        $assessment->admin_verified=1;
                        $assessment->recheck=0;
                        $assessment->reject_note=null;
                        $assessment->save();

                        AppHelper::instance()->writeNotification($this->supadmin()->id,'admin',$tag.' Approved by Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag approved by Admin");
                        alert()->success("$tag has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
                    }
                } else {
                    if ($assessment->aa_verified==1 && ($assessment->admin_verified==0 || ($assessment->admin_verified==2 && $assessment->recheck==1))) {
                        
                        $assessment->admin_verified=2;
                        $assessment->reject_note=$request->reason;
                        $assessment->save();
                        
                        AppHelper::instance()->writeNotification(($tag==='Assessment')?$assessment->batch->assessorbatch->as_id:$assessment->as_id,'assessor',$tag.' Rejected by Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag rejected by Admin");
                        alert()->success("$tag has been <span style='color:red;font-weight:bold;'> Rejected </span>", 'Job Done')->html()->autoclose(3000);
                    }
                }
            }
        
            return redirect()->back();
        }
    }








    public function certificateReleaseApproveReject(Request $request){
      
        if ($data=AppHelper::instance()->decryptThis($request->id)) {
            $id = explode(',',$data);
            if ($id[1]) {
                // * Request for BatchAssessment Model (Assessment)
                $assessment=BatchAssessment::findOrFail($id[0]);
                $tag='Assessment';
            } else {
                // * Request for BatchReAssessment Model (Re-Assessment)
                $assessment=BatchReAssessment::findOrFail($id[0]);
                $tag='Re-Assessment';
            }
            

            if($assessment->aa_verified==1 && $assessment->admin_verified==1 && $assessment->sup_admin_verified==1 && (($assessment->admin_cert_rel==0 && $assessment->supadmin_cert_rel==0) ||($assessment->admin_cert_rel==1 && $assessment->supadmin_cert_rel==0) || ($assessment->admin_cert_rel==1 && $assessment->supadmin_cert_rel==2))){
                $batch_no=$assessment->batch->batch_id;
                
                if(!$this->guard()->user()->supadmin){
                    $assessment->admin_cert_rel=1;
                    $assessment->supadmin_cert_rel=0;
                    $assessment->reject_note=null;
                    $text="<p>$tag Certificate has been <span style='color:blue;font-weight:bold;'>Requested to Released</span> Wait for Super Admin <span style='color:red;font-weight:bold;'>Approval</span>.</p>";

                    AppHelper::instance()->writeNotification($this->supadmin()->id,'admin',$tag.' Certificate Requested',"Batch (ID: <span style='color:blue;'>$batch_no</span>) please release certificate.");            
                
                }else{

                    if ($request->action == 'accept') {
                                        
                        $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');
                        $cert_format=$assessment->batch->scheme->cert_format;
                        $cert_length=strlen($assessment->batch->scheme->cert_format)+1;
                    
                        foreach ($assessment->candidateMarks as $keys=>$value) {
                            if($value->passed){
                                // * Checking for Certificate Format

                                $data=DB::table('center_candidate_maps')
                                ->select(\DB::raw("SUBSTRING(certi_no,$cert_length,LENGTH(certi_no)-6) as certi_no"),\DB::raw("SUBSTRING(certi_no,-2) as certi_yr"))
                                ->where("certi_no", "LIKE", $cert_format."%")->get();
                                
                                if (count($data) > 0) {
                                    // * Certificates Present 

                                    $priceprod = array();
                                    $priceprod2 = array();
                                        foreach ($data as $key=>$data) {
                                            $priceprod[$key]=$data->certi_no;
                                            if($assessment->batch->scheme->fin_yr){
                                                $priceprod2[$key]=$data->certi_yr;
                                            }
                                        }
                                        $lastid= max($priceprod);
                                        if($assessment->batch->scheme->fin_yr){
                                            $lastyr= max($priceprod2);
                                        
                                            if($lastyr == substr($fyear,-2))
                                            { 
                                                $new_certi_id =$cert_format.((int)$lastid +1).'/'.$fyear;
                                            } else{ 
                                                $new_certi_id = $cert_format.'1'.'/'.$fyear ;
                                            }
                    
                                        }else{
                
                                            $new_certi_id =$cert_format.((int)$lastid +1);
                
                                        }
                                
                                } else {
                                    // * Initial Certificate 

                                    if($assessment->batch->scheme->fin_yr){
                
                                    $new_certi_id = $cert_format.'1'.'/'.$fyear;
                                    }else{
                                    $new_certi_id = $cert_format.'1';
                
                                    }
                                }
                
                                $value->centerCandidate->certi_no=$new_certi_id;
                                $value->centerCandidate->assessment_certi_issued_on= $value->centerCandidate->assessment_certi_issued_on.','.Carbon::now();
                                $value->centerCandidate->save();
                        
                            }
            
                        
                        }
                        $assessment->supadmin_cert_rel=1;
                        $assessment->reject_note=null;

                        $text="$tag Certificate has been <span style='color:blue;font-weight:bold;'>Released</span>.";
                        
                        AppHelper::instance()->writeNotification(NULL,'admin','Certificate Released',"Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;'>Released</span>.");
                        AppHelper::instance()->writeNotification($assessment->batch->tp_id,'partner',$tag.' Certificate Released',"Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;font-weight:bold;'>Released</span>.");
                        AppHelper::instance()->writeNotification($assessment->batch->tc_id,'center',$tag.' Certificate Released',"Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;font-weight:bold;'>Released</span>.");
                        
                    } else {
                        $assessment->supadmin_cert_rel=2;
                        $assessment->reject_note=$request->reason;
                        $assessment->save();
                        
                        $text="$tag Certificate Release Request has been <span style='color:blue;font-weight:bold;'>Rejected</span>.";
                        AppHelper::instance()->writeNotification(NULL,'admin','Certificate Released Rejected',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Certificate Release has been <span style='color:blue;'>Rejected</span>.");
                
                    }
                }
                $assessment->save();
        
                alert()->success($text, 'Job Done')->html()->autoclose(3000);
                return redirect()->back();
            }else{
                return abort(404);
            }
        }

    }

    // public function assessmentReleaseReject(Request $request){
    //     $batchAssessment=BatchAssessment::findOrFail($request->id);
    //     $batchAssessment->supadmin_cert_rel=2;
    //     $batchAssessment->reject_note=$request->reason;
    //     $batchAssessment->save();

    //     return response()->json(['success' => true], 200);
    // }

    public function  certificatePrint($id){

        if ($data=AppHelper::instance()->decryptThis($id)) {
            $id=explode(',',$data);

            // * id[1]: True => Assessment|CandidateMark, False => Reassessment|CandidateMark

            if ($id[1]) {
                // * Assessment Model
                $assessment=BatchAssessment::findOrFail($id[0]);
            } else {
                // * Re-Assessment Model
                $assessment=BatchReAssessment::findOrFail($id[0]);
            }
            
            $trigger=0;
            foreach ($assessment->candidateMarks as  $value) {
                if($value->passed===1){
                    $trigger=1;
                    break;
                }
            }
    
            if($trigger===0){
                alert()->error("No One has <span style='color:red;font-weight:bold;'> Qualified </span>for this Certification Programme", 'Attention!')->html()->autoclose(3000);
                return redirect()->back();
            } else {
                
                if ($assessment->aa_verified==1 && $assessment->admin_verified==1 && $assessment->sup_admin_verified==1 && $assessment->admin_cert_rel==1 && $assessment->supadmin_cert_rel==1){
                    $pdf=PDF::loadView('common.certificate', compact('assessment'))->setPaper('a4','landscape'); 
                    return $pdf->stream($assessment->id.'.pdf');
                }else{
                    return abort(404);
                }
            }

        }
    }
}
