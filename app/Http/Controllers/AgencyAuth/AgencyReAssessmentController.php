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
        $agencyBatch=Reassessment::where('aa_id',$this->guard()->user()->id)->get();
        return view('agency.reassessment.all-reassessment')->with(compact('agencyBatch'));
    }

    public function pendingReAssessment()
    {
        return 'Coming Soon';
    }
    public function viewReAssessment(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchReAssessment=BatchReAssessment::findOrFail($id);
            return view('common.view-reassessment')->with(compact('batchReAssessment'));
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
        
        dd($request);
    }
}
