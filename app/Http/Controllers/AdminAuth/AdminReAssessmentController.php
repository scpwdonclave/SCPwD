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
        // dd($request->action);
        $request->validate([
            'reassid' => 'required',
            'action' => 'required',
            'assessment' => ($request->action == '1')?'required':'nullable',
            'agency' => ($request->action == '1')?'required':'nullable',
        ]);

        $reassessment = Reassessment::findOrFail($request->reassid);
        if (is_null($reassessment->verified) && $reassessment->batch->status) {
            
            switch ($request->action) {
                case '1':
                        $reassessment->assessment=$request->assessment;            
                        AgencyBatch::create([
                            'aa_id' => $request->agency,
                            'bt_id' => $reassessment->bt_id,
                            'aa_verified' => 0,
                            'reass_id' => $reassessment->id,
                        ]);
                
                case '2':
                        foreach ($reassessment->candidates as $candidate) {
                            if (!$candidate->assessment_status) {
                                $centerCandidate = CenterCandidateMap::find($candidate->ccd_id);
                                $centerCandidate->reassessed=0;
                                $centerCandidate->save();
                            }
                        }
                        $reassessment->verified=1;
                    break;
                default:
                    $reassessment->verified=0;
                    break;
            }

            $reassessment->save();
            
            $batchid = $reassessment->batch->batch_id;
            if ($request->action) {
                if ($request->action == '1') {
                    AppHelper::instance()->writeNotification($reassessment->batch->agencybatch->aa_id,'agency','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.");
                }
                AppHelper::instance()->writeNotification($reassessment->batch->tc_id,'center','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.");
                AppHelper::instance()->writeNotification($reassessment->batch->tp_id,'parter','Re-Assessment Approved',"Re-Assessment of Batch (ID: <span style='color:blue;'>$batchid</span>) has been <span style='color:blue;'>Approved</span>.");
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

    public function reassessmentMarksAcceptReject(Request $request)
    {

        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchreassessment = BatchReAssessment::findOrFail($id);
            if (($batchreassessment->admin_verified==0 || ($batchreassessment->admin_verified==2 && $batchreassessment->recheck==1)) || ($batchreassessment->sup_admin_verified==0 || ($batchreassessment->sup_admin_verified==2 && $batchreassessment->recheck==1))) {
                $batch_no=$batchreassessment->batch->batch_id;
                switch ($request->action) {
                    case 'accept':
                            if ($this->guard()->user()->supadmin) {
                                $batchreassessment->sup_admin_verified=1;

                                foreach ($batchreassessment->candidateMarks as $candidate_mark) {
                                    $each_candidate= $candidate_mark->centerCandidate;
                                    if($candidate_mark->attendence==='present'){
                                        $each_candidate->passed=$candidate_mark->passed;
                                    }else{
                                        $each_candidate->passed=2;
                                    }
                                    $each_candidate->save();
                                }
                                
                                AppHelper::instance()->writeNotification(NULL,'admin','Request for Certificate',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Re-Assessment Approved by Super Admin,Please request for certificate release");
                                
                            } else {

                                $batchreassessment->admin_verified=1;
                                AppHelper::instance()->writeNotification(NULL,'admin','Assessment Approved by Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Re-Assessment Approved by Admin");
                            }
                            $batchreassessment->recheck=0;
                            $batchreassessment->reject_note=null;
                            $batchreassessment->save();
                            alert()->success("Re-Assessment has been <span style='color:blue;font-weight:bold;'> Approved </span>", 'Job Done')->html()->autoclose(3000);
                        break;
                    case 'reject':
                            if ($this->guard()->user()->supadmin) {
                                $batchreassessment->sup_admin_verified=2;
                                AppHelper::instance()->writeNotification($batchAssessment->batch->assessorbatch->as_id,'assessor','Re-Assessment Rejected by Super Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Re-Assessment Rejected by Super Admin");
                            } else {
                                $batchreassessment->admin_verified=2;
                                AppHelper::instance()->writeNotification($batchAssessment->batch->assessorbatch->as_id,'assessor','Re-Assessment Rejected by Admin',"Batch (ID: <span style='color:blue;'>$batch_no</span>) Re-Assessment Rejected by Admin");
                            }
                            $batchreassessment->reject_note=$request->reason;
                            $batchreassessment->save();
                        break;
                    
                    default:
                        break;
                }
            }
            return redirect()->back();
        }
    }


    public function reassessmentCertificateAcceptReject(Request $request)
    {
        dd($request);
    }
    
}
