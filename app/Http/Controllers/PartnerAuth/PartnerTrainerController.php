<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TRFormValidation;
use Illuminate\Http\Request;
use App\TrainerStatus;
use App\Notification;
use Validator;
use Config;
use App\Trainer;
use App\Candidate;
use App\JobRole;
use App\PartnerJobrole;
use App\TrainerJobRole;
use Storage;
use Gate;
use Auth;
use DB;

class PartnerTrainerController extends Controller
{
    public function __construct()
    {
        $this->middleware('partner');
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function trainers(){
        $partner = Auth::guard('partner')->user();
        $trainers = Trainer::where('tp_id', $partner->id)->get();

        return view('partner.centers.trainers')->with(compact('trainers','partner'));
    }

    public function addtrainer_api(Request $request){

        if ($request->has('mobile')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:trainers,email|unique:trainer_statuses,email|unique:partners,email|unique:centers,email',
                'mobile' => 'required|numeric|unique:trainers,mobile|unique:trainer_statuses,mobile|unique:partners,spoc_mobile|unique:centers,mobile',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->errors()]);
            } else {
                return response()->json(['success' => true], 200);
            }
        
        } elseif ($request->has('doc_no')) {

            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
            $trainer = Trainer::where('doc_no', $request->doc_no)->first();
            if ($trainer) {
                return response()->json(['success' => false], 200);
            } else {
                $trainerStatus = TrainerStatus::where([['doc_no', $request->doc_no],['attached', 0]])->latest()->first();
                if ($trainerStatus) {
                    return response()->json(['success' => true, 'present' => true, 'trainerData' => $trainerStatus], 200);
                } else {
                    return response()->json(['success' => true, 'present' => false], 200);
                }
            }
            /* End Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
        } elseif ($request->has('sectorid')) {
            
            $jobs = PartnerJobrole::where([['tp_id', '=', Auth::guard('partner')->user()->id],['sector_id', '=', $request->sectorid]])->select('jobrole_id', 'scheme_id')->get();
            
            foreach ($jobs as $job) {
                $job->jobrole->job_role;
                $job->scheme->scheme;
            }
            
            return response()->json(['jobs' => $jobs],200);
            
        } elseif ($request->has('jobroleid')){
            $job = JobRole::find($request->jobroleid);
            if ($job) {
                return response()->json(['success' => true, 'qualification' => $job->qualification],200);
            } else {
                return response()->json(['success' => false],400);
            }
        }

    }

    public function addtrainer(){
        if (Gate::allows('partner-has-jobrole', Auth::shouldUse('partner'))) {
            $data = [
                'partner'  => Auth::guard('partner')->user(),
                'parliaments'   => DB::table('parliament')->get(),
                'states'   => DB::table('state_district')->get(),
                'config' => Config::get('constants.qualifications')
            ];
            return view('partner.centers.addtrainer')->with($data);
        } else {   
            return redirect(route('partner.trainers'));
        }
    }
    
    public function submittrainer(TRFormValidation $request){
        if (Gate::allows('partner-has-jobrole', Auth::shouldUse('partner'))) {

            DB::transaction(function() use ($request){
                $trainer = new Trainer;
                $trainer->tp_id = $this->guard()->user()->id;
                $trainer->name = $request->name;
                $trainer->email = $request->email;
                $trainer->mobile = $request->mobile;
                $trainer->doc_no = $request->doc_no;
                $trainer->doc_type = (strlen($request->doc_no) == 12)? 'Aadhaar':'Voter';
                $trainer->doc_file = Storage::disk('myDisk')->put('/trainers', $request->doc_file);

                $trainer->scpwd_no = $request->scpwd_doc_no;
                if ($request->has('scpwd_doc')) {
                    $trainer->scpwd_doc = Storage::disk('myDisk')->put('/trainers', $request->scpwd_doc);
                }
                $trainer->scpwd_issued = $request->scpwd_start;
                $trainer->scpwd_valid = $request->scpwd_end;
                if ($request->has('resume')) {
                    $trainer->resume = Storage::disk('myDisk')->put('/trainers', $request->resume);
                }
                if ($request->has('other_doc')) {
                    $trainer->other_doc = Storage::disk('myDisk')->put('/trainers', $request->other_doc);
                }

                $trainer->save();
                
                foreach ($request->jobrole as $key => $job) {

                    $trainerJob = new TrainerJobRole;
                    $data = explode(',',$job);
                    $trainerJob->jobrole_id = $data[0];
                    $trainerJob->scheme_id = $data[1];

                
                    $trainerJob->qualification = $request->qualification[$key];
                    if ($request->has('qualification_doc.'.$key)) {
                        $trainerJob->qualification_doc = Storage::disk('myDisk')->put('/trainers', $request->qualification_doc[$key]);
                    }

                    $trainerJob->tr_id = $trainer->id;
                    $trainerJob->sector_id = $request->sector[$key];
                    $trainerJob->ssc_no = $request->ssc_doc_no[$key];
                    $trainerJob->ssc_issued = $request->ssc_start[$key];
                    $trainerJob->ssc_valid = $request->ssc_end[$key];
                    if ($request->hasFile('ssc_doc.'.$key)) {
                        $trainerJob->ssc_doc = Storage::disk('myDisk')->put('/trainers', $request->ssc_doc[$key]);
                    }
                    $trainerJob->save();

                }

                $pid = $trainer->partner->tp_id;
                /* Notification For Partner */
                $notification = new Notification;
                $notification->rel_id = 1;
                $notification->rel_with = 'admin';
                $notification->title = 'New Trainer Registered';
                $notification->message = "TP (ID <span style='color:blue;'>$pid</span>) has Registered a <span style='color:blue;'>Trainer</span>. Verification is <span style='color:blue;'>Pending</span>.";
                $notification->save();
                /* End Notification For Partner */

                alert()->success("Trainer Details has Been Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(8000);
            });

            return redirect()->back();
            
        } else {
            return redirect(route('partner.trainers'));
        }

    }

    public function viewtrainer($id){
        $data = [
            'trainerData' => Trainer::findOrFail($id),
            'partner' => $this->guard()->user(),
            'trainerdoc' => TrainerJobRole::where('tr_id',$id)->get(),
        ];
        return view('common.view-trainer')->with($data);
        // return view('admin.trainers.view-trainer')->with(compact('trainerData','trainerdoc'));
    }
}
