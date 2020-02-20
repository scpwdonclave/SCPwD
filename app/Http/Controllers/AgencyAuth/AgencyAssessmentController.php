<?php

namespace App\Http\Controllers\AgencyAuth;

use Auth;
use Crypt;
use App\Batch;
use App\Reason;
use App\AgencyBatch;
use App\Notification;
use App\Reassessment;
use App\BatchAssessment;
use App\BatchReAssessment;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Encryption\DecryptException;

class AgencyAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['agency','prevent-back-history']); 
    }

    protected function guard()
    {
        return Auth::guard('agency');
    }

    public function pendingAssessment(){
        $agencyBatch=AgencyBatch::where('aa_id',$this->guard()->user()->id)->get();

        return view('agency.assessment-approval')->with(compact('agencyBatch'));
        
    }

    public function assessments(){ 
        $agencyBatches=AgencyBatch::where('aa_id',$this->guard()->user()->id)->get();
        return view('agency.assessment-status')->with(compact('agencyBatches'));
    }

    public function viewAssessment($id){
        $id= AppHelper::instance()->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        if ($this->guard()->user()->id == $batchAssessment->batch->agencyBatch->aa_id) {
            return view('common.view-assessment')->with(compact('batchAssessment'));
        } else {
            return abort(403,'You are Not Authorized for This Action');
        }
        
    }

    // public function assessmentAccept($id){
    //     $id= AppHelper::instance()->decryptThis($id);
    //     $batchAssessment=BatchAssessment::findOrFail($id);
    //     if($batchAssessment->aa_verified==0 || ($batchAssessment->aa_verified==2 && $batchAssessment->recheck==1)){
    //     $batchAssessment->aa_verified=1;
    //     $batchAssessment->recheck=0;
    //     $batchAssessment->reject_note=null;
    //     $batchAssessment->save();

        
    //     /* Notification For Admin */
    //     $batch_no=$batchAssessment->batch->batch_id;
    //     $notification = new Notification;
    //     $notification->rel_with = 'admin';
    //     $notification->title = 'Assessment Approved by Agency';
    //     $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment approved by Agency";
    //     $notification->save();
    //     /* End Notification For Admin */

    //     alert()->success("Assessment has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(3000);
    //      return Redirect()->back();
    //     }else{
    //         abort(404);
    //     }
    // }

    // public function assessmentReject(Request $request){
    //     $batchAssessment=BatchAssessment::findOrFail($request->id);
    //     $batchAssessment->aa_verified=2;
    //     $batchAssessment->reject_note=$request->note;
    //     $batchAssessment->save();

    //      /* Notification For Assessor */
    //      $batch_no=$batchAssessment->batch->batch_id;
    //      $notification = new Notification;
    //      $notification->rel_id = $batchAssessment->batch->assessorbatch->as_id;
    //      $notification->rel_with = 'assessor';
    //      $notification->title = 'Assessment Rejected by Agency';
    //      $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment rejected by Agency";
    //      $notification->save();
    //      /* End Notification For Assessor */

    //     return response()->json(['success' => true], 200);
    // }


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
            

            if ($assessment->aa_verified==0 || ($assessment->aa_verified==2 && $assessment->recheck==1)) {
                $batch_no=$assessment->batch->batch_id;
                if ($request->action=='accept') {

                    $assessment->aa_verified=1;
                    $assessment->recheck=0;
                    $assessment->reject_note=null;
                    $assessment->save();

                    AppHelper::instance()->writeNotification(NULL,'admin',$tag.' Approved by Agency',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag approved by Agency");
                    alert()->success("$tag has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(3000);
                    
                } else {
                    
                    $assessment->aa_verified=2;
                    $assessment->reject_note=$request->reason;
                    $assessment->save();
                    
                    AppHelper::instance()->writeNotification(($tag==='Assessment')?$assessment->batch->assessorbatch->as_id:$assessment->as_id,'assessor',$tag.' Rejected by Agency',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag rejected by Agency");
                    alert()->success("$tag has been <span style='color:red;font-weight:bold'>Rejected</span>", 'Job Done')->html()->autoclose(3000);

                }
            }


            return redirect()->back();
            
        }
    }



    public function myBatch(){
        $agency = $this->guard()->user();
        return view('agency.batch')->with(compact('agency'));


    }
    public function myPendingBatch(){
        $agencyBatch=AgencyBatch::where([['aa_id','=',$this->guard()->user()->id],['aa_verified','=',0]])->get();
        return view('agency.agency-pending-batch')->with(compact('agencyBatch'));
    }

    public function batchAction(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $agencyBatch = AgencyBatch::findOrFail($id);
            if (!$agencyBatch->agency->status) {
                alert()->info('Kindly <span style="color:blue">Enable</span> Assessment Agency before proceed ', 'Attention')->html()->autoclose(4000);
                return redirect()->back();
            } else {
                $batchID = $agencyBatch->batch->batch_id;
                $agencyID = $agencyBatch->agency->aa_id;
                
                if ($request->action == 'accept') {
                        
                    if (!is_null($agencyBatch->reass_id)) {
                        $agencyBatch->reassessment()->update(['aa_id'=>$this->guard()->user()->id]);
                    }
                    $agencyBatch->aa_verified=1;
                    $agencyBatch->save();
                    AppHelper::instance()->writeNotification(NULL,'admin','Batch Approved by Agency',"Agency (ID: <span style='color:blue;'>$agencyID</span>) Approved Batch (ID: <span style='color:blue;'>$batchID</span>).");
                    alert()->success('Batch has been <span style="color:blue">Approved</span>', 'Job Done')->html()->autoclose(4000);
            
                } elseif ($request->action == 'reject' && $request->reason != '') {
                  
                    $agencyBatch->delete();
                    $reason = new Reason;
                    $reason->rel_with = 'admin';
                    $reason->reason = $request->reason;
                    $reason->save();
                    
                    AppHelper::instance()->writeNotification($agencyBatch->tp_id,'admin','Batch Rejected by Agency',"Agency (ID <span style='color:blue;'>$agencyID</span>) Rejected your assigned Batch.");
                    alert()->success("Batch(ID: <span style='color:blue'>$batchID</span>) has been <span style='color:red'>Rejeted</span>", 'job Done')->html()->autoclose(3000);
                } else {
                    alert()->error('Something went Wrong, Try Again', 'Oops!')->autoclose(3000);
                }
                return redirect()->route('agency.batch');
            }
        }
    }

    public function viewAssessmentBatch(Request $request)
    {
        if ($data=AppHelper::instance()->decryptThis($request->id)) {

            // * $data will consist of Batch/ReAssessment id and second parameter pointing the tables [1 for Assessment, 2 for ReAssessment]
            $id = explode(',',$data);
            $center_candidates = collect();

            if ($id[1]) {

                // * Request for Assessment Model

                $assessment_tag = 'Assessment';
                $batchData=Batch::findOrFail($id[0]);
                $assessment_date = $batchData->assessment;
                
                foreach ($batchData->candidatesmap as $candidate) {
                    if ($batchData->batchassessment) {
                        if ($candidate->centercandidate->candidateMark->attendence==='present') {
                            $candidate->centercandidate->quilified = $candidate->centercandidate->candidateMark->passed;
                        } else {
                            $candidate->centercandidate->quilified = 2;
                        }
                    } else {
                        $candidate->centercandidate->quilified = null;
                    }
                    $center_candidates->push($candidate->centercandidate);
                }
            } else {
                
                // * Request for Re-Assessment Model

                $assessment_tag = 'Re-Assessment';
                $reassessment=Reassessment::findOrFail($id[0]);
                $assessment_date = $reassessment->assessment;
                $batchData = $reassessment->batch;
                foreach ($reassessment->candidates as $candidate) {
                    if ($candidate->appear) {

                        if ($reassessment->batchreassessment) {
                            if ($candidate->candidateMark->attendence==='present') {
                                $candidate->centercandidate->quilified = $candidate->candidateMark->passed;
                            } else {
                                $candidate->centercandidate->quilified = 2;
                            }
                        } else {
                            $candidate->centercandidate->quilified = null;
                        }
                        $center_candidates->push($candidate->centercandidate);
                    }
                }
                
            } 
            
            return view('common.view-batch-assessment')->with(compact('assessment_tag','center_candidates','assessment_date','batchData'));
        }
    }
    
}
