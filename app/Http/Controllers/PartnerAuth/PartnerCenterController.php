<?php

namespace App\Http\Controllers\PartnerAuth;

use DB;
use Auth;
use Crypt;
use App\Center;
use App\Candidate;
use App\CenterDoc;
use App\Notification;
use App\CenterJobRole;
use App\PartnerJobrole;
use App\Helpers\AppHelper;
use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\TCFormValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

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

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function centers(){

        $partner = $this->guard()->user();
        $centers = Center::where('tp_id', $partner->id)->get();

        return view('partner.centers.centers')->with(compact('centers','partner'));
    }

    public function viewcenter($id){
        if ($id=$this->decryptThis($id)) {
            $data = [
                'partner' => $this->guard()->user(),
                'centerData' => Center::where('tp_id',$this->guard()->user()->id)->findOrFail($id),
                'tc_target' => CenterJobRole::where('tc_id',$id)->get(),
                'state_district' => DB::table('centers AS c')
                    ->join('state_district AS s','c.state_district','=','s.id')
                    ->join('parliament AS p','c.parliament','=','p.id')
                    ->where('c.id',$id)->first()
            ];
            return view('common.view-center')->with($data);
        }
    }

    public function updatecenter(Request $request){
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'value' => 'required',
        ]);
        $center = Center::find($request->id);
        if ($center->partner->id == $this->guard()->user()->id) {
            $field = $request->name;
            switch ($request->name) {
                case 'name':
                    $center->spoc_name = $request->value;
                    break;
                case 'email':
                    $emaildata = AppHelper::instance()->checkEmail($request->value);
                    if (!$emaildata['status']) {
                        if ($emaildata['user'] == 'center') {
                            if ($emaildata['userid']!=$request->id) {
                                return response()->json(array('type' => 'error','title' => 'Attention', 'message' => "This <span style='font-weight:bold;color:red'>Email</span> has Already been <span style='font-weight:bold;color:red'>Taken</span>"),200);
                            }
                        } else {
                            return response()->json(array('type' => 'error','title' => 'Attention', 'message' => "This <span style='font-weight:bold;color:red'>Email</span> has Already been <span style='font-weight:bold;color:red'>Taken</span>"),200);
                        }
                    }
                    
                    $center->email = $request->value;
                break;
                case 'mobile':
                    $mobiledata = AppHelper::instance()->checkContact($request->value);
                    if (!$mobiledata['status']) {
                            if ($mobiledata['user'] == 'center') {
                                if ($mobiledata['userid']!=$request->id) {
                                    return response()->json(array('type' => 'error','title' => 'Attention', 'message' => "This <span style='font-weight:bold;color:red'>Mobile No</span> has Already been <span style='font-weight:bold;color:red'>Taken</span>"),200);
                                }
                            } else {
                                return response()->json(array('type' => 'error','title' => 'Attention', 'message' => "This <span style='font-weight:bold;color:red'>Mobile No</span> has Already been <span style='font-weight:bold;color:red'>Taken</span>"),200);
                            }
                        }
                        
                        $center->mobile = $request->value;
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
                'partner'  => $this->guard()->user(),
                'parliaments'   => DB::table('parliament')->get(),
                'states'   => DB::table('state_district')->get(),
                // 'centers'   => Center::where('tp_id', $this->guard()->user()->id)->get()
            ];
            return view('partner.centers.addcenter')->with($data);
        } else {   
            return redirect(route('partner.tc.centers'));
        }
    }

    public function addcenter_api(Request $request){
        if ($request->has('mobile') && $request->has('email')) {

            $dataEmail = AppHelper::instance()->checkEmail($request->email);
            $dataMob = AppHelper::instance()->checkContact($request->mobile);
            $array = [];

            $array['email'] = ($dataEmail['status'])? true : false;
            $array['mobile'] = ($dataMob['status'])? true : false;
            
            if ($array['mobile'] && $array['email']) {
                return response()->json(['success' => true], 200);
            } elseif ($array['mobile'] && !$array['email']) {
                return response()->json(['success' => false, 'message' => 'This Email ID is Registered with Someone Else'], 200);
            } elseif (!$array['mobile'] && $array['email']) {
                return response()->json(['success' => false, 'message' => 'This Mobile No is Registered with Someone Else'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'This Email ID & Mobile No is Registered with Someone Else'], 200);
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
            //    // dd($new_TCid);
            // } else {
            //     $new_tcid = 'TC'.$year.'000001';
            // }
        

            $center = new Center;
            $center->tp_id = $this->guard()->user()->id;
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
                $centerJobRole->tp_id = $this->guard()->user()->id;
                $centerJobRole->tc_id = $center->id;
                $centerJobRole->tp_job_id = $job;
                $centerJobRole->target = $request->target[$key];
                $centerJobRole->save();

                $partnerJobRole = PartnerJobrole::find($job);
                $partnerJobRole->assigned = $partnerJobRole->assigned + $centerJobRole->target;
                $partnerJobRole->save();
            }


            /* Notification For Partner */
            $partner_name = $this->guard()->user()->spoc_name;
            $notification = new Notification;
            //$notification->rel_id = 1;
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
        $partner = $this->guard()->user();
        // $centers = $this->guard()->user()->centers;
        // // $candidates = collect();
        // $list = []; // * list[] is centercandiadtemap id's array;
        // foreach ($centers as $center) {
        //     $center_candidates = DB::table('candidates  as cd')->join('center_candidate_maps AS ccm', 'ccm.cd_id', '=', 'cd.id')
        //         ->orderBy('ccm.id', 'desc')
        //         ->where('ccm.tc_id',$center->id)
        //         ->get()->unique('cd_id')->pluck('id')->toArray();
        //     $list = array_unique (array_merge ($list, $center_candidates));
        //     }


        // $data = [
        //     'partner'  => $partner,
        //     'candidates' => CenterCandidateMap::whereIn('id', $list)->get(),
        // ];
        // return view('common.candidates')->with($data);


        $candidates = collect();

        foreach ($partner->centers as $center) {
            foreach ($center->candidatesmap as $centerCandidate) {
                $candidates->push($centerCandidate->candidate);
            }
        }


        // return $candidates;

        $data = [
            'partner'  => $partner,
            // 'candidates' => CenterCandidateMap::whereIn('id', $candidates)->get(),
            'candidates' => $candidates,
        ];
        return view('common.candidates')->with($data);


    }

    public function view_candidate($id){
        if ($id=$this->decryptThis($id)) {
            // $candidate = Candidate::findOrFail($id);
            // if ($candidate->centerlatest->center->partner->id == $this->guard()->user()->id) {
            //     $partner = $this->guard()->user();
            //     $state_dist = DB::table('state_district')->where('id',$candidate->centerlatest->state_district)->first();
            //     $center_candidate = $candidate->centerlatest;
            //     return view('common.view-candidate')->with(compact('center_candidate','state_dist','partner'));
            // } else {
            //     return abort(404);
            // }

            // $center_candidate = CenterCandidateMap::where([['cd_id',$id],['tc_id', $this->guard()->user()->center->id]])->get()->last();
            // $state_dist = DB::table('state_district')->where('id',$center_candidate->state_district)->first();
            
            // return view('common.view-candidate')->with(compact('center_candidate','state_dist'));


            $partner = $this->guard()->user();
            $center_candidate = CenterCandidateMap::findOrFail($id);
            $state_dist = DB::table('state_district')->where('id',$center_candidate->state_district)->first();
            if ($center_candidate->center->tp_id == $this->guard()->user()->id) {
                return view('common.view-candidate')->with(compact('center_candidate','state_dist','partner'));
            } else {
                return abort(401);
            }
        }
    }

    public function candidateApi(Request $request)
    {
        if ($request->has('id')) {
            $centerCandidates = CenterCandidateMap::where('cd_id', $request->id)->get();
            $flag = 0;
            foreach ($centerCandidates as $centerCandidate) {

                if ($centerCandidate->center->tp_id == $this->guard()->user()->id) {
                    $flag = 1;
                    $route = route('partner.tc.candidate.view',Crypt::encrypt($centerCandidate->id));
                    switch ($centerCandidate->passed) {
                        case '0':
                            $state = '<span style="color:red">Failed</span>';
                            break;
                        case '1':
                            $state = '<span style="color:green">Passed</span>';
                            break;
                        case '2':
                            $state = '<span style="color:blue">Absent</span>';
                            break;                    
                        default:
                            $state = 'Not Applicable';
                        break;
                    }
    
                    $centerCandidate->centerid = $centerCandidate->center->tc_id;
                    $centerCandidate->partnerid = $centerCandidate->center->partner->tp_id;
                    $centerCandidate->status = ($centerCandidate->dropout)?'<span style="color:blue">Dropped out</span>':$state;
                    $centerCandidate->btn = "<button type='button' class='badge bg-green margin-0' onclick='location.href=\"$route\"'>View</button>";
                }
 
            }
            if ($flag) {
                return response()->json(['success' => true, 'data' => $centerCandidates], 200);
            } else {
                return response()->json(['success' => true, 'data' => collect()], 200);
            }

        } else {
            return response()->json(['success' => false, 'message' => 'Something went Wrong, Try Again'], 400);
        }
    }
}