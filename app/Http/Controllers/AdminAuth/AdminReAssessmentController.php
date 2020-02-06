<?php

namespace App\Http\Controllers\AdminAuth;

use App\Reassessment;
use App\Helpers\AppHelper;
use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminReAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function allReAssessment()
    {
        $reassessments = Reassessment::all();
        return view('common.reassessments')->with(compact('reassessments'));
    }

    public function pendingReAssessment()
    {
        return 'Coming Soon';
    }
    public function viewReAssessment(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {            
            $assessment_button = false;
            $reassessment = Reassessment::findOrFail($id);
            foreach ($reassessment->candidates as $candidate) {
                if ($candidate->assessment_status) {
                    $assessment_button = true;
                }
            }
            return view('common.view-reassessment')->with(compact('reassessment','assessment_button'));
        } else {
            return abort(404);
        }
    }

    
    
    // * Function to Approve or Reject Centers ReAssessment Requets
    
    public function actionReAssessment(Request $request)
    {
        $request->validate([
            'reassid' => 'required',
            'action' => 'required',
            'assessment' => 'nullable',
        ]);

        $reassessment = Reassessment::findOrFail($request->reassid);
        if (is_null($reassessment->verified) && $reassessment->batch->status) {
            
            if ($request->action) {
                foreach ($reassessment->candidates as $candidate) {
                    if (!$candidate->assessment_status) {
                        $centerCandidate = CenterCandidateMap::find($candidate->ccd_id);
                        $centerCandidate->reassessed=0;
                        $centerCandidate->save();
                    }
                }
                $reassessment->assessment=$request->assessment;            
                $reassessment->verified=1;
            } else {
                $reassessment->verified=0;
            }

            $reassessment->save();
            
            $batchid = $reassessment->batch->batch_id;
            if ($request->action) {
                AppHelper::instance()->writeNotification($reassessment->batch->tc_id,'center','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.");
                AppHelper::instance()->writeNotification($reassessment->batch->tp_id,'parter','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.");
                AppHelper::instance()->writeNotification($reassessment->batch->agencybatch->aa_id,'agency','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.");
                alert()->success("Re-Assessment has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
            } else {
                AppHelper::instance()->writeNotification($reassessment->batch->tc_id,'center','Re-Assessment Rejected',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:red;'>Rejected</span>.");
                AppHelper::instance()->writeNotification($reassessment->batch->tp_id,'parter','Re-Assessment Rejected',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:red;'>Rejected</span>.");
                alert()->success("Re-Assessment has been <span style='color:blue;font-weight:bold;'> Rejected </span>", 'Job Done')->html()->autoclose(3000);
            }
            
        } else {
            alert()->success("Either Batch is <span style='color:red;font-weight:bold;'>Cancelled</span> or Already been <span style='color:blue;font-weight:bold;'>Verified</span>.", 'Attention')->html()->autoclose(5000);
        }

        return redirect()->back();
    }

    // * End Function to Approve or Reject Centers ReAssessment Requets
    



    public function reassessmentAccept(Request $request)
    {
        return 'Coming Soon';
    }
    public function reassessmentReject(Request $request)
    {
        return 'Coming Soon';
    }
    
}
