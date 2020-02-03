<?php

namespace App\Http\Controllers\AdminAuth;

use App\Reassessment;
use App\Helpers\AppHelper;
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
        return 'Coming Soon';
    }

    public function pendingReAssessment()
    {
        return 'Coming Soon';
    }
    public function viewReAssessment(Request $request)
    {
        return 'Coming Soon';
    }
    public function reassessmentAccept(Request $request)
    {
        return 'Coming Soon';
    }
    public function reassessmentReject(Request $request)
    {
        return 'Coming Soon';
    }
    public function requestsReAssessment(Request $request)
    {
        $reassessments = Reassessment::all();
        return view('admin.reassessment.requests')->with(compact('reassessments'));
    }
    public function viewRequestReAssessment(Request $request)
    {

        if ($id=AppHelper::instance()->decryptThis($request->id)) {            
            $reassessment = Reassessment::findOrFail($id);
            return view('admin.reassessment.view-requests')->with(compact('reassessment'));
        } else {
            return abort(404);
        }
        
    }

    public function submitRequestReAssessment(Request $request)
    {
        $request->validate([
            'reassid' => 'required',
            'action' => 'required',
            'assessment' => 'nullable',
        ]);

        $reassessment = Reassessment::findOrFail($request->reassid);
        if (!$reassessment->verified) {
        
            $reassessment->assessment=($request->action)?$request->assessment:null;            
            $reassessment->verified=1;            
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
            
        }

        return redirect()->back();

    }
    
}
