<?php

namespace App\Http\Controllers\AgencyAuth;

use Auth;
use Crypt;
use App\Batch;
use App\Reason;
use App\AgencyBatch;
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

    // * Assessment ReAssessment Marks Approve Reject which is Submitted by Assessor

    public function assessmentApproveReject(Request $request)
    {
        if ($data=AppHelper::instance()->decryptThis($request->id)) {
            $id = explode(',', $data);

            if ($id[1]) {
                // Request for BatchAssessment Model (Assessment)
                $assessment=BatchAssessment::findOrFail($id[0]);
                $tag='Assessment';
                $adminroute = route('admin.assessment.view', Crypt::encrypt($id[0]));
                $assessorroute = route('assessor.assessment.view', Crypt::encrypt($id[0]));
            } else {
                // Request for BatchReAssessment Model (Re-Assessment)
                $assessment=BatchReAssessment::findOrFail($id[0]);
                $tag='Re-Assessment';
                $adminroute = route('admin.reassessment.reassessment-status.view', Crypt::encrypt($id[0]));
                $assessorroute = route('assessor.reassessment.view', Crypt::encrypt($id[0]));
            }
            

            if ($assessment->aa_verified==0 || ($assessment->aa_verified==2 && $assessment->recheck==1)) {
                $batch_no=$assessment->batch->batch_id;
                if ($request->action=='accept') {

                    $assessment->aa_verified=1;
                    $assessment->recheck=0;
                    $assessment->reject_note=null;
                    $assessment->save();

                    AppHelper::instance()->writeNotification(0,'admin',$tag.' Approved by Agency',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag approved by Agency. Kindly <span style='color:blue;'>Approve</span> or <span style='color:red;'>Reject</span>", $adminroute);
                    alert()->success("$tag has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(3000);
                    
                } else {
                    
                    $assessment->aa_verified=2;
                    $assessment->reject_note=$request->reason;
                    $assessment->save();
                    
                    AppHelper::instance()->writeNotification(($tag==='Assessment')?$assessment->batch->assessorbatch->as_id:$assessment->reassessment->as_id,'assessor',$tag.' Rejected by Agency',"Batch (ID: <span style='color:blue;'>$batch_no</span>) $tag rejected by Agency", $assessorroute);
                    alert()->success("$tag has been <span style='color:red;font-weight:bold'>Rejected</span>", 'Job Done')->html()->autoclose(3000);

                }
            }


            return redirect()->back();
            
        }
    }

    // * End Assessment ReAssessment Marks Approve Reject which is Submitted by Assessor



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
                    AppHelper::instance()->writeNotification(NULL,'admin','Batch Approved by Agency',"Agency (ID: <span style='color:blue;'>$agencyID</span>) Approved Batch (ID: <span style='color:blue;'>$batchID</span>).",NULL);
                    alert()->success('Batch has been <span style="color:blue">Approved</span>', 'Job Done')->html()->autoclose(4000);
            
                } elseif ($request->action == 'reject' && $request->reason != '') {
                  
                    AppHelper::instance()->writeNotification(NULL,'admin','Batch Rejected by Agency',"Agency (ID <span style='color:blue;'>$agencyID</span>) Rejected your assigned Batch.", route('admin.reassessment.agencyrejected'));
                    $agencyBatch->delete();
                    $reason = new Reason;
                    $reason->rel_with = 'admin';
                    $reason->reason = $request->reason;
                    $reason->save();
                    
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

                if ($batchData->agencybatch->agency->id != $this->guard()->user()->id) {
                    return abort(403, 'You are Not Authorized for This Action');
                }

                if (is_null($batchData->assessorbatch)) {
                    $assessor = null;    
                } else {
                    $assessor = $batchData->assessorbatch->assessor->name .' ('.$batchData->assessorbatch->assessor->as_id.')';
                }
                
                
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

                if ($reassessment->agencybatch->agency->id != $this->guard()->user()->id) {
                    return abort(403, 'You are Not Authorized for This Action');
                }

                if (is_null($reassessment->as_id)) {
                    $assessor = null;    
                } else {
                    $assessor = $reassessment->assessor->name .' ('.$reassessment->assessor->as_id.')';
                }


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
            
            return view('common.view-batch-assessment')->with(compact('assessor','assessment_tag','center_candidates','assessment_date','batchData'));
        }
    }
    
}
