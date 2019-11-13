<?php

namespace App\Http\Controllers\PartnerAuth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BatchCandidateMap;
use App\PartnerJobrole;
use App\TrainerJobRole;
use App\Notification;
use App\BatchUpdate;
use Carbon\Carbon;
use App\Holiday;
use App\Center;
use App\Batch;
use Config;
use Crypt;
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

    protected function getHolidays(){
        $hds = Holiday::all();
        $holidays = [];
        foreach ($hds as $hd) {
            array_push($holidays, Carbon::parse($hd->holiday_date)->toDateString());
        }
        return $holidays;
    }

    protected function isHoliday($date){
        if ($date->isWeekend() || in_array($date->toDateString(), $this->getHolidays())) {
            return true; 
        } else {
            return false;
        }
    }

    protected function trainer_availability($trainer_id, $starttime, $endtime){
        $trainer_batches = Batch::where([['completed', 0],['tr_id', $trainer_id]])->get();
        if ($trainer_batches) {
            foreach ($trainer_batches as $trainer_batch) {
                $start = Carbon::parse($trainer_batch->start_time); 
                $end = Carbon::parse($trainer_batch->end_time); 
                if ($starttime->lessThan($start)) {
                    if ($endtime->greaterThan($start)) {
                        return false;
                    }
                } else {
                    if ($starttime->lessThan($end)) {
                        return false;
                    }                
                }
            }
        } else {
            return true;
        }
        return true;
    }

    
    protected function partnerscheme($collection, $flag){
        switch ($flag) {
            case 'candidate':
                return $collection->jobrole->partnerjobrole->status;
                break;
            case 'center':
                foreach ($collection->center_jobroles as $centerjob) {
                    if ($centerjob->partnerjobrole->status) {
                        return true;
                    }
                }
                return false;
                break;
        }
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

    public function editBatch($id){
        try {
            $id = Crypt::decrypt($id);  
        } catch (DecryptException $e) {
            return abort(404);
        }
        $batchData = Batch::where([['id', $id],['tp_id', $this->guard()->user()->id],['status', 1],['ind_status', 1],['verified', 1],['completed', 0]])->first();
        if ($batchData) {

            $partnerJob = $batchData->tpjobrole;
            $filteredTrainers = collect([]);

            $partner = $this->guard()->user();
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



            $data = [
                'partner' => $partner,
                'batchData' => $batchData,
                'trainers' => $filteredTrainers,
                'holidays' => $this->getHolidays()
            ];
            return view('partner.batches.edit-batch')->with($data);
        } else {
            return abort(404);
        }        
    }
    
    public function addbatch(){
        // $hds = Holiday::all();
        // $holidays = [];
        // foreach ($hds as $hd) {
        //     array_push($holidays, $hd->holiday_date);
        // }
        $data = [
            'partner' => $this->guard()->user(),
            'holidays' => $this->getHolidays()
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

            }

            
            $centers = $partner->centers;
            foreach ($centers as $center) {
                if ($center->verified && $center->status && $this->partnerscheme($center, 'center')) {
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
                    $candidateRow = [[]];
                    foreach ($center->candidates as $candidate) {
                        if ($candidate->status && $this->partnerscheme($candidate,'candidate')) {
                            if (count($candidate->batchmap) == 0) {
                                $candidateRow[0] = '<input type="checkbox">';
                                $candidateRow[1] = $candidate->name;
                                $candidateRow[2] = $candidate->contact;
                                $candidateRow[3] = $candidate->category;
                                $candidateRow[4] = $candidate->disability->e_expository;
                                $candidateRow[5] = '<button type="button" onclick="viewcandidate('.$candidate->id.')" class="btn btn-primary btn-round waves-effect">View</button>';
                                $candidateRow[6] = $candidate->id;
                                array_push($candidateArray, $candidateRow);
                            } else {
                                foreach ($candidate->batchmap as $batchmap) {
                                    if ($batchmap->batch->completed) {
                                        $candidateRow[0] = '<input type="checkbox">';
                                        $candidateRow[1] = $candidate->name;
                                        $candidateRow[2] = $candidate->contact;
                                        $candidateRow[3] = $candidate->category;
                                        $candidateRow[4] = $candidate->disability->e_expository;
                                        $candidateRow[5] = '<button type="button" onclick="viewcandidate('.$candidate->id.')" class="btn btn-primary btn-round waves-effect">View</button>';
                                        $candidateRow[6] = $candidate->id;
                                        array_push($candidateArray, $candidateRow);
                                    }
                                }
                            }
                        }
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
                // $hds = Holiday::all();
                // $holidays = [];
                // foreach ($hds as $hd) {
                //     array_push($holidays, Carbon::parse($hd->holiday_date)->toDateString());
                // }
                /* End Custom Holiday List */


                        
                $total_days = ceil($total_hours/$request->hour);


                $start_date = Carbon::parse($request->startdate);
                // $end_date_approx = $start_date->copy()->addDays($total_days-1);
                
                            
                if ($this->isHoliday($start_date)) {
                    return response()->json(['success' => false, 'message' => 'Start Date Cannot be on a Holiday'],200);                    
                }
                // $end_date = $end_date_approx->copy();
                
                $date = $start_date->copy(); // 15-11-2019
                $count = 0;
                while ($count <= ($total_days-1)) {
                    if ($this->isHoliday($date)) {
                        while ($this->isHoliday($date)) {
                            $date->addDay();
                        }
                    } else {
                        $count ++;
                        $date->addDay();
                    }

                }
                
                $end_date = $date->subDay();

                $assessment_dates = [];             

                for ($edate = $end_date->copy()->addDay(); sizeof($assessment_dates) < 5 ; $edate->addDay()) { 
                    if (!$this->isHoliday($edate)) {
                        array_push($assessment_dates, Carbon::parse($edate->toDateString())->format('d-m-Y l'));
                    }
                }

                return response()->json(['success' => true,'assessment_dates' => $assessment_dates, 'enddate' => Carbon::parse($end_date->toDateString())->format('d-m-Y')],200);
            } else {
                return response()->json(['success' => false],400);
            }
        }

        if ($request->has('starttime') && $request->has('trainer') && $request->has('hour')) {
            if ($this->trainer_availability($request->trainer, Carbon::parse($request->starttime), Carbon::parse($request->starttime)->add($request->hour.' hours'))) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false], 200);
            }   
        }
        if ($request->has('batchid')) {
            $batch = Batch::find($request->batchid);
            if ($batch) {
                $assessment_dates = [];             
                $end_date = Carbon::parse($request->batchend);
                for ($edate = $end_date->copy()->addDay(); sizeof($assessment_dates) < 5 ; $edate->addDay()) { 
                    if (!$this->isHoliday($edate)) {
                        array_push($assessment_dates, $edate->format('d-m-Y l'));
                    }
                }
                return response()->json(['success' => true,'assessment_dates' => $assessment_dates],200);
            } else {
                return response()->json(['success' => false], 400);                
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
            'assessment.required'=>'Please Choose a Assessment Date',
            'id.required'=>'Please choose Candidates',
            'id.min'=>'Please Choose Atleast 10 Candidates',
            'id.max'=>'you can Choose Atmost 30 Candidates',
            );

        $rules = array(
            'scheme' => 'required|numeric',
            'jobrole' => 'required',
            'center' => 'required|numeric',
            'batch_time' => ['required','regex:/(1[0-2]|0?[1-9]):([0-5][05]) ?([AP][M])/'],
            'batch_hour' => ['required','regex:/^(?!4.5)[1-4]{1}([\.5]+)?$/'],
            'batch_start' => 'required',
            'batch_end' => 'required',
            'assessment' => 'required',
            'trainer' => 'required|numeric',
            // 'id' => 'required|array|min:10|max:30',
        );
        $validator = Validator::make(Input::all(), $rules,$messsages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $starttime_store = $request->batch_time;
        $starttime = Carbon::parse($starttime_store);
        $endtime = Carbon::parse($starttime_store)->add($request->batch_hour.' hours');
        $endtime_store = $endtime->format('h:i A');

        // dd($request);
        if ($this->trainer_availability($request->trainer, $starttime, $endtime)) {
            DB::transaction(function() use ($request,$starttime_store,$endtime_store){

                $job = explode(',',$request->jobrole);

                $batch = new Batch;
                $batch->tp_id = $this->guard()->user()->id;
                $batch->tr_id = $request->trainer;
                $batch->tc_id = $request->center;
                $batch->scheme_id = $request->scheme;
                $batch->jobrole_id = $job[1];
                $batch->tp_job_id = $job[0];
                $batch->start_time = $starttime_store;
                $batch->end_time = $endtime_store;
                $batch->batch_start = $request->batch_start;
                $batch->batch_end = $request->batch_end;
                $batch->assessment = $request->assessment;
                $batch->save();
    
                foreach ($request->id as $value) {
                    $batchCandidate = new BatchCandidateMap;
                    $batchCandidate->bt_id = $batch->id; 
                    $batchCandidate->candidate_id = $value;
                    $batchCandidate->save();
                }

                DB::table('trainer_batch_map')->insert(['tr_id'=> $batch->tr_id, 'bt_id'=> $batch->id, 'start'=> $batch->batch_start, 'end'=> $batch->batch_end]);
                DB::table('batch_trainer_map')->insert(['bt_id'=> $batch->id, 'tr_id'=> $batch->tr_id, 'assign_date'=> $batch->batch_start]);
    
                $partner = $this->guard()->user();
                /* For Admin */
                $notification = new Notification;
                $notification->rel_id = 1;
                $notification->rel_with = 'admin';
                $notification->title = 'New Batch Registred';
                $notification->message = "TP (ID $partner->tp_id) has Registered a Batch. Pending Batch <span style='color:blue;'>Verification</span>.";
                $notification->save();
            });

            alert()->success("Batch has Been Created and Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(6000);
            return redirect()->back();
        } else {
            alert()->error("The Selected Trainer isn't <span style='font-weight:bold;color:red'>Available</span> on Requested Time, Please Change Batch Time or choose another Trainer", 'Attention')->html()->autoclose(6000);
            return redirect()->back();
        }
    }

    public function submitEditBatch(Request $request){
        $request->validate([
            'batchid' => 'required|numeric',
            'trainer' => 'required|numeric',
            'batch_end' => 'required',
            'assessment' => 'required',
        ]);

        $batch = Batch::findOrFail($request->batchid);
        if ($batch->tp_id == $this->guard()->user()->id) {
            $batchupdate = BatchUpdate::where([['bt_id', $batch->id],['action', 0]])->first();
            if ($batchupdate) {
                alert()->error("You Cannot Request for an Update, While Your Last Request is still <span style='font-weight:bold;color:red'>Pending</span>, Contact Admin for Further Action", 'Abort')->html()->autoclose(6000);
                return redirect()->back();
            } else {
                if ($this->isHoliday(Carbon::parse($request->batch_end))) {
                    alert()->error('Batch End Date is on a <span style="color:red">Holiday</span>, Can not Proceed', 'Abort')->html()->autoclose(3000);
                    return redirect()->back();
                }


                if ($batch->tr_id != $request->trainer) {
                    if (!$this->trainer_availability($request->trainer, Carbon::parse($batch->start_time), Carbon::parse($batch->end_time))) {
                        alert()->error("The Selected Trainer in <span style='font-weight:bold;color:blue'>Preoccupied</span> on provided Time with Another Active Batch, Kindly Change it to Another Trainer", 'Abort')->html()->autoclose(6000);
                        return redirect()->back();
                    } else {
                        if ($this->isHoliday(Carbon::parse($request->trainer_start))) {
                            alert()->error('Batch End Date is on a <span style="color:red">Holiday</span>, Can not Proceed', 'Abort')->html()->autoclose(3000);
                            return redirect()->back();
                        }
                        $batchstore = new BatchUpdate;
                        $batchstore->bt_id = $batch->id;
                        $batchstore->tr_id = $batch->tr_id;
                        $batchstore->tp_id = $this->guard()->user()->id;
                        $batchstore->new_tr_id = $request->trainer;
                        $batchstore->new_tr_start = $request->trainer_start;
                        $batchstore->end_date = $request->batch_end;
                        $batchstore->assessment = $request->assessment;
                        $batchstore->save();
                        alert()->success("Your Update Request has been Submiited, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(6000);
                        return redirect()->back();
                    }
                } else {
                    $batchstore = new BatchUpdate;
                    $batchstore->bt_id = $batch->id;
                    $batchstore->tr_id = $batch->tr_id;
                    $batchstore->tp_id = $this->guard()->user()->id;
                    $batchstore->new_tr_id = $request->trainer;
                    $batchstore->new_tr_start = $request->trainer_start;
                    $batchstore->end_date = $request->batch_end;
                    $batchstore->assessment = $request->assessment;
                    $batchstore->save();
                    alert()->success("Your Update Request has been Submiited, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(6000);
                    return redirect()->back();
                }


                /* Codes for Notification */
                /* End Codes for Notification */

            }
            
        } else {
            return abort(401);
        }
        
    }
}
