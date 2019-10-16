<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TRFormValidation;
use Illuminate\Http\Request;
use App\TrainerStatus;
use App\Trainer;
use App\Candidate;
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
            $request->validate([
                'mobile' => 'required|numeric',
                'email' => 'required|email',
                'doc_no' => 'required',
            ]);
            $mobile = true;
            $email = true;
            $success = true;

            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Mobile */
            $trainer = TrainerStatus::where([['doc_no','!=', $request->doc_no],['mobile',$request->mobile],['attached','0']])->first();
            if ($trainer) {
                $mobile = false;
                $success = false;
            } else {
                /* Check If Trainer have any Trainer with Provided Mobile */
                $trainer = Trainer::where([['doc_no','!=', $request->doc_no],['mobile',$request->mobile]])->first();
                if ($trainer) {
                    $mobile = false;
                    $success = false;
                }
                /* End Check If Trainer have any Trainer with Provided Mobile */
            }
            /* End Check If Trainer Status have some Trainer in Ditatched State with Provided Mobile */
            
            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Email */
            $trainer = TrainerStatus::where([['doc_no','!=', $request->doc_no],['email',$request->email],['attached','0']])->first();
            if ($trainer) {
                $email = false;
                $success = false;
            } else {
                /* Check If Trainer have any Trainer with Provided Email */
                $trainer = Trainer::where([['doc_no','!=', $request->doc_no],['email',$request->email]])->first();
                if ($trainer) {
                    $email = false;
                    $success = false;
                }
                /* End Check If Trainer have any Trainer with Provided Email */
            }
            /* End Check If Trainer Status have some Trainer in Ditatched State with Provided Email */
            
            
            return response()->json(['success' => $success, 'mobile' => $mobile, 'email' => $email], 200);
            
        } elseif ($request->has('doc_no')) {

            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
            $trainerStatus = TrainerStatus::where('doc_no', $request->doc_no)->first();
            if ($trainerStatus) {
                return response()->json(['success' => false], 200);
            } else {
                $trainer = Trainer::where('doc_no', $request->doc_no)->first();
                if ($trainer) {
                    return response()->json(['success' => false], 200);
                } else {
                    return response()->json(['success' => true], 200);
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
            
        }

    }

    public function addtrainer(){
        if (Gate::allows('partner-has-jobrole', Auth::shouldUse('partner'))) {
            $data = [
                'partner'  => Auth::guard('partner')->user(),
                'parliaments'   => DB::table('parliament')->get(),
                'states'   => DB::table('state_district')->get(),
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
                $trainer->tp_id = Auth::guard('partner')->user()->id;
                $trainer->name = $request->name;
                $trainer->email = $request->email;
                $trainer->mobile = $request->mobile;
                $trainer->doc_no = $request->doc_no;
                $trainer->doc_type = (strlen($request->doc_no) == 12)? 'Aadhaar':'Voter';
                $trainer->doc_file = Storage::disk('myDisk')->put('/trainers', $request->doc_file);
                
                $trainer->scpwd_no = $request->scpwd_doc_no;
                $trainer->scpwd_doc = Storage::disk('myDisk')->put('/trainers', $request->scpwd_doc);
                $trainer->scpwd_issued = $request->scpwd_start;
                $trainer->scpwd_valid = $request->scpwd_end;
                $trainer->resume = Storage::disk('myDisk')->put('/trainers', $request->resume);
                if ($request->has('other_doc')) {
                    $trainer->other_doc = Storage::disk('myDisk')->put('/trainers', $request->other_doc);
                }

                $trainer->save();
                
                foreach ($request->jobrole as $key => $job) {
                    foreach ($job as $value) {
                        $trainerJob = new TrainerJobRole;
                        $data = explode(',',$value);
                        $trainerJob->jobrole_id = $data[0];
                        $trainerJob->scheme_id = $data[1];

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
                }

                // $trainerStatus = new TrainerStatus;
                // $trainerStatus->prv_id = $trainer->tp_id;
                // $trainerStatus->tp_id = $trainer->tp_id;
                // $trainerStatus->name = $trainer->name;
                // $trainerStatus->email = $trainer->email;
                // $trainerStatus->mobile = $trainer->mobile;
                // $trainerStatus->doc_no = $trainer->doc_no;
                // $trainerStatus->doc_type = $trainer->doc_type;
                // $trainerStatus->doc_file = $trainer->doc_file;
                
                // $trainerStatus->scpwd_no = $trainer->scpwd_no;
                // $trainerStatus->scpwd_doc = $trainer->scpwd_doc;
                // $trainerStatus->scpwd_issued = $trainer->scpwd_issued;
                // $trainerStatus->scpwd_valid = $trainer->scpwd_valid;
                // $trainerStatus->resume = $trainer->resume;
                // $trainerStatus->other_doc = $trainer->other_doc;
                // $trainerStatus->attached = 1;
                
                // $trainerStatus->save();

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
