<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TRFormValidation;
use Illuminate\Http\Request;
use App\Trainer;
use App\TrainerStatus;
use App\PartnerJobrole;
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
            $trainer = TrainerStatus::where([['doc_number','!=', $request->doc_no],['mobile',$request->mobile],['attached','0']])->first();
            if ($trainer) {
                $mobile = false;
                $success = false;
            } else {
                /* Check If Trainer have any Trainer with Provided Mobile */
                $trainer = Trainer::where([['doc_number','!=', $request->doc_no],['mobile',$request->mobile]])->first();
                if ($trainer) {
                    $mobile = false;
                    $success = false;
                }
                /* End Check If Trainer have any Trainer with Provided Mobile */
            }
            /* End Check If Trainer Status have some Trainer in Ditatched State with Provided Mobile */
            
            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Email */
            $trainer = TrainerStatus::where([['doc_number','!=', $request->doc_no],['email',$request->email],['attached','0']])->first();
            if ($trainer) {
                $email = false;
                $success = false;
            } else {
                /* Check If Trainer have any Trainer with Provided Email */
                $trainer = Trainer::where([['doc_number','!=', $request->doc_no],['email',$request->email]])->first();
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
            $trainer = TrainerStatus::where('doc_number', $request->doc_no)->first();
            if ($trainer) {
                return response()->json(['success' => false], 200);
            } else {
                return response()->json(['success' => true], 200);
            }
            /* End Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
        } elseif ($request->has('sectorid')) {
            
            $jobs = PartnerJobrole::where([['tp_id', '=', Auth::guard('partner')->user()->id],['sector_id', '=', $request->sectorid]])->select('jobrole_id')->get();
            
            foreach ($jobs as $job) {
                $job->jobrole->job_role;
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
                // 'centers'   => Center::where('tp_id', Auth::guard('partner')->user()->id)->get()
            ];
            return view('partner.centers.addtrainer')->with($data);
        } else {   
            return redirect(route('partner.tc.centers'));
        }
    }

    public function submittrainer(TRFormValidation $request){

        $trainer = new Trainer;

        $trainer->tp_id = Auth::guard('partner')->user()->id;
        $trainer->name = $request->name;
        $trainer->email = $request->email;
        $trainer->mobile = $request->mobile;
        dd($request);
    }
}
