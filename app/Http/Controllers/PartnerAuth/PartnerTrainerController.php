<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trainer;
use App\TrainerStatus;
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
                
            // $trainer = Trainer::where([['doc_number','!=', $request->doc_no],['mobile', $request->mobile]])->first();
            // if ($trainer) {
                // $trainer = Trainer::where([['doc_number','!=', $request->doc_no],['email', $request->email]])->first();
                // if ($trainer) {
                //     return response()->json(['success' => false, 'mobile' => false, 'email' => false], 200);
                // } else {
                //     $trainer_neutral = TrainerStatus::where([['doc_number','!=', $request->doc_no],['email', $request->email],['attached', 0]])->first();
                //     if ($trainer_neutral) {
                //         return response()->json(['success' => false, 'mobile' => false, 'email' => false], 200);
                //     }
                // }
                // return response()->json(['success' => false, 'mobile' => false, 'email' => true], 200);
            // } else {
                // $trainer_neutral = TrainerStatus::where([['doc_number','!=', $request->doc_no],['mobile', $request->mobile],['attached', 0]])->first();
                // if ($trainer_neutral) {
                //     $trainer = Trainer::where([['doc_number','!=', $request->doc_no],['email', $request->email]])->first();
                //     if ($trainer) {
                //         return response()->json(['success' => false, 'mobile' => false, 'email' => false], 200);
                //     } else {
                //         $trainer_neutral = TrainerStatus::where([['doc_number','!=', $request->doc_no],['email', $request->email],['attached', 0]])->first();
                //         if ($trainer_neutral) {
                //             return response()->json(['success' => false, 'mobile' => false, 'email' => false], 200);
                //         }
                //     }
                //     return response()->json(['success' => false, 'mobile' => false, 'email' => true], 200);
                // }
            // }
            // return response()->json(['success' => true, 'mobile' => true, 'email' => true], 200);

        } elseif ($request->has('doc_no')) {

            $request->validate([
                'doc_no' => 'required',
            ]);

            /* Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
            $trainer = TrainerStatus::where('doc_number', $request->doc_no)->first();
            if ($trainer) {
                return response()->json(['success' => false], 200);
            } else {
                /* Check If Trainer have any Trainer with Provided Document */    
                // $trainer = Trainer::where('doc_number', $request->doc_no)->first();
                // if ($trainer) {
                //     return response()->json(['success' => false], 200);
                // }
                /* End Check If Trainer have any Trainer with Provided Document */    
                return response()->json(['success' => true], 200);
            }
            /* End Check If Trainer Status have any Trainer in Ditatched State with Provided Document */    
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

    public function submittrainer(Request $request){
        dd($request);
    }
}
