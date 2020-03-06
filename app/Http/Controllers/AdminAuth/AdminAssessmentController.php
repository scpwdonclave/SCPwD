<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use PDF;
use Auth;
use Crypt;
use Image;
use Carbon\Carbon;
use App\AgencyBatch;
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

    public function assessmentApproveReject(Request $request)
    {
        if ($data=AppHelper::instance()->decryptThis($request->id)) {
            $id = explode(',', $data);

            if ($id[1]) {
                // * Request for BatchAssessment Model (Assessment)

                $assessment=BatchAssessment::findOrFail($id[0]);
                $tag='Assessment';
                $count = 0; // * Assessment Count
                $adminroute = route('admin.assessment.view', Crypt::encrypt($id[0]));
                $assessorroute = route('assessor.assessment.view', Crypt::encrypt($id[0]));
            } else {
                // * Request for BatchReAssessment Model (Re-Assessment)
                
                $assessment=BatchReAssessment::findOrFail($id[0]);
                $tag='Re-Assessment';
                $count = $assessment->batch->batchreassessments->count(); // * ReAssessment Count
                $adminroute = route('admin.reassessment.reassessment-status.view', Crypt::encrypt($id[0]));
                $assessorroute = route('assessor.reassessment.view', Crypt::encrypt($id[0]));
            }
        

            if ($this->guard()->user()->supadmin) {
                $batch_no=$assessment->batch->batch_id;
                if ($request->action === 'accept') {

                    if ($assessment->aa_verified==1 && $assessment->admin_verified==1 && ($assessment->sup_admin_verified==0 || ($assessment->sup_admin_verified==2 && $assessment->recheck==1))) {
                
                        $assessment->sup_admin_verified=1;
                        $assessment->sup_admin_verified_on= Carbon::now();
                        $assessment->recheck=0;
                        $assessment->reject_note=null;
                        $assessment->save();

                        foreach ($assessment->candidateMarks as $key => $value) {

                            $eachcand= $value->centerCandidate;
                            if($value->attendence==='present'){
                                $eachcand->passed=$value->passed;
                                if ($value->passed) {
                                    // * Candidate Passed The Assessment
                                    $value->centerCandidate->assessment_certi_issued_on = ($tag==='Assessment')?$assessment->batch->assessment:$assessment->reassessment->assessment;
                                    $value->centerCandidate->save();
                                } else {
                                    // * Candidate Failed The Assessment
                                    if ($count=='2') {
                                        // * This was Candidate's Second Re-Assessment, So Candidate would be Released for Re-Registration Now
                                        $eachcand->reassessed = 0;
                                    }
                                }
                            }else{
                                // * Candidate was Absent
                                $eachcand->passed=2;
                            }
                            $eachcand->save();
                        }

                        AppHelper::instance()->writeNotification($assessment->batch->partner->id,'partner',$tag.' Results out',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag Results has been <span style='color:blue;'>Published</span>, Certificates yet to be Released", route('partner.bt.batch.view', Crypt::encrypt($assessment->batch->id)));
                        AppHelper::instance()->writeNotification($assessment->batch->center->id,'center',$tag.' Results out',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag Results has been <span style='color:blue;'>Published</span>, Certificates yet to be Released", route('center.bt.batch.view', Crypt::encrypt($assessment->batch->id)));
                        AppHelper::instance()->writeNotification(0,'admin',$tag.' Approved by Super Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag approved by Super Admin. Kindly Request for Certificates",$adminroute);
                        alert()->success("$tag has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
                    }
                } else {
                    if ($assessment->aa_verified==1 && $assessment->admin_verified==1 && ($assessment->sup_admin_verified==0 || ($assessment->sup_admin_verified==2 && $assessment->recheck==1))) {
                        
                        $assessment->sup_admin_verified=2;
                        $assessment->reject_note=$request->reason;
                        $assessment->save();
                        
                        AppHelper::instance()->writeNotification(($tag==='Assessment')?$assessment->batch->assessorbatch->as_id:$assessment->reassessment->as_id,'assessor',$tag.' Rejected by Super Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag rejected by Super Admin",$assessorroute);
                        alert()->success("$tag has been <span style='color:red;font-weight:bold;'> Rejected </span>", 'Job Done')->html()->autoclose(3000);
                    }
                }
            } else {
                $batch_no=$assessment->batch->batch_id;
                if ($request->action === 'accept') {

                    if ($assessment->aa_verified==1 && ($assessment->admin_verified==0 || ($assessment->admin_verified==2 && $assessment->recheck==1))) {
                
                        $assessment->admin_verified=1;
                        $assessment->recheck=0;
                        $assessment->reject_note=null;
                        $assessment->save();

                        AppHelper::instance()->writeNotification($this->supadmin()->id,'admin',$tag.' Approved by Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag approved by Admin. Kindly <span style='color:blue;'>Approve</span> or <span style='color:blue;'>Reject</span>",$adminroute);
                        alert()->success("$tag has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
                    }
                } else {
                    if ($assessment->aa_verified==1 && ($assessment->admin_verified==0 || ($assessment->admin_verified==2 && $assessment->recheck==1))) {
                        
                        $assessment->admin_verified=2;
                        $assessment->reject_note=$request->reason;
                        $assessment->save();
                        
                        AppHelper::instance()->writeNotification(($tag==='Assessment')?$assessment->batch->assessorbatch->as_id:$assessment->reassessment->as_id,'assessor',$tag.' Rejected by Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag rejected by Admin",$assessorroute);
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
                $adminroute = route('admin.assessment.view', Crypt::encrypt($id[0]));
            } else {
                // * Request for BatchReAssessment Model (Re-Assessment)
                $assessment=BatchReAssessment::findOrFail($id[0]);
                $tag='Re-Assessment';
                $adminroute = route('admin.reassessment.reassessment-status.view', Crypt::encrypt($id[0]));
            }
            

            if($assessment->aa_verified==1 && $assessment->admin_verified==1 && $assessment->sup_admin_verified==1 && (($assessment->admin_cert_rel==0 && $assessment->supadmin_cert_rel==0) ||($assessment->admin_cert_rel==1 && $assessment->supadmin_cert_rel==0) || ($assessment->admin_cert_rel==1 && $assessment->supadmin_cert_rel==2))){
                $batch_no=$assessment->batch->batch_id;
                
                if(!$this->guard()->user()->supadmin){
                    $assessment->admin_cert_rel=1;
                    $assessment->supadmin_cert_rel=0;
                    $assessment->reject_note=null;
                    $text="<p>$tag Certificate has been <span style='color:blue;font-weight:bold;'>Requested to Released</span> Wait for Super Admin <span style='color:red;font-weight:bold;'>Approval</span>.</p>";

                    AppHelper::instance()->writeNotification(1,'admin',$tag.' Certificate Requested',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Kindly <span style='color:blue;'>Approve</span> or <span style='color:red;'>Reject</span> certificate Release.",$adminroute);            
                
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
                                $value->centerCandidate->digital_key=time().$value->centerCandidate->id.$value->centerCandidate->tc_id.$value->centerCandidate->cd_id;
                                $value->centerCandidate->assessment_certi_issued_on= $value->centerCandidate->assessment_certi_issued_on.','.Carbon::now();
                                $value->centerCandidate->save();
                        
                            }
            
                        
                        }
                        $assessment->supadmin_cert_rel=1;
                        $assessment->reject_note=null;

                        $text="$tag Certificate has been <span style='color:blue;font-weight:bold;'>Released</span>.";
                        
                        AppHelper::instance()->writeNotification(0,'admin','Certificate Released',"Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;'>Released</span>.", $adminroute);
                        AppHelper::instance()->writeNotification($assessment->batch->tp_id,'partner',$tag.' Certificate Released',"Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;'>Released</span>.",route('partner.bt.batch.view', Crypt::encrypt($assessment->batch->id)));
                        AppHelper::instance()->writeNotification($assessment->batch->tc_id,'center',$tag.' Certificate Released',"Batch (ID: <span style='color:blue;'>$batch_no</span>)  Certificate has been <span style='color:blue;'>Released</span>.",NULL);
                        
                    } else {
                        $assessment->supadmin_cert_rel=2;
                        $assessment->reject_note=$request->reason;
                        $assessment->save();
                        
                        $text="$tag Certificate Release Request has been <span style='color:blue;font-weight:bold;'>Rejected</span>.";
                        AppHelper::instance()->writeNotification(0,'admin','Certificate Released Rejected',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Certificate Release Request has been <span style='color:red;'>Rejected</span>.", $adminroute);
                
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
