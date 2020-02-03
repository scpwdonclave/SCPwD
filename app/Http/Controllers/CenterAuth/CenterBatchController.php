<?php

namespace App\Http\Controllers\CenterAuth;

use Auth;
use Crypt;
use App\Batch;
use Carbon\Carbon;
use App\Reassessment;
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

    public function batches(){
        $data = [
            'data' => Batch::where('tc_id',$this->guard()->user()->id)->get()
        ];
        return view('common.batches')->with($data);
    }

    public function viewBatch($id){
        if ($id=$this->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            $button = false;
            if ($batchData->batchreassessments->count()) {
            } else {
                if ($batchData->batchassessment) {
                    if ($batchData->batchassessment->supadmin_cert_rel) {
                        foreach ($batchData->candidatesmap as $centercandidate) {
                            if ($centercandidate->centercandidate->candidate->status && !$centercandidate->centercandidate->dropout) {
                                if ($centercandidate->centercandidate->passed === 0 || $centercandidate->centercandidate->passed === 2) {
                                    $button = true;
                                }
                            }
                        }
                    } else {
                        $button = false;
                    }
                } else {
                    $button = false;
                }
            }

            if ($batchData->center->id==$this->guard()->user()->id) {
                return view('common.view-batch')->with(compact('batchData','button'));
            }
        }
    }

    public function reassessBatch(Request $request)
    {

        if ($batchid=AppHelper::instance()->decryptThis($request->id)) {
            $candidateArray = collect([]);
            
            $batch = Batch::findOrFail($batchid);
            
            if (Carbon::parse($batch->assessment.' 23:59') < Carbon::now()) {
                if ($batch->status) {
                
                    if ($batch->batchreassessmentlatest) {
                        if ($batch->batchreassessment->count() == '2') {
                            alert()->info("You Have Requested <span style='color:red;font-weight:bold'>Maximum</span> No of Re-Assessment for This Batch.", 'Attention')->html()->autoclose(4000);
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
                    alert()->info("This Batch is Marked As <span style='color:red;font-weight:bold'>Cancelled</span>. You can not Proceed Further", 'Attention')->html()->autoclose(4000);
                    return redirect()->back();
                }
            } else {
                alert()->info("This Batch Training is not <span style='color:blue;font-weight:bold'>Completed</span> Yet.", 'Attention')->html()->autoclose(3000);
                return redirect()->back();
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

                $reassessment = Reassessment::where([['bt_id', $id],['verified',0]])->first();
                if ($reassessment) {
    
                    alert()->error("A Re-Assessment Request for This Batch is Already <span style='color:blue'>in Process</span>, kindly Wait for <span style='color:blue'>Confirmation</span> from Admin side", 'Attention')->html()->autoclose(6000);
    
                } else {
                
                    $reassessment = new Reassessment;
                    $reassessment->bt_id = $id;
                    $reassessment->aa_id = $batch->agencybatch->aa_id;
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
}
