<?php

namespace App\Http\Controllers\PartnerAuth;

use DB;
use PDF;
use Auth;
use Gate;
use Crypt;
use Config;
use Storage;
use App\Batch;
use App\Center;
use App\Holiday;
use Carbon\Carbon;
use App\BatchUpdate;
use App\Reassessment;
use App\PartnerJobrole;
use App\TrainerJobRole;
use App\BatchAssessment;
use App\BatchReAssessment;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\BatchCenterCandidateMap;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

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
    
    protected function isHolidayForAssessment($date){
        if (in_array($date->toDateString(), $this->getHolidays())) {
            return true;
        } else {
            return false;
        }
    }

    protected function trainer_availability($trainer_id, $starttime, $endtime){
        $trainer_batches = Batch::where('tr_id', $trainer_id)->get();
        if ($trainer_batches) {
            foreach ($trainer_batches as $trainer_batch) {
                if (Carbon::now()<Carbon::parse($trainer_batch->batch_end.' 23:59')) {
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
            }
        } else {
            return true;
        }
        return true;
    }

    
    protected function partnerscheme($collection, $flag, $partnerJob = NULL){
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
            case 'trainer':
                foreach ($collection->trainer_jobroles as $trainerjob) {
                    if ($trainerjob->partnerjobrole->id == $partnerJob->id && $partnerJob->status) {
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
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            if ($batchData->partner->id==$this->guard()->user()->id) {
                $partner = $this->guard()->user();
                return view('common.view-batch')->with(compact('batchData','partner'));
            } else {
                return abort(401);
            }
        }
    }

    public function editBatch($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $batchData = Batch::where([['id', $id],['tp_id', $this->guard()->user()->id],['status', 1],['verified', 1]])->first();
            if ($batchData) {
    
                $partnerJob = $batchData->tpjobrole;
                $filteredTrainers = collect([]);
    
                $partner = $this->guard()->user();
                $trainers = $partner->trainers;
                    foreach ($trainers as $trainer) {
                        if ($trainer->status && $this->partnerscheme($trainer,'trainer', $partnerJob)) {
                            $filteredTrainers->push($trainer);
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
    }
    
    public function addbatch(){
        
        if (Gate::allows('partner-has-jobrole', Auth::shouldUse('partner'))) {
            $data = [
                'partner' => $this->guard()->user(),
                'holidays' => $this->getHolidays()
            ];    
            return view('partner.batches.addbatch')->with($data);
        } else {   
            return redirect(route('partner.batches'));
        }

    }

    public function addbatch_api(Request $request){
        if ($request->has('schemeid')) {
            $partner = $this->guard()->user();
            $partnerJob = PartnerJobrole::where([['scheme_id', $request->schemeid],['tp_id',$partner->id],['status',1]])->get();
            foreach ($partnerJob as $job) {
                $job->jobrole->job_role;
            }
            return response()->json(['success' => true, 'jobrole' => $partnerJob, 'disability' => $partnerJob[0]->scheme->disability], 200);                        
        }
        if ($request->has('jobid')) {
            $filteredCenters = collect([]);
            $filteredTrainers = collect([]);
            $partner = $this->guard()->user();

            $partnerJob = PartnerJobrole::find($request->jobid);
            if ($partnerJob) {

                $trainers = $partner->trainers;
                foreach ($trainers as $trainer) {
                    if ($trainer->status && $this->partnerscheme($trainer,'trainer', $partnerJob)) {
                        foreach ($trainer->trainer_jobroles as $trainerJob) {
                            if ($trainerJob->tp_job_id == (int)$request->jobid) {
                                if (is_null($trainer->scpwd_valid)) {
                                    if (is_null($trainer->ssc_valid)) {
                                        $filteredTrainers->push($trainer);
                                    } else {
                                        if (Carbon::now() <= Carbon::parse($trainer->ssc_valid)) {
                                            $filteredTrainers->push($trainer);
                                        }
                                    }
                                } else {
                                    if (Carbon::now() <= Carbon::parse($trainer->scpwd_valid)) {
                                        if (is_null($trainer->ssc_valid)) {
                                            $filteredTrainers->push($trainer);
                                        } else {
                                            if (Carbon::now() <= Carbon::parse($trainer->ssc_valid)) {
                                                $filteredTrainers->push($trainer);
                                            }
                                        }
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
            $disabilityArray = [];
            if ($center) {
                if ($center->partner->id == $partner->id) {
                    // * Making Sure that this center belongs to current partner
                    
                    $disabilityRow = [];
                    foreach ($center->candidatesmap as $centerCandidate) {
                        // * looping through all the centercandidate of that center 
                        
                        if ($centerCandidate->candidate->status && $this->partnerscheme($centerCandidate,'candidate')) {
                            // * checked candidate is active and the scheme is also active

                            if (!$centerCandidate->dropout) {
                                // * all dropped out candidates are excluded 

                                if ($centerCandidate->jobrole->partnerjobrole->scheme->id == $request->sid) {
                                    // * Making Sure Candidates are coming from same Scheme
                                    
                                    if (is_null($centerCandidate->passed)) {
                                        // * candidates either in a batch [with no results] or not in a batch
                                        
                                        if (!($centerCandidate->batchcandidate)) {
                                            // * candidates not in a batch

                                            $disabilityRow[0] = $centerCandidate->disability->id;
                                            $disabilityRow[1] = $centerCandidate->disability->expository;

                                            array_push($disabilityArray, $disabilityRow);

                                        }

                                    }

                                }

                            }
                        }
                    }
                    return response()->json(['success' => true, 'disabilities' => array_unique($disabilityArray, SORT_REGULAR)],200);               
                } else {
                    return response()->json(['success' => false],400);               
                }
            } else {
                return response()->json(['success' => true, 'disabilities' => $disabilityArray],200);
            }
        }

        if ($request->has('disabilities')) {
            $partner = $this->guard()->user();
            $center = Center::find($request->center_id);
            $candidateArray = [];
            if ($center) {
                if ($center->partner->id == $partner->id) {
                    // * Making Sure that this center belongs to current partner
                    
                    $candidateRow = [[]];
                    foreach ($center->candidatesmap as $centerCandidate) {
                        // * looping through all the centercandidate of that center 
                        
                        if ($centerCandidate->candidate->status && $this->partnerscheme($centerCandidate,'candidate')) {
                            // * checked candidate is active and the scheme is also active

                            if (!$centerCandidate->dropout) {
                                // * all dropped out candidates are excluded 

                                if ($centerCandidate->jobrole->partnerjobrole->scheme->id == $request->sid) {
                                    // * Making Sure Candidates are coming from same Scheme
                                    
                                    if (is_null($centerCandidate->passed)) {
                                        // * candidates either in a batch [with no results] or not in a batch
                                        
                                        if (!($centerCandidate->batchcandidate)) {
                                            // * candidates not in a batch

                                            $id = Crypt::encrypt($centerCandidate->id);
                                            $candidateRow[0] = '<input type="checkbox">';
                                            $candidateRow[1] = $centerCandidate->candidate->name;
                                            $candidateRow[2] = $centerCandidate->candidate->contact;
                                            $candidateRow[3] = $centerCandidate->candidate->category;
                                            $candidateRow[4] = $centerCandidate->disability->expository;
                                            $candidateRow[5] = '<button type="button" onclick="viewcandidate(\''.$id.'\')" class="badge bg-green margin-0">View</button>';
                                            $candidateRow[6] = $centerCandidate->id;

                                            foreach ($request->disabilities as $disability) {
                                                if ($centerCandidate->d_type == $disability) {
                                                    array_push($candidateArray, $candidateRow);
                                                break;
                                                }
                                            }
                                            // $candidateRow[0] = $centerCandidate->disability->id;
                                            // $candidateRow[1] = $centerCandidate->disability->expository;



                                        }

                                    }

                                }

                            }
                        }
                    }
                    return response()->json(['success' => true, 'candidates' => array_unique($candidateArray, SORT_REGULAR)],200);               
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
                $total_days = ceil($total_hours/$request->hour);
                $start_date = Carbon::parse($request->startdate);
                if ($this->isHoliday($start_date)) {
                    return response()->json(['success' => false, 'message' => 'Start Date Cannot be on a Holiday'],200);                    
                }
                
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
                    if (!$this->isHolidayForAssessment($edate)) {
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
                $batch->batch_start = Carbon::parse($request->batch_start)->format('Y-m-d');
                $batch->batch_end = Carbon::parse($request->batch_end)->format('Y-m-d');
                $batch->assessment = Carbon::parse($request->assessment)->format('Y-m-d');
                $batch->save();
    
                foreach ($request->id as $value) {
                    $batchCandidate = new BatchCenterCandidateMap;
                    $batchCandidate->bt_id = $batch->id; 
                    $batchCandidate->candidate_id = $value;
                    $batchCandidate->save();
                }

                DB::table('trainer_batch_map')->insert(['tr_id'=> $batch->tr_id, 'bt_id'=> $batch->id, 'start'=> $batch->batch_start, 'end'=> $batch->batch_end]);
                DB::table('batch_trainer_map')->insert(['bt_id'=> $batch->id, 'tr_id'=> $batch->tr_id, 'assign_date'=> $batch->batch_start]);
    
                $partner = $this->guard()->user();
                AppHelper::instance()->writeNotification(NULL,'admin','New Batch Registred',"TP (ID $partner->tp_id) has Registered a Batch. Pending Batch <span style='color:blue;'>Verification</span>.", route('admin.bt.batch.view', Crypt::encrypt($batch->id)));

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
        if (Carbon::parse($batch->batch_end.' 23:59:00')->gte(Carbon::now())) {
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
                            $batchstore->end_date = Carbon::parse($request->batch_end)->format('Y-m-d');
                            $batchstore->assessment = Carbon::parse($request->assessment)->format('Y-m-d') ;
                            $batchstore->save();

                            AppHelper::instance()->writeNotification(NULL,'admin','Batch Update Requested',"TP ".$batch->partner->spoc_name."(ID: <span style='color:blue'>$batch->batch_id</span>) Requested for an Update.", route('admin.batch.bu'));

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
                        $batchstore->end_date = Carbon::parse($request->batch_end)->format('Y-m-d');
                        $batchstore->assessment = Carbon::parse($request->assessment)->format('Y-m-d');
                        $batchstore->save();

                        AppHelper::instance()->writeNotification(NULL,'admin','Batch Update Requested',"TP ".$batch->partner->spoc_name."(ID: <span style='color:blue'>$batch->batch_id</span>) Requested for an Update.", route('admin.batch.bu'));

                        alert()->success("Your Update Request has been Submiited, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(6000);
                        return redirect()->back();
                    }

                }
                
            } else {
                return abort(401);
            }
        }
        
    }
    public function certificatePrint($id){

        if ($data=AppHelper::instance()->decryptThis($id)) {
            $id=explode(',',$data);
            $trigger=0;

            // * id[1]: True => Assessment|CenterCandidateMap, False => Reassessment|CandidateMark

            if ($id[1]) {
                // * Assessment Model
                $assessment=BatchAssessment::findOrFail($id[0]);
                foreach ($assessment->batch->candidatesmap as  $btachcandidate) {
                    if(!is_null($btachcandidate->centercandidate->certi_no)){
                        $trigger=1;
                        break;
                    }
                }

                if($trigger===0){
                    alert()->error("No One has <span style='color:red;font-weight:bold;'> Qualified </span>for this Certification Programme", 'Attention!')->html()->autoclose(3000);
                    return redirect()->back();
                } else {
                    
                    if ($assessment->aa_verified==1 && $assessment->admin_verified==1 && $assessment->sup_admin_verified==1 && $assessment->admin_cert_rel==1 && $assessment->supadmin_cert_rel==1){
                        $batch = $assessment->batch;
                        $pdf=PDF::loadView('common.certificate', compact('batch'))->setPaper('a4','landscape'); 
                        return $pdf->stream($assessment->id.'.pdf');
                    }else{
                        return abort(404);
                    }
                }
                
            } else {
                // * Re-Assessment Model
                $assessment=BatchReAssessment::findOrFail($id[0]);
                
                foreach ($assessment->candidateMarks as  $value) {
                    if($value->passed===1){
                        $trigger=1;
                        break;
                    }
                }
                
                if($trigger===0){
                    alert()->error("No One has <span style='color:red;font-weight:bold;'> Qualified </span>for this Certification Programme", 'Attention!')->html()->autoclose(3000);
                    return redirect()->back();
                } else {
                    
                    if ($assessment->aa_verified==1 && $assessment->admin_verified==1 && $assessment->sup_admin_verified==1 && $assessment->admin_cert_rel==1 && $assessment->supadmin_cert_rel==1){
                        $pdf=PDF::loadView('common.certificate', compact('assessment'))->setPaper('a4','landscape'); 
                        return $pdf->stream($assessment->id.'.pdf');
                    }else{
                        return abort(404);
                    }
                }
                
            }
            
    
            
        }


        
        // if ($id=AppHelper::instance()->decryptThis($id)) {
        //     $batchAssessment=BatchAssessment::findOrFail($id);
            
        //     if ($this->guard()->user()->id == $batchAssessment->batch->tp_id) {
        //         $trigger=0;
        //         foreach ($batchAssessment->candidateMarks as  $value) {
        //             if($value->passed===1){
        //                 $trigger=1;
        //             }
        //         }
        
        //         if(!$trigger){
        //             alert()->error("No One has <span style='color:red;font-weight:bold;'> Qualified </span>for this Certification Programme", 'Attention!')->html()->autoclose(3000);
        //             return redirect()->back();
        //         }
        //         if ($batchAssessment->aa_verified==1 && $batchAssessment->admin_verified==1 && $batchAssessment->sup_admin_verified==1 && $batchAssessment->admin_cert_rel==1 && $batchAssessment->supadmin_cert_rel==1){
        //             $pdf=PDF::loadView('common.certificate', compact('batchAssessment'))->setPaper('a4','landscape'); 
        //             return $pdf->stream($batchAssessment->id.'.pdf');
        //         }else{
        //             abort(404);
        //         }
        //     } else {
        //         return abort(403, 'You are Not Authorized for This Action');
        //     }

        // }
    }

    public function reassessments()
    {
        $user = $partner = $this->guard()->user();
        return view('common.reassessments')->with(compact('user','partner'));
    }

    public function viewReAssessment(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $reassessment = Reassessment::findOrFail($id);
            $partner = $this->guard()->user();
            if ($this->guard()->user()->id == $reassessment->tp_id) {
                $assessment_button=false;
                foreach ($reassessment->candidates as $candidate) {
                    if ($candidate->appear) {
                        $assessment_button = true;
                    }
                }
                return view('common.view-reassessment')->with(compact('reassessment','assessment_button','partner'));
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
                $partner = $this->guard()->user();
                if ($batchReAssessment->reassessment->tp_id == $this->guard()->user()->id) {
                    return view('common.view-reassessment-marks')->with(compact('batchReAssessment','partner'));
                } else {
                    return abort(403, 'You are not Authorized for This Action');   
                }
            } else {
                return redirect()->back();
            }
            
        }
    }

}
