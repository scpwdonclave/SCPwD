<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Requests\TCFormValidation;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Notification;
use App\CenterJobRole;
use App\Candidate;
use App\PartnerJobrole;
use App\CenterDoc;
use App\Center;
use Auth;
use DB;

class PartnerCenterController extends Controller
{

    public function __construct()
    {
        $this->middleware('partner');
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function centers(){

        $partner = Auth::guard('partner')->user();
        $centers = Center::where('tp_id', $partner->id)->get();

        return view('partner.centers.centers')->with(compact('centers','partner'));
    }

    public function viewcenter($id){
        $data = [
            'partner' => Auth::guard('partner')->user(),
            'centerData' => Center::where('tp_id',Auth::guard('partner')->user()->id)->findOrFail($id),
            'tc_target' => CenterJobRole::where('tc_id',$id)->get(),
            'state_district' => DB::table('centers AS c')
                ->join('state_district AS s','c.state_district','=','s.id')
                ->join('parliament AS p','c.parliament','=','p.id')
                ->where('c.id',$id)->first()
        ];
        return view('common.view-center')->with($data);

    }

    public function updatecenter(Request $request){
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'value' => 'required',
        ]);
        $center = Center::find($request->id);
        if ($center->partner->id == Auth::guard('partner')->user()->id) {
            $field = $request->name;
            switch ($request->name) {
                case 'name':
                    $center->spoc_name = $request->value;
                    break;
                case 'email':
                    $duplicate = Center::where([['email','=', $request->value],['email', '!=', $center->email]])->first();
                        if ($duplicate) {
                            return response()->json(array('type' => 'error','title' => 'Duplicate Entry', 'message' => "This <span style='font-weight:bold;color:red'>Email</span> has Already been <span style='font-weight:bold;color:red'>Taken</span>"),200);        
                        } else {
                            $center->email = $request->value;
                        }
                    break;
                case 'mobile':
                    $duplicate = Center::where([['mobile','=', $request->value],['mobile', '!=', $center->mobile]])->first();
                        if ($duplicate) {
                            return response()->json(array('type' => 'error','title' => 'Duplicate Entry', 'message' => "This <span style='font-weight:bold;color:red'>Mobile No</span> has Already been <span style='font-weight:bold;color:red'>Taken</span>"),200);        
                        } else {
                            $center->mobile = $request->value;
                        }
                    break;
            }
            $center->save();
            return response()->json(array('type' => 'success','title' => 'Job Done', 'message' => "SPOC Details of <span style='font-weight:bold;color:blue'>$center->tc_id</span> has been Updated"),200);        
        } else {
            return abort(401);
        }

    }



    public function view_addcenter_form(){

        if (Gate::allows('partner-has-jobrole', Auth::shouldUse('partner'))) {
            $data = [
                'partner'  => Auth::guard('partner')->user(),
                'parliaments'   => DB::table('parliament')->get(),
                'states'   => DB::table('state_district')->get(),
                // 'centers'   => Center::where('tp_id', Auth::guard('partner')->user()->id)->get()
            ];
            return view('partner.centers.addcenter')->with($data);
        } else {   
            return redirect(route('partner.tc.centers'));
        }
    }

    public function addcenter_api(Request $request){
        if ($request->has('checkredundancy')) {
            if (Center::where($request->section,$request->checkredundancy)->first()) {
                return response()->json(['success' => false], 200);
            } else {
                return response()->json(['success' => true], 200);
            }
        } elseif ($request->has('array')) {
            foreach ($request->array as $key => $value) {
                $partnerJobRole = PartnerJobrole::find($value);
                $values = $request->values;
                if ($partnerJobRole) {
                    $remain = $partnerJobRole->target - $partnerJobRole->assigned;
                    if ($values[$key] > $remain) {
                        $job = $partnerJobRole->jobrole->job_role;
                        return response()->json(['success' => false, 'max' => $remain, 'jobrole' => $job], 200);                        
                    }
                } else {
                    return response()->json(['success' => false], 400);
                }
                
            }
            return response()->json(['success' => true], 200);
        }
    }

    public function submit_addcenter_form(TCFormValidation $request){
        
        DB::transaction(function() use ($request){


            foreach ($request->jobrole as $key => $job) {
                $partnerJobRole = PartnerJobrole::find($job);
                $jobs = $request->values;
                if ($partnerJobRole) {
                    $remain = $partnerJobRole->target - $partnerJobRole->assigned;
                    if ($request->target[$key] > $remain) {
                        // $job = $partnerJobRole->jobrole->job_role;
                        // return response()->json(['success' => false, 'max' => $remain, 'jobrole' => $job], 200);                        
                        return abort('409');
                    }
                } else {
                    return abort('409');
                    // return response()->json(['success' => false], 400);
                }
                
            }



            // $data=DB::table('centers')
            // ->select(\DB::raw('SUBSTRING(tc_id,3) as tc_id'))
            // ->where("tc_id", "LIKE", "TC%")->get();
            // $year = date('Y');
            // if (count($data) > 0) {
            //     $priceprod = array();
            //         foreach ($data as $key=>$data) {
            //             $priceprod[$key]=$data->tc_id;
            //         }
            //         $lastid= max($priceprod);
                
            //         $new_tcid = (substr($lastid, 0, 4)== $year) ? 'TC'.($lastid + 1) : 'TC'.$year.'000001';
            //     //dd($new_TCid);
            // } else {
            //     $new_tcid = 'TC'.$year.'000001';
            // }
        

            $center = new Center;
            $center->tp_id = Auth::guard('partner')->user()->id;
            // $center->tc_id = $new_tcid;
            $center->spoc_name = $request->spoc_name;
            $center->email = $request->email;
            $center->mobile = $request->mobile;
            $center->center_name = $request->center_name;
            $center->center_address = $request->center_address;
            $center->landmark = $request->landmark;
            $center->state_district = $request->state_district;
            $center->city = $request->city;
            $center->block = $request->block;
            $center->parliament = $request->parliament;
            $center->pin = $request->pin;
            $center->addr_proof = $request->addr_proof;

            $center->addr_doc = Storage::disk('myDisk')->put('/centers', $request->addr_doc);
            if ($request->hasFile('center_front_view')) {
                $center->center_front_view = Storage::disk('myDisk')->put('/centers', $request->center_front_view);
            }
            if ($request->hasFile('center_back_view')) {
                $center->center_back_view = Storage::disk('myDisk')->put('/centers', $request->center_back_view);
            }
            if ($request->hasFile('center_right_view')) {
                $center->center_right_view = Storage::disk('myDisk')->put('/centers', $request->center_right_view);
            }
            if ($request->hasFile('center_left_view')) {
                $center->center_left_view = Storage::disk('myDisk')->put('/centers', $request->center_left_view);
            }
            if ($request->hasFile('bio')) {
                $center->biometric = Storage::disk('myDisk')->put('/centers', $request->bio);
            }
            if ($request->hasFile('drink')) {
                $center->drinking = Storage::disk('myDisk')->put('/centers', $request->drink);
            }
            if ($request->hasFile('safety')) {
                $center->safety = Storage::disk('myDisk')->put('/centers', $request->safety);
            }
            $center->save();

            if ($request->has('class_room')) {
                foreach ($request->class_room as $class) {
                    $centerDoc = new CenterDoc;
                    $centerDoc->tc_id = $center->id;
                    $centerDoc->room = 'class';
                    $centerDoc->doc = Storage::disk('myDisk')->put('/centers', $class);
                    $centerDoc->save();
                }
            }
            if ($request->has('lab_room')) {
                foreach ($request->lab_room as $lab) {
                    $centerDoc = new CenterDoc;
                    $centerDoc->tc_id = $center->id;
                    $centerDoc->room = 'lab';
                    $centerDoc->doc = Storage::disk('myDisk')->put('/centers', $lab);
                    $centerDoc->save();
                }
            }

            if ($request->has('equipment_room')) {
                foreach ($request->equipment_room as $equip) {
                    $centerDoc = new CenterDoc;
                    $centerDoc->tc_id = $center->id;
                    $centerDoc->room = 'equip';
                    $centerDoc->doc = Storage::disk('myDisk')->put('/centers', $equip);
                    $centerDoc->save();
                }
            }

            if ($request->has('wash_room')) {
                foreach ($request->wash_room as $wash) {
                    $centerDoc = new CenterDoc;
                    $centerDoc->tc_id = $center->id;
                    $centerDoc->room = 'wash';
                    $centerDoc->doc = Storage::disk('myDisk')->put('/centers', $wash);
                    $centerDoc->save();
                }
            }
            
            foreach ($request->jobrole as $key => $job) {
                $centerJobRole = new CenterJobRole;
                $centerJobRole->tp_id = Auth::guard('partner')->user()->id;
                $centerJobRole->tc_id = $center->id;
                $centerJobRole->tp_job_id = $job;
                $centerJobRole->target = $request->target[$key];
                $centerJobRole->save();

                $partnerJobRole = PartnerJobrole::find($job);
                $partnerJobRole->assigned = $partnerJobRole->assigned + $centerJobRole->target;
                $partnerJobRole->save();
            }


            /* Notification For Partner */
            $partner_name = Auth::guard('partner')->user()->spoc_name;
            $notification = new Notification;
            $notification->rel_id = 1;
            $notification->rel_with = 'admin';
            $notification->title = 'Training Center Added';
            $notification->message = "<span style='color:blue;'>".$partner_name."</span> Added New Training Center, TC Verification Required";
            $notification->save();
            /* End Notification For Partner */
            alert()->success("Training Center Data has Been Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(8000);

        });

        return redirect()->back();

    }

    public function candidates(){
        $partner = Auth::guard('partner')->user();
        $centers = Auth::guard('partner')->user()->centers;
        $candidates = collect();
        foreach ($centers as $center) {
            $candidates = $center->candidates;
        }
        $data = [
            'partner'  => $partner,
            'candidates' => $candidates,
        ];
        return view('common.candidates')->with($data);
    }

    public function view_candidate($id){

        $candidate = Candidate::findOrFail($id);
        if ($candidate->center->partner->id == Auth::guard('partner')->user()->id) {
            return $candidate;
        } else {
            return abort(404);
        }
        
        return view('common.view-candidate');
    }

}