<?php

namespace App\Http\Controllers\PartnerAuth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PartnerJobrole;
use App\TrainerJobRole;
use Carbon\Carbon;
use App\Center;
use App\Holiday;
use App\Batch;
use Config;
use Crypt;
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
            'data' => Batch::where('tp_id',$this->guard()->user()->id)->get()
        ];
        return view('common.batches')->with($data);
    }

    public function viewBatch($id){
        $id = Crypt::decrypt($id);
        $batchData=Batch::findOrFail($id);
        if ($batchData->partner->id==$this->guard()->user()->id) {
            $partner = $this->guard()->user();
            return view('common.view-batch')->with(compact('batchData','partner'));
        } else {
            return abort(401);
        }
    }
    
    public function addbatch(){
        $hds = Holiday::all();
        $holidays = [];
        foreach ($hds as $hd) {
            array_push($holidays, $hd->holiday_date);
        }
        $data = [
            'partner' => $this->guard()->user(),
            'holidays' => $holidays
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
            $filteredTrainers = collect([]);
            $partner = $this->guard()->user();

            $partnerJob = PartnerJobrole::find($request->jobid);
            if ($partnerJob) {

                // TrainerJobroleScheme::where('scheme_id',$partnerJob->scheme_id)->first()

                $trainers = $partner->trainers;
                foreach ($trainers as $trainer) {
                    if ($trainer->status && $trainer->ind_status) {
                        foreach ($trainer->jobroles as $trainerJob) {
                            if ($trainerJob->status && $trainerJob->scheme_status) {
                                foreach ($trainerJob->schemes as $scheme) {
                                    if ($scheme->scheme_id == $partnerJob->scheme_id) {
                                        $filteredTrainers->push($trainer);
                                    }
                                }
                            }
                        }
                    }
                }

                // $trainerjobs = TrainerJobRole::where([['scheme_id', $partnerJob->scheme_id],['sector_id', $partnerJob->sector_id],['jobrole_id', $partnerJob->jobrole_id]])->get();
                // foreach ($trainerjobs as $trainerjob) {
                //     if ($trainerjob->trainer->status && $trainerjob->trainer->ind_status && $trainerjob->trainer->verified) {
                //         $filteredTrainers->push($trainerjob->trainer);
                //     }
                // }
            }

            
            $centers = $partner->centers;
            foreach ($centers as $center) {
                if ($center->status &&  $center->ind_status && $center->verified && $center->scheme_status) {
                    foreach ($center->center_jobroles as $centerJob) {
                        if ($centerJob->tp_job_id == (int)$request->jobid) {
                            $filteredCenters->push($center);
                        }
                    }
                }
            }
            return response()->json(['success' => true, 'centers' => $filteredCenters, 'trainers' => $filteredTrainers], 200);                        
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
        
        if ($request->has('startdate')) {


            /* Validation Rules */
            // startdate, starttime, hour, jobrole
            /* End Validation Rules */

            $jobrole = PartnerJobrole::find($request->jobrole);
            if ($jobrole) {
                $total_hours = $jobrole->jobrole->hours;
                /* Custom Holiday List */
                $hds = Holiday::all();
                $holidays = [];
                foreach ($hds as $hd) {
                    array_push($holidays, Carbon::parse($hd->holiday_date)->toDateString());
                }
                /* End Custom Holiday List */


                        
                $total_days = ceil($total_hours/$request->hour);


                $start_date = Carbon::parse($request->startdate);
                // $end_date_approx = $start_date->copy()->addDays($total_days-1);
                
                            
                if ($start_date->isWeekend() || in_array($start_date->toDateString(), $holidays)) {
                    return response()->json(['success' => false, 'message' => 'Start Date Cannot be on a Holiday'],200);                    
                }
                // $end_date = $end_date_approx->copy();
                
                $date = $start_date->copy(); // 15-11-2019
                $count = 0;
                while ($count <= ($total_days-1)) {
                    if ($date->isWeekend() || in_array($date->toDateString(), $holidays)) {
                        while ($date->isWeekend() || in_array($date->toDateString(), $holidays)) {
                            $date->addDay();
                        }
                    } else {
                        $count ++;
                        $date->addDay();
                    }

                }
                
                $end_date = $date->subDay();

                $assesment_dates = [];             

                for ($edate = $end_date->copy()->addDay(); sizeof($assesment_dates) < 5 ; $edate->addDay()) { 
                    if ($edate->isWeekend() || in_array($edate->toDateString(), $holidays)) {
                        
                    } else {
                        array_push($assesment_dates, Carbon::parse($edate->toDateString())->format('d-m-Y'));
                    }
                }

                return response()->json(['success' => true,'assesment_dates' => $assesment_dates, 'enddate' => Carbon::parse($end_date->toDateString())->format('d-m-Y')],200);
            } else {
                return response()->json(['success' => false],400);
            }
        }
    }

    public function submitbatch(Request $request){

        dd($request);

        /* Regex For Time */
        // ((1[0-2]|0?[1-9]):([0-5][05]) ?([AaPp][Mm]))
        /* End Regex For Time */


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
            'scheme' => 'required|numeric',
            'jobrole' => 'required|numeric',
            'center' => 'required|numeric',
            'batch_start' => 'required',
            'batch_hour' => 'required|numeric',
            'batch_end' => 'required',
            'assesment' => 'required',
            'trainer' => 'required|numeric',
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
            $batch->jobrole_id = $request->jobrole;
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
