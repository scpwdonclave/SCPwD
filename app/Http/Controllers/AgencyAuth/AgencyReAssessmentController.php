<?php

namespace App\Http\Controllers\AgencyAuth;

use Auth;
use App\Reassessment;
use App\BatchReAssessment;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgencyReAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['agency','prevent-back-history']); 
    }

    protected function guard()
    {
        return Auth::guard('agency');
    }

    public function allReAssessment()
    {
        $reassessments=Reassessment::where('aa_id',$this->guard()->user()->id)->get();
        // return $reassessments;
        return view('agency.reassessment.reassessment-status')->with(compact('reassessments'));
    }

    public function pendingReAssessment()
    {
        return 'Coming Soon';
    }
    public function viewReAssessment(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchReAssessment = BatchReAssessment::findOrFail($id);
            return view('common.view-reassessment-marks')->with(compact('batchReAssessment'));
        }
    }
    public function reassessmentAccept(Request $request)
    {
        return 'Coming Soon';
    }
    public function reassessmentReject(Request $request)
    {
        return 'Coming Soon';
    }

    public function reassessmentBatches()
    {
        $reassessments = Reassessment::where('aa_id',$this->guard()->user()->id)->get();
        return view('agency.reassessment.batches')->with(compact('reassessments'));
    }
    
    public function viewReassessmentBatch(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $reassessment = Reassessment::findOrFail($id);
            $assessors = $this->guard()->user()->assessors;
            // dd($reassessment);
            return view('agency.reassessment.view-batch')->with(compact('reassessment', 'assessors'));
        }
    }

    public function submitReassessmentBatch(Request $request)
    {
        $request->validate([
            'reassid' => 'required|numeric',
            'assessor' => 'required|numeric',
        ]);
        
        $reassessment = Reassessment::findOrFail($request->reassid);
        if (is_null($reassessment->as_id)) {
            $reassessment->as_id = $request->assessor;
            $reassessment->save();
            $batchid = $reassessment->batch->batch_id;
            AppHelper::instance()->writeNotification($request->assessor,'assessor','Re-Assessment Assigned',"A Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Assigned</span> to you.");

            alert()->success("Trainer has been <span style='color:blue;font-weight:bold'>Linked</span> with This Re-Assessment Batch", 'Job Done')->html()->autoclose(4000);
        } else {
            alert()->info("This Re-Assessment is already Linked with a <span style='color:blue;font-weight:bold'>Assessor</span>", 'Attention')->html()->autoclose(4000);
        }
        return redirect()->back();
        
    }


    public function reassessmentMarksAcceptReject(Request $request)
    {

        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchreassessment = BatchReAssessment::findOrFail($id);
            if ($batchreassessment->reassessment->aa_id == $this->guard()->user()->id && ($batchreassessment->aa_verified==0 || ($batchreassessment->aa_verified==2 && $batchreassessment->recheck==1))) {
                switch ($request->action) {
                    case 'accept':
                            $batchreassessment->aa_verified=1;
                            $batchreassessment->recheck=0;
                            $batchreassessment->reject_note=null;
                            $batchreassessment->save();
                            $batch_no=$batchreassessment->batch->batch_id;

                            AppHelper::instance()->writeNotification(NULL,'admin','Re-Assessment Approved by Agency',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Re-Assessment <span style='color:blue'>Approved</span> by Agency");

                            alert()->success("Re-Assessment has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(4000);
                        break;
                    case 'reject':
                            $batchreassessment->aa_verified=2;
                            $batchreassessment->reject_note=$request->reason;
                            $batchreassessment->save();

                            $batch_no=$batchreassessment->batch->batch_id;
                            AppHelper::instance()->writeNotification($batchreassessment->reassessment->as_id,'assessor','Re-Assessment Rejected by Agency',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Re-Assessment <span style='color:red'>Rejected</span> by Agency");

                            alert()->success("Re-Assessment has been <span style='color:red;font-weight:bold'>Rejected</span>", 'Job Done')->html()->autoclose(4000);
                        break;
                    
                    default:
                        break;
                }
                return redirect()->back();

            } else {
                return abort(403,'You are not Authorized for this Action');
            }
        }            
    }
}
