<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TRFormValidation;
use Illuminate\Validation\Rule;
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
use App\TrainerJobroleScheme;
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
        $partner = $this->guard()->user();
        $trainers = Trainer::where('tp_id', $partner->id)->get();

        return view('partner.centers.trainers')->with(compact('trainers','partner'));
    }

    public function addtrainer_api(Request $request){

        if ($request->has('mobile')) {
            $validator = Validator::make($request->all(), [ 
                'email' => [
                    'required',
                    'email',
                    'unique:trainers,email',
                    'unique:partners,email',
                    'unique:centers,email',
                    Rule::unique('trainer_statuses','email')->ignore($request->email,'email'),
                ],
                'mobile' => [
                    'required',
                    'numeric',
                    'unique:trainers,mobile',
                    'unique:partners,spoc_mobile',
                    'unique:centers,mobile',
                    Rule::unique('trainer_statuses','mobile')->ignore($request->mobile,'mobile'),
                ],
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->errors()]);
            } else {
                return response()->json(['success' => true], 200);
            }
        
        } elseif ($request->has('doc_no')) {

            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
            $trainerStatus = TrainerStatus::where('doc_no', $request->doc_no)->latest()->first();
            if ($trainerStatus) {
                if ($trainerStatus->attached) {
                    return response()->json(['success' => false], 200);                        
                } else {
                    return response()->json(['success' => true, 'present' => true, 'trainerData' => $trainerStatus], 200);
                }
            } else {
                return response()->json(['success' => true, 'present' => false], 200);
            }
            /* End Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
        } elseif ($request->has('sectorid')) {
            
            $jobs = PartnerJobrole::where([['tp_id', '=', $this->guard()->user()->id],['sector_id', '=', $request->sectorid]])->select('jobrole_id','status','scheme_status')->groupBy('jobrole_id')->get();
            
            foreach ($jobs as $job) {
                if ($job->status && $job->scheme_status) {
                    $job->jobrole->job_role;
                }
            }
            
            return response()->json(['jobs' => $jobs],200);
            
        } elseif ($request->has('jobroleid')){
            $job = JobRole::find($request->jobroleid);
            if ($job) {
                return response()->json(['success' => true, 'qualification' => $job->qualification],200);
            } else {
                return response()->json(['success' => false],400);
            }
        } elseif ($request->has('sid')){
            $jobs = PartnerJobrole::where([['tp_id', '=', $this->guard()->user()->id],['sector_id', '=', $request->sid],['jobrole_id', '=', $request->jid]])->select('scheme_id','status','scheme_status')->get();
            
            foreach ($jobs as $job) {
                if ($job->status && $job->scheme_status) {
                    $job->scheme->scheme;
                }
            }
            
            return response()->json(['jobs' => $jobs],200);
        }

    }

    public function addtrainer(){
        if (Gate::allows('partner-has-jobrole', Auth::shouldUse('partner'))) {
            $data = [
                'partner'  => $this->guard()->user(),
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
            $doc_file = '';
            
            $result = TrainerStatus::where('doc_no', $request->doc_no)->latest()->first();
            if ($result) {
                if ($result->attached) {
                    return abort(400);
                } else {
                    if ($result->status) {
                        $trainer_id = $result->trainer_id;
                        $doc_file = $result->doc_file;
                        $reassign = $status = 1;
                    } else {
                        return abort(400);
                    }
                }
            } else {
                $reassign = $status = 0;                
                $trainer_id = NULL;
                // return $trainer_id;
            }
            
            DB::transaction(function() use ($request, $trainer_id, $reassign, $status, $doc_file){
                $trainer = new Trainer;
                $trainer->tp_id = $this->guard()->user()->id;
                $trainer->trainer_id = $trainer_id;
                $trainer->name = $request->name;
                $trainer->email = $request->email;
                $trainer->mobile = $request->mobile;
                $trainer->doc_no = $request->doc_no;
                $trainer->doc_type = (strlen($request->doc_no) == 12)? 'Aadhaar':'Voter';
                if ($request->has('doc_file')) {
                    $trainer->doc_file = Storage::disk('myDisk')->put('/trainers', $request->doc_file);
                } else {
                    $trainer->doc_file = $doc_file;
                }
                

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
                $trainer->reassign = $reassign;
                $trainer->status = $status;
                $trainer->save();
                

                $trainerJob = new TrainerJobRole;
                $trainerJob->tr_id = $trainer->id;
                $trainerJob->sector_id = $request->sector;
                $trainerJob->jobrole_id = $request->jobrole;
                $trainerJob->qualification = $request->qualification;
                $trainerJob->qualification_doc = Storage::disk('myDisk')->put('/trainers', $request->qualification_doc);
                $trainerJob->ssc_no = $request->ssc_doc_no;
                if ($request->hasFile('ssc_doc')) {
                    $trainerJob->ssc_doc = Storage::disk('myDisk')->put('/trainers', $request->ssc_doc);
                }
                $trainerJob->ssc_issued = $request->ssc_start;
                $trainerJob->ssc_valid = $request->ssc_end;
                $trainerJob->save();

                foreach ($request->scheme as $scheme) {
                    $trScheme = new TrainerJobroleScheme;
                    $trScheme->tr_job_id = $trainerJob->id;
                    $trScheme->scheme_id = $scheme;
                    $trScheme->save();
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
