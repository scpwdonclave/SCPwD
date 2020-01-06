<?php

namespace App\Http\Controllers\PartnerAuth;

use DB;
use Auth;
use Gate;
use Crypt;
use Config;
use Storage;
use Validator;
use App\JobRole;
use App\Trainer;
use App\Candidate;
use App\Notification;
use App\TrainerStatus;
use App\PartnerJobrole;
use App\TrainerJobRole;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\TrainerJobroleScheme;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\TRFormValidation;
use Illuminate\Contracts\Encryption\DecryptException;

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

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function trainers(){
        $partner = $this->guard()->user();
        $trainers = Trainer::where('tp_id', $partner->id)->get();

        return view('partner.trainers')->with(compact('trainers','partner'));
    }

    public function addtrainer_api(Request $request){

        if ($request->has('mobile')) {

            $dataEmail = AppHelper::instance()->checkEmail($request->email);
            $dataMob = AppHelper::instance()->checkContact($request->mobile);
            $array = [];
            if ($dataEmail['status']) {
                $array['email'] = true;
            } else {
                if ($dataEmail['user'] == 'trainer') {
                    $trainer = TrainerStatus::find($dataEmail['userid']);
                    if ($dataEmail['docno'] == $request->doc_no) {
                        $array['email'] = true;
                    } else {
                        $array['email'] = false;
                    }
                } else {
                    $array['email'] = false;
                }
            }
            
            if ($dataMob['status']) {
                $array['mobile'] = true;
            } else {
                if ($dataMob['user'] == 'trainer') {
                    $trainer = TrainerStatus::find($dataMob['userid']);
                    if ($dataMob['docno'] == $request->doc_no) {
                        $array['mobile'] = true;
                    } else {
                        $array['mobile'] = false;
                    }
                } else {
                    $array['mobile'] = false;
                }
            }
            
            if ($array['mobile'] && $array['email']) {
                return response()->json(['success' => true], 200);
            } elseif ($array['mobile'] && !$array['email']) {
                return response()->json(['success' => false, 'message' => 'This Email ID is Registered with Someone Else'], 200);
            } elseif (!$array['mobile'] && $array['email']) {
                return response()->json(['success' => false, 'message' => 'This Mobile No is Registered with Someone Else'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'This Email ID & Mobile No is Registered with Someone Else'], 200);
            }
            

            // $validator = Validator::make($request->all(), [ 
            //     'email' => [
            //         'required',
            //         'email',
            //         'unique:trainers,email',
            //         'unique:partners,email',
            //         'unique:centers,email',
            //         Rule::unique('trainer_statuses','email')->ignore($request->email,'email'),
            //     ],
            //     'mobile' => [
            //         'required',
            //         'numeric',
            //         'unique:trainers,mobile',
            //         'unique:partners,spoc_mobile',
            //         'unique:centers,mobile',
            //         Rule::unique('trainer_statuses','mobile')->ignore($request->mobile,'mobile'),
            //     ],
            // ]);

            // if ($validator->fails()) {
            //     return response()->json(['success' => false, 'errors'=>$validator->errors()]);
            // } else {
            //     return response()->json(['success' => true], 200);
            // }
        
        } elseif ($request->has('doc_no')) {

            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Document */
            
            $data = AppHelper::instance()->checkDoc($request->doc_no);
            
            if ($data['status']) {
                return response()->json(['success' => true, 'present' => false], 200);
            } else {
                if ($data['user'] == 'trainer') {
                    $trainer = TrainerStatus::find($data['userid']);
                    if ($data['attached']) {
                        return response()->json(['success' => true, 'present'=> true, 'attached' => true, 'trainerData' => $trainer], 200);
                    } else {
                        return response()->json(['success' => true, 'present'=> true, 'attached' => false, 'trainerData' => $trainer], 200);
                    }
                } else {
                    return response()->json(['success' => false], 200);
                }
            }
            
            /* End Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
        } elseif ($request->has('sectorid')) {
            
            $jobs = PartnerJobrole::where([['tp_id', '=', $this->guard()->user()->id],['sector_id', '=', $request->sectorid]])->select('jobrole_id','status')->groupBy('jobrole_id')->get();
            
            foreach ($jobs as $job) {
                if ($job->status) {
                    $job->jobrole->job_role;
                }
            }
            
            return response()->json(['jobs' => $jobs],200);
            
        } elseif ($request->has('jobroleid')){
            $job = JobRole::find($request->jobroleid);
            if ($job) {
                return response()->json(['success' => true, 'qualifications' => $job->qualifications],200);
            } else {
                return response()->json(['success' => false],400);
            }
        } elseif ($request->has('sid')){
            $jobs = PartnerJobrole::where([['tp_id', '=', $this->guard()->user()->id],['sector_id', '=', $request->sid],['jobrole_id', '=', $request->jid]])->select('id','scheme_id','status')->get();
            
            foreach ($jobs as $job) {
                if ($job->status) {
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
                'states'   => DB::table('state_district')->get()
            ];
            return view('partner.centers.addtrainer')->with($data);
        } else {   
            return redirect(route('partner.trainers'));
        }
    }
    
    public function submittrainer(TRFormValidation $request){

        if (Gate::allows('partner-has-jobrole', Auth::shouldUse('partner'))) {

            // * Declaring Variables for Freash Trainer Entry
            $doc_file = '';
            $reassign = $status = 0;                
            $trainer_id = NULL;
            
            $result = TrainerStatus::where('doc_no', $request->doc_no)->latest()->first();
            if ($result) {

                // * A Trainer is Present with Same DOC No. So Fetching Exsting Trainer ID and Doc File
                if ($result->attached) {
                    // * Trainer is Currently Linked With a TP, So Aborting with Bad Request Code
                    return abort(400);
                } else {

                    if ($result->status) {
                        // * Trainer is in De-Linked & Activated State
                        $trainer_id = $result->trainer_id;
                        $doc_file = $result->doc_file;
                        $reassign = $status = 1;
                    } else {
                        // * Trainer is Currently in De-Linked & Deactivated State, So Aborting with Bad Request Code
                        return abort(400);
                    }
                }
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


                $trainer->qualification = $request->qualification;
                $trainer->sector_exp = $request->sector_exp;
                $trainer->teaching_exp = $request->teaching_exp;
                $trainer->qualification_doc = Storage::disk('myDisk')->put('/trainers', $request->qualification_doc);
                $trainer->ssc_no = $request->ssc_doc_no;
                if ($request->hasFile('ssc_doc')) {
                    $trainer->ssc_doc = Storage::disk('myDisk')->put('/trainers', $request->ssc_doc);
                }
                $trainer->ssc_issued = $request->ssc_start;
                $trainer->ssc_valid = $request->ssc_end;



                if ($request->has('resume')) {
                    $trainer->resume = Storage::disk('myDisk')->put('/trainers', $request->resume);
                }
                if ($request->has('other_doc')) {
                    $trainer->other_doc = Storage::disk('myDisk')->put('/trainers', $request->other_doc);
                }
                $trainer->reassign = $reassign;
                $trainer->status = $status;
                $trainer->save();     

                foreach ($request->scheme as $job) {
                    $trainerJob = new TrainerJobRole;
                    $trainerJob->tp_id = $this->guard()->user()->id;
                    $trainerJob->tr_id = $trainer->id;
                    $trainerJob->tp_job_id = $job;
                    $trainerJob->save();
                }

                $pid = $trainer->partner->tp_id;

                /* Notification For Partner */
                $notification = new Notification;
                //$notification->rel_id = 1;
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
        if ($id=$this->decryptThis($id)) {
            $trainer = Trainer::findOrFail($id);
            if ($this->guard()->user()->id === $trainer->partner->id) {
                $data = [
                    'trainerData' => $trainer,
                    'partner' => $this->guard()->user()
                ];
                return view('common.view-trainer')->with($data);
            } else {
                return abort(401);
            }
        }
    }
}
