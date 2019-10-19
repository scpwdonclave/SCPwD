<?php

namespace App\Http\Controllers\PartnerAuth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PartnerJobrole;
use App\Center;
use App\Batch;
use App\BatchCandidateMap;
use Auth;
use DB;

class PartnerBatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('partner');
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function batches(){

        $data = [
            'partner' => $this->guard()->user(),
            'data' => Batch::where([['verified','=',1],['tp_id','=',$this->guard()->user()]])->get()
        ];
        return view('common.batches')->with($data);
    }
    
    public function addbatch(){
        $data = [
            'partner' => $this->guard()->user(),
        ];
        return view('partner.batches.addbatch')->with($data);
    }

    public function addbatch_api(Request $request){
        if ($request->has('schemeid')) {
            $partner = $this->guard()->user();
            $partnerJob = PartnerJobrole::where('scheme_id', $request->schemeid)->get();
            foreach ($partnerJob as $job) {
                $job->jobrole->job_role;
            }
            return response()->json(['success' => true, 'jobrole' => $partnerJob], 200);                        
        }
        if ($request->has('jobid')) {
            $filteredCenters = collect([]);
            $partner = $this->guard()->user();
            $partnerJob = PartnerJobrole::where('id', $request->jobid)->get();
            $centers = $partner->centers;
            foreach ($centers as $center) {
                foreach ($center->center_jobroles as $centerJob) {
                    if ($centerJob->tp_job_id == (int)$request->jobid) {
                        $filteredCenters->push($center);
                    }
                }    
            }
            return response()->json(['success' => true, 'centers' => $filteredCenters], 200);                        
        }
        if ($request->has('centerid')) {
            $partner = $this->guard()->user();
            $center = Center::find($request->centerid);
            $candidateArray = [];
            if ($center) {
                if ($center->partner->id == $partner->id) {
                    $candidates = $center->candidates;
                    foreach ($center->candidates as $candidate) {
                        if ($candidate->status && $candidate->ind_status) {
                            $candidateRow = [[]];
                            $candidateRow[0] = '<input type="checkbox">';
                            $candidateRow[1] = $candidate->name;
                            $candidateRow[2] = $candidate->contact;
                            $candidateRow[3] = $candidate->category;
                            $candidateRow[4] = $candidate->disability->e_expository;
                            $candidateRow[5] = '<button type="button" onclick="viewcandidate('.$candidate->id.')" class="btn btn-primary btn-round waves-effect">View</button>';
                            $candidateRow[6] = $candidate->id;
                        }
                        array_push($candidateArray, $candidateRow);
                    }
                    return response()->json(['success' => true, 'candidates' => $candidateArray],200);               
                } else {
                    return response()->json(['success' => false],400);               
                }
            } else {
                return response()->json(['success' => true, 'candidates' => $candidateArray],200);
            }
        }
    }

    public function submitbatch(Request $request){

        $messsages = array(
            'scheme.required'=>'Please Choose a Scheme',
            'jobrole.required'=>'Please Choose a Job role',
            'center.required'=>'Please Choose a Center',
            'trainer.required'=>'Please Choose a Trainer',
            'batch_start.required'=>'Please Choose Batch Start Date',
            'batch_end.required'=>'Please Choose Batch End Date',
            'assesment.required'=>'Please Choose a Assesment Date',
            'id.required'=>'Please choose Candidates',
            'id.min'=>'Please Choose Atleast 10 Candidates',
            'id.max'=>'you can Choose Atmost 30 Candidates',
            );

        $rules = array(
            'scheme' => 'required',
            'jobrole' => 'required',
            'center' => 'required',
            'batch_start' => 'required',
            'batch_end' => 'required',
            'assesment' => 'required',
            'trainer' => 'required',
            'id' => 'required|array|min:10|max:30',
        );
        $validator = Validator::make(Input::all(), $rules,$messsages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function() use ($request){
            $batch = new Batch;
            $batch->tp_id = $this->guard()->user()->id;
            $batch->tr_id = $request->trainer;
            $batch->tc_id = $request->center;
            $batch->scheme_id = $request->scheme;
            $batch->batch_start = $request->batch_start;
            $batch->batch_end = $request->batch_end;
            $batch->assesment = $request->assesment;
            $batch->save();

            foreach ($request->id as $value) {
                $batchCandidate = new BatchCandidateMap;
                $batchCandidate->candidate_id = $value;
                $batchCandidate->bt_id = $batch->id; 
                $batchCandidate->save();
            }
        });
        alert()->success("Batch has Been Created and Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(6000);
        return redirect()->back();
    }
}
