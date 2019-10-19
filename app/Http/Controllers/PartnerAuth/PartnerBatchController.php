<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PartnerJobrole;
use App\Center;
use Auth;

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
        dd($request);
    }
}
