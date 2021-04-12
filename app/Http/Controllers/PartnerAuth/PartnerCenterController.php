<?php

namespace App\Http\Controllers\PartnerAuth;

use DB;
use Auth;
use Crypt;
use App\Center;
use App\Candidate;
use App\CenterDoc;
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

    public function centers(){

        $partner = $this->guard()->user();
        return view('partner.centers.centers')->with(compact('partner'));
    }

    public function viewcenter($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $data = [
                'partner' => $this->guard()->user(),
                'centerData' => Center::findOrFail($id),
                'candidates' => CenterCandidateMap::where('tc_id',$id)->orderBy('id', 'desc')->get()->unique('cd_id'),
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


    public function centerTargetView($id)
    {
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $center = Center::findOrFail($id);
            $partner = $this->guard()->user();
            if ($center->partner->id == $partner->id) {
                $data = [
                    'partner' => $partner,
                    'center' => $center,
                ];            
                // return view('admin.partners.partner-target')->with($data);
                return view('common.target-page')->with($data);
            } else {
                return abort(403, 'You are not Authorized for this action');
            }
        }
    }

    public function fetchData(Request $request){
        if (is_null($request->data)) {      
            $partner = $this->guard()->user();
            $schemedata = collect(); $id = collect();
            foreach ($partner->partner_jobroles as $partnerJob) {
                $id->push($partnerJob->id.','.($partnerJob->target-$partnerJob->assigned));
                $schemedata->push($partner->schemedata = $partnerJob->scheme->scheme.'|'.$partnerJob->sector->sector.'|'.$partnerJob->jobrole->job_role);
            }   
            $data = [
                'id' => $id,
                'schemedata' => $schemedata,
                'max' => $schemedata,
            ];
        } else {
            $centerJob = CenterJobRole::findOrFail($request->data);
            $centerJob->partnerjobrole;
            $centerJob->jobdata = $centerJob->partnerjobrole->scheme->scheme.'|'.$centerJob->partnerjobrole->sector->sector.'|'.$centerJob->partnerjobrole->jobrole->job_role;
            // $center->jobid = 
            $data = [
                'data' => $centerJob,
            ];
        }
        return response()->json($data,200); 
    }


    
    // * Training Center JobRole Target Section
    
    public function centerTargetAction(Request $request)
    {
        // dd($request);
        if (is_null($request->jobid)) {
            
            $data = explode(',',$request->jobrole);
            $centerJob=CenterJobRole::where([['tp_id', $this->guard()->user()->id],['tc_id',$request->userid],['tp_job_id',$data[0]]])->first();
            if ($centerJob) {
                alert()->error("Jobrole with these details already <span style='font-weight:bold;color:blue'>Assigned</span> to This Training Center", 'Abort')->html()->autoclose(5000);
                return redirect()->back();
            } else {
                $centerjob = new CenterJobRole;
                $centerjob->tp_id=$this->guard()->user()->id;
                $centerjob->tc_id=$request->userid;
                $centerjob->tp_job_id=$data[0];
                $centerjob->target=$request->target;
                $centerjob->save();

                PartnerJobrole::find($data[0])->update(['assigned'=> ($centerjob->partnerjobrole->assigned+$request->target)]);
                
                AppHelper::instance()->writeNotification($request->userid,'center','New Job Target',"New Jobrole with Target has been <span style='color:blue;'>Assigned</span> to you.", route('center.dashboard.jobroles'));        
                alert()->success("New Job with Target has been <span style='font-weight:bold;color:blue'>Assigned</span> to This Training Center", 'Job Done')->html()->autoclose(4000);
                return redirect()->back(); 
            }
        } else {
            $centerJob=CenterJobRole::findOrFail($request->jobid);
            if ($centerJob && ($centerJob->tp_id==$this->guard()->user()->id)) {
                // $centerJob->enrolled <= $request->target && ($centerJob->partnerjobrole->target-($centerJob->partnerjobrole->assigned-$centerJob->target) >= $request->target)   This logic has been removed
                if((($centerJob->partnerjobrole->target-$centerJob->partnerjobrole->assigned) >= $request->target)){
                    $old_target = $centerJob->target;
                    $centerJob->target=$old_target+$request->target;
                    $centerJob->save();
    
                    // PartnerJobrole::find($centerJob->tp_job_id)->update(['assigned'=> (($centerJob->partnerjobrole->assigned-$old_target)+$request->target)]);
                    PartnerJobrole::find($centerJob->tp_job_id)->update(['assigned'=> ($centerJob->partnerjobrole->assigned+$request->target)]);
                    AppHelper::instance()->writeNotification($request->userid,'center','Jobrole Updated',"Your Jobrole has been <span style='color:blue;'>Updated</span> Kindly Check.", route('center.dashboard.jobroles'));        
                    alert()->success("Jobrole of This Training Center has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(4000);
                    return redirect()->back(); 
                } else {
                    return abort(403,'You are not Authorized for this action');
                }
                
            } else {
                alert()->error("Could not find the Record you have <span style='font-weight:bold;color:blue'>Requested</span>", 'Attention')->html()->autoclose(2000);
                return redirect()->back();
            }            
        }
    }

    // * End Training Center JobRole Target Section



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

            $partner_name = $this->guard()->user()->spoc_name;
            AppHelper::instance()->writeNotification(NULL,'admin','New Training Center Added',"<span style='color:blue;'>".$partner_name."</span> Added New Training Center, TC Verification Required. kindly <span style='color:blue;'>Approve</span> or <span style='color:red;'>Reject</span>", route('admin.tc.center.view', Crypt::encrypt($center->id)));

            alert()->success("Training Center Data has Been Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(8000);

        });

        return redirect()->back();

    }

    public function candidates(){
        $partner = $this->guard()->user();

        $candidates = collect();

        foreach ($partner->centers as $center) {
            foreach ($center->candidatesmap as $centerCandidate) {
                if ($centerCandidate->candidate->status) {
                    $status = '<span style=\"color:green\">Active</span>';
                } else {
                    $status = '<span style=\"color:red\">Deactive</span>';
                }
    
                $centerCandidate->candidate->candidate_status = $status;
    
                $candidates->push($centerCandidate->candidate);
            }
        }

        // return  $candidates->unique()->values();
        $data = [
            'partner'  => $partner,
            'candidates' => $candidates->unique()->values(),
        ];

        return view('common.candidates')->with($data);
    }

    public function view_candidate($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
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
            $center_candidates = CenterCandidateMap::where('cd_id', $request->id)->get();
            $flag = 0;
            $centerCandidates = collect();
            foreach ($center_candidates as $centerCandidate) {

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
                    $centerCandidate->job = $centerCandidate->jobrole->partnerjobrole->jobrole->job_role;
                    $centerCandidate->status = ($centerCandidate->dropout)?'<span style="color:blue">Dropped out</span>':$state;
                    $centerCandidate->btn = "<button type='button' class='badge bg-green margin-0' onclick='location.href=\"$route\"'>View</button>";
                    
                    $centerCandidates->push($centerCandidate);
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