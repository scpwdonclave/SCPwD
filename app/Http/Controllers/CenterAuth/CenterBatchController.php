<?php

namespace App\Http\Controllers\CenterAuth;

use Auth;
use Crypt;
use App\Batch;
use Carbon\Carbon;
use App\Reassessment;
use App\BatchReAssessment;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\ReassessmentCandidate;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;

class CenterBatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('center');
    }

    protected function guard()
    {
        return Auth::guard('center');
    }

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    protected function batchHasFailedorAbsentCandidate($batchData){
        $reassess_button = false;
        if ($batchData->status) {
            
            // * Batch is not Cancelled
            if ($batchData->batchreassessments->count() == 0) {

                // * Batch has not given any Re-Assessments
                if ($batchData->batchassessment) {

                    // * Batch has given an Exam
                    if ($batchData->batchassessment->supadmin_cert_rel) {

                        // * Batch certificate is Released
                        foreach ($batchData->candidatesmap as $centercandidate) {
                            if ($centercandidate->centercandidate->candidate->status && !$centercandidate->centercandidate->dropout) {
                                if ($centercandidate->centercandidate->passed == '0' || $centercandidate->centercandidate->passed == '2') {
                                    $reassess_button = true;
                                }
                            }
                        }

                    } else {
                        $reassess_button = false;
                    }
                } else {
                    $reassess_button = false;
                }
            } else {

                // * Batch has given Re-Assessment
                if ($batchData->batchreassessmentlatest->bt_reassid == $batchData->reassessmentlatest->id) {
                    if ($batchData->batchreassessmentlatest->supadmin_cert_rel) {

                        // * Batch certificate is Released
                        foreach ($batchData->candidatesmap as $centercandidate) {
                            if ($centercandidate->centercandidate->candidate->status && !$centercandidate->centercandidate->dropout) {
                                if ($centercandidate->centercandidate->passed == '0' || $centercandidate->centercandidate->passed == '2') {
                                    $reassess_button = true;
                                }
                            }
                        }

                    } else {
                        $reassess_button = false;
                    }
                } else {
                    $reassess_button = false;
                }
            }

        }
        return $reassess_button;
    }

    public function batches(){
        $data = [
            'data' => Batch::where('tc_id',$this->guard()->user()->id)->get()
        ];
        return view('common.batches')->with($data);
    }
    
    public function viewBatch($id){
        if ($id=$this->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            
            // * Making Sure This Batch Belongs to The Current Center
            if ($this->guard()->user()->id == $batchData->tc_id) {
                
                // * $reassess_button will Ensures Batch has Failed or Absent Candidates during Assessment or ReAssessments
                $reassess_button = $this->batchHasFailedorAbsentCandidate($batchData);
                // $reass_completed = false;

                // if ($batchData->batchreassessmentlatest) {
                //     if ($batchData->batchreassessmentlatest->sup_admin_verified) {
                //         $reass_completed = true;
                //     } else {
                //         $reass_completed = false;
                //     }
                // } else {
                //     $reass_completed = false;
                // }
                
    
                if ($batchData->center->id==$this->guard()->user()->id) {
                    return view('common.view-batch')->with(compact('batchData','reassess_button'));
                }
            } else {
                return abort(403, 'You Have No Permission to View This');
            }
            
        }
    }

    public function reassessBatch(Request $request)
    {

        if ($batchid=AppHelper::instance()->decryptThis($request->id)) {
            $candidateArray = collect([]);
            
            $batch = Batch::findOrFail($batchid);
            
            if ($this->batchHasFailedorAbsentCandidate($batch) && $this->guard()->user()->id == $batch->tc_id) {
                if ($batch->batchreassessmentlatest) {
                    if ($batch->batchreassessments->count() == '2') {
                        alert()->info("You Have Reached <span style='color:red;font-weight:bold'>Maximum</span> No of Re-Assessment a Batch can <span style='color:blue;font-weight:bold'>Request</span> for.", 'Attention')->html()->autoclose(5000);
                        return redirect()->back();
                    } else {
                        foreach ($batch->candidatesmap as $batchCandidate) {
                            if ($batchCandidate->centercandidate->passed == '0' || $batchCandidate->centercandidate->passed == '2') {
                                $id = Crypt::encrypt($batchCandidate->centercandidate->id);
                                $batchCandidate->centercandidate->check = '<input type="checkbox">';
                                $batchCandidate->centercandidate->candidate->name;
                                $batchCandidate->centercandidate->candidate->contact;
                                $batchCandidate->centercandidate->candidate->category;
                                $batchCandidate->centercandidate->disability->e_expository;
                                $batchCandidate->centercandidate->passed;
                                $batchCandidate->centercandidate->view = '<button type="button" onclick="viewcandidate(\''.$id.'\')" class="badge bg-green margin-0">View</button>';
                                $batchCandidate->centercandidate->data = $id;
                                $candidateArray->push($batchCandidate->centercandidate);
                            }
                        }
                    }
                } else {
                    foreach ($batch->candidatesmap as $batchCandidate) {
                        if ($batchCandidate->centercandidate->passed == '0' || $batchCandidate->centercandidate->passed == '2') {
                            $id = Crypt::encrypt($batchCandidate->centercandidate->id);
                            $batchCandidate->centercandidate->check = '<input type="checkbox">';
                            $batchCandidate->centercandidate->candidate->name;
                            $batchCandidate->centercandidate->candidate->contact;
                            $batchCandidate->centercandidate->candidate->category;
                            $batchCandidate->centercandidate->disability->e_expository;
                            $batchCandidate->centercandidate->passed;
                            $batchCandidate->centercandidate->view = '<button type="button" onclick="viewcandidate(\''.$id.'\')" class="badge bg-green margin-0">View</button>';
                            $batchCandidate->centercandidate->data = $id;
                            $candidateArray->push($batchCandidate->centercandidate);
                        }
                    }
                }                
            } else {
                return abort(403, 'You Have No Permission to View This');
            }
            
            return view('center.reassessment')->with(compact('candidateArray','batch'));
            
        }
    }

    public function reassessBatchSubmit(Request $request)
    {
        
        if ($id=AppHelper::instance()->decryptThis($request->batchid)) {
            $batch = Batch::findOrFail($id);
            if ($batch->status) {
                $reassess_candidates = [];

                if ($request->has('id')) {
                    foreach ($request->id as $ccdid) {
                        array_push($reassess_candidates,AppHelper::instance()->decryptThis($ccdid));
                    }
                }

                $reassessment = Reassessment::where([['bt_id', $id],['verified',NULL]])->first();
                if ($reassessment) {
    
                    alert()->error("A Re-Assessment Request for This Batch is Already <span style='color:blue'>in Process</span>, kindly Wait for <span style='color:blue'>Confirmation</span> from SCPwD", 'Attention')->html()->autoclose(6000);
    
                } else {
                
                    $reassessment = new Reassessment;
                    $reassessment->bt_id = $id;
                    $reassessment->tp_id = $this->guard()->user()->tp_id;
                    $reassessment->tc_id = $this->guard()->user()->id;
                    // $reassessment->as_id = $batch->assessorbatch->as_id;
                    $reassessment->save();
                    
                    foreach ($batch->candidatesmap as $batchcandidate) {
                        if ($batchcandidate->centercandidate->candidate->status && !$batchcandidate->centercandidate->dropout) {
                            if ($batchcandidate->centercandidate->passed == '0' ||$batchcandidate->centercandidate->passed == '2') {
                                
                                $reassessmentCandidate = new ReassessmentCandidate;
                                $reassessmentCandidate->ras_id = $reassessment->id;                            
                                $reassessmentCandidate->ccd_id = $batchcandidate->centercandidate->id;                           
                                $reassessmentCandidate->appear = (in_array($batchcandidate->centercandidate->id, $reassess_candidates))?1:0;
                                $reassessmentCandidate->assessment_status = ($batchcandidate->centercandidate->passed=='0')?0:1;
                                $reassessmentCandidate->save();                         
                            
                            }
                        }
                    }
                    alert()->success("A Request for Re-Assessment with Selected Candidates List has been Submitted for Review, Once <span style='color:blue'>Approved</span> or <span style='color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(8000);     
                }

                return redirect(route('center.bt.batch.view',$request->batchid));
            } else {
                return abort(403, 'Batch is Cancelled, You cannot Perform this Action');
            }
            
        } else {
            return abort(401);
        }

        return $candidateDB;
        // $reeassessment = new 
    }


    public function reassessments()
    {
        $user = $this->guard()->user();
        return view('common.reassessments')->with(compact('user'));
    }

    public function viewReAssessment(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $reassessment = Reassessment::findOrFail($id);
            if ($this->guard()->user()->id == $reassessment->tc_id) {
                $assessment_button=false;
                foreach ($reassessment->candidates as $candidate) {
                    if ($candidate->appear) {
                        $assessment_button = true;
                    }
                }
                return view('common.view-reassessment')->with(compact('reassessment','assessment_button'));
            } else {
                return abort(403,'You are not authorized to view This');
            }
            
        }
    }

    public function viewReAssessmentMarks(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchReAssessment = BatchReAssessment::findOrFail($id);
            if ($batchReAssessment->sup_admin_verified=='1') {
                if ($batchReAssessment->reassessment->tc_id == $this->guard()->user()->id) {
                    return view('common.view-reassessment-marks')->with(compact('batchReAssessment'));
                } else {
                    return abort(403, 'You are not Authorized for This Action');   
                }
            } else {
                return redirect()->back();
            }
        }
    }
}
