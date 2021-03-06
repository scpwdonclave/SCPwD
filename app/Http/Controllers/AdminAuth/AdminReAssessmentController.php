<?php

namespace App\Http\Controllers\AdminAuth;

use App\AgencyBatch;
use App\AgencySector;
use App\Reassessment;
use App\BatchReAssessment;
use App\Helpers\AppHelper;
use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

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

    public function reassessments()
    {
        $reassessments = Reassessment::all();
        return view('common.reassessments')->with(compact('reassessments'));
    }

    public function reassessmentStatus(){
        
        $batchreassessments = BatchReAssessment::all();
        // return $batchreassessments;
        return view('admin.reassessment.reassessment-status')->with(compact('batchreassessments'));
    }


    public function reassessmentStatusView(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchReAssessment = BatchReAssessment::findOrFail($id);
            return view('common.view-reassessment-marks')->with(compact('batchReAssessment'));
        }
    }
    


    public function viewReAssessment(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {            
            $assessment_button = false;
            $reassessment = Reassessment::findOrFail($id);
            foreach ($reassessment->candidates as $candidate) {
                if ($candidate->appear) {
                    $assessment_button = true;
                }
            }

            $agencysectors = AgencySector::where('sector',$reassessment->batch->jobrole->sector_id)->get();

            $agencies = collect();

            foreach ($agencysectors as $agencysector) {
                $agencybatch = AgencyBatch::where([['aa_id',$agencysector->aa_id],['bt_id', $reassessment->bt_id]])->first();
                if (!$agencybatch) {
                     $agencies->push($agencysector->agency);
                }
            }

            return view('common.view-reassessment')->with(compact('reassessment','assessment_button','agencies'));
        } else {
            return abort(404);
        }
    }

    
    
    // * Function to Approve or Reject Centers ReAssessment Requets
    
    public function AcceptRejectReAssessment(Request $request)
    {
        // * $request->action => [1: There's atleast a single Candidate will give Exam, 2: No Candidates are giving Exam]

        $request->validate([
            'reassid' => 'required',
            'action' => 'required',
            'assessment' => ($request->action == '1')?'required':'nullable',
            'agency' => ($request->action == '1')?'required':'nullable',
        ]);
            
        // dd('Data Validated');
        $reassessment = Reassessment::findOrFail($request->reassid);
        if (is_null($reassessment->verified) && $reassessment->batch->status) {
            
            switch ($request->action) {
                case '1':
                        // * Re-Assessment Accepted [Candidates Present]
                        $reassessment->assessment=$request->assessment;            
                        AgencyBatch::create([
                            'aa_id' => $request->agency,
                            'bt_id' => $reassessment->bt_id,
                            'aa_verified' => 0,
                            'reass_id' => $reassessment->id,
                        ]);

                    // break;
                    // * Carry Forwarding this Request to next Case
                case '2':
                        // * Re-Assessment Accepted [Candidates are not Present]
                        
                        foreach ($reassessment->candidates as $candidate) {
                            if (!$candidate->appear) {
                                $centerCandidate = CenterCandidateMap::find($candidate->ccd_id);
                                $centerCandidate->reassessed=0;
                                $centerCandidate->save();
                            }
                        }
                        
                        $reassessment->verified=1;
                    break;
                    
                default:
                        // * Re-Assessment Rejected
                        $reassessment->verified=0;
                    
                    break;
            }

            $reassessment->save();
            
            $batchid = $reassessment->batch->batch_id;
            if ($request->action) {
                if ($request->action == '1') {
                    AppHelper::instance()->writeNotification($request->agency,'agency','Batch Added',"Admin has <span style='color:blue;'>assigned</span> you a Batch for Re-Assessment Kindly <span style='color:blue;'>Approve</span> or <span style='color:red;'>Reject</span>", route('agency.pending-batch'));
                }
                AppHelper::instance()->writeNotification($reassessment->batch->tc_id,'center','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.", route('center.reassessment.view', Crypt::encrypt($reassessment->id))); 
                AppHelper::instance()->writeNotification($reassessment->batch->tp_id,'parter','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.", route('partner.reassessment.view', Crypt::encrypt($reassessment->id)));
                alert()->success("Re-Assessment has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
            } else {
                AppHelper::instance()->writeNotification($reassessment->batch->tc_id,'center','Re-Assessment Rejected',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:red;'>Rejected</span>.", route('center.reassessment.view', Crypt::encrypt($reassessment->id)));
                AppHelper::instance()->writeNotification($reassessment->batch->tp_id,'parter','Re-Assessment Rejected',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:red;'>Rejected</span>.", route('partner.reassessment.view', Crypt::encrypt($reassessment->id)));
                alert()->success("Re-Assessment has been <span style='color:blue;font-weight:bold;'> Rejected </span>", 'Job Done')->html()->autoclose(3000);
            }
            
        } else {
            alert()->success("Either Batch is <span style='color:red;font-weight:bold;'>Cancelled</span> or Already been <span style='color:blue;font-weight:bold;'>Verified</span>.", 'Attention')->html()->autoclose(5000);
        }

        return redirect()->back();
    }

    // * End Function to Approve or Reject Centers ReAssessment Requets


    public function agencyRejected()
    {
        $reassessments = Reassessment::where([['verified',1],['aa_id',NULL]])->get();
        $tag = [];
        foreach ($reassessments as $key => $reassessment) {
            $tag[$key] = false;
            foreach ($reassessment->candidates as $candidate) {
                if ($candidate->appear) {
                    $tag[$key] = true;
                break;
                }
            }
        }
        return view('admin.reassessment.agency-rejected')->with(compact('reassessments', 'tag'));
    }

    public function fetchAgency(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $reassessment = Reassessment::findOrFail($id);
            $agencysectors = AgencySector::where('sector',$reassessment->batch->jobrole->sector_id)->get();

            $agencies = collect();

                foreach ($agencysectors as $agencysector) {
                    $agencybatch = AgencyBatch::where([['aa_id',$agencysector->aa_id],['bt_id', $reassessment->bt_id]])->first();
                    if (!$agencybatch) {
                        $agencies->push($agencysector->agency);
                    }
                }

            return response()->json(['success'=>true, 'agencies'=>$agencies, 'assessment'=>$reassessment->assessment, 'reassid'=>Crypt::encrypt($reassessment->id)]);
        }
    }

    public function reassignAgency(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $reassessment = Reassessment::findOrFail($id);
            $reassessment->assessment=$request->assessment;
            $reassessment->save();
            $agencyBatch = new AgencyBatch;
            $agencyBatch->aa_id=$request->agency;
            $agencyBatch->bt_id=$reassessment->bt_id;
            $agencyBatch->aa_verified=0;
            $agencyBatch->reass_id=$id;
            $agencyBatch->save();
        
            AppHelper::instance()->writeNotification($request->agency,'agency','Batch Added',"Admin has <span style='color:blue;'>assigned</span> you a Batch for Re-Assessment Kindly <span style='color:blue;'>Approve</span> or <span style='color:red;'>Reject</span>", route('agency.pending-batch'));
            alert()->success("Re-Assessment Batch has been <span style='color:blue;font-weight:bold;'>Assigned</span> to a Agency", 'Attention')->html()->autoclose(5000);
            
            return redirect()->back();
        }
    }
    
}
