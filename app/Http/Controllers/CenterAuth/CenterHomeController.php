<?php

namespace App\Http\Controllers\CenterAuth;

use DB;
use Auth;
use Crypt;
use App\Reason;
use App\Candidate;
use App\Placement;
use Carbon\Carbon;
use App\Notification;
use App\CenterJobRole;
use App\Helpers\AppHelper;
use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CDFormValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class CenterHomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('center');
    }

    protected function guard()
    {
        return Auth::guard('center');
    }

    protected function dycryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function index() {
        return view('center.home')->with('center',$this->guard()->user());
    }

    public function profile(){
        $center = $this->guard()->user();
        return view('common.profile')->with(compact('center'));
    }

    public function profile_update(Request $request){
        $request->validate([
            'password' => 'required',
        ]);

        if (Gate::allows('center-profile-active-verified', Auth::shouldUse('center'))) {
            $center = $this->guard()->user();
            $center->password = Hash::make($request->password);
            $center->save();

            alert()->success("Your <span style='font-weight:bold;color:blue'>Password</span> has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Awesome')->html()->autoclose(4000);
            return redirect()->back();
        }
    }

    public function jobroles(){
        $data = [
            'center' => $this->guard()->user(),
            'jobroles' => CenterJobRole::where('tc_id',$this->guard()->user()->id)->get()
        ];
        return view('common.jobroles')->with($data);
    }


    public function candidates(){
        $center = $this->guard()->user();

        // $candidates = collect([]);

        // foreach ($center->candidatesmap as $candidate) {

        //     dump($candidate);
        //     $candidates->push($candidate->candidate);
        // }


        // $center = Center::find($this->guard()->user->id);


        // $candidates = DB::table('candidates  as cd')->join('center_candidate_maps AS ccm', 'ccm.cd_id', '=', 'cd.id')
        //     ->orderBy('ccm.id', 'desc')            
        //     ->where('ccm.tc_id',$center->id)
        //     ->get()->unique('cd_id')->pluck('id')->toArray();

        $candidates = collect();

        foreach ($center->candidatesmap as $centerCandidate) {
            if ($centerCandidate->candidate->status) {
                $status = '<span style=\"color:green\">Active</span>';
            } else {
                $status = '<span style=\"color:red\">Deactive</span>';
            }

            $centerCandidate->candidate->candidate_status = $status;

            $candidates->push($centerCandidate->candidate);
        }

        // return $candidates;

        $data = [
            'center'  => $center,
            'candidates' => $candidates->unique(),
        ];

        return view('common.candidates')->with($data);
    }

    public function view_candidate($id){
        if ($id = $this->dycryptThis($id)) {
            // $center_candidate = CenterCandidateMap::where([['cd_id',$id],['tc_id', $this->guard()->user()->id]])->get()->last();
            // $state_dist = DB::table('state_district')->where('id',$center_candidate->state_district)->first();
            
            // return view('common.view-candidate')->with(compact('center_candidate','state_dist'));

            $center_candidate = CenterCandidateMap::findOrFail($id);
            $state_dist = DB::table('state_district')->where('id',$center_candidate->state_district)->first();
            if ($center_candidate->tc_id == $this->guard()->user()->id) {
                return view('common.view-candidate')->with(compact('center_candidate','state_dist','partner'));
            } else {
                return abort(401);
            }

        }
    }

    public function addcandidate(){
        $data = [
            'center'  => $this->guard()->user(),
            'states'   => DB::table('state_district')->get(),
        ];
        return view('center.addcandidate')->with($data);
    }

    public function submit_candidate(CDFormValidation $request){

        DB::transaction(function() use ($request){ 

            $candidate = Candidate::where('doc_no', $request->doc_no)->first();
            if (!$candidate) {
                $data=DB::table('candidates')
                ->select(\DB::raw('SUBSTRING(cd_id,3) as cd_id'))
                ->where("cd_id", "LIKE", "CD%")->get();
                $year =( date('m') > 3) ? date('y').(date('y') + 1) : (date('y')-1).date('y');

                if (count($data) > 0) {
                    $priceprod = array();
                        foreach ($data as $key=>$data) {
                            $priceprod[$key]=$data->cd_id;
                        }
                        $lastid= max($priceprod);
                    
                        $new_cdid = (substr($lastid, 0, 4)== $year) ? 'CD'.($lastid + 1) : 'CD'.$year.'000001' ;
                } else {
                    $new_cdid = 'CD'.$year.'000001';
                }
                $candidate = new Candidate;
                $candidate->cd_id = $new_cdid;
            }
               
            $candidate->name = $request->name;
            $candidate->gender = $request->gender;
            $candidate->contact = $request->contact;
            $candidate->email = $request->email; 
            
            $candidate->dob = $request->dob;
            $candidate->doc_no = $request->doc_no;
            $candidate->doc_file = Storage::disk('myDisk')->put('/candidates', $request['doc_file']);
            $candidate->category = $request->category;
            

            $candidate->save();

            $fmonth=date('F');
            $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');


            $center_candidate = new CenterCandidateMap;
            $center_candidate->tc_id = $this->guard()->user()->id;
            $center_candidate->tc_job_id = $request->job;
            $center_candidate->cd_id = $candidate->id;
            $center_candidate->d_type = $request->d_type;
            if ($request->hasFile('d_cert')) {
                $center_candidate->d_cert = Storage::disk('myDisk')->put('/candidates', $request['d_cert']);            
            }
            $center_candidate->m_status = $request->m_status;
            $center_candidate->service = $request->service;
            $center_candidate->education = $request->education;
            $center_candidate->g_name = $request->g_name;
            $center_candidate->g_type = $request->g_type;

            $center_candidate->f_month = $fmonth;
            $center_candidate->f_year = $fyear;



            $center_candidate->address = $request->address;
            $center_candidate->state_district = $request->state_district;

            $center_candidate->save();


            $centerjob = CenterJobRole::find($request->job);
            $centerjob->enrolled += 1;
            $centerjob->save();

            /* For Admin */
            $center = $this->guard()->user();
            AppHelper::instance()->writeNotification($center->partner->id,'partner','New Candidate has Registered',"TC <span style='color:blue;'>".$center->tc_id."</span> has Registered a new Candidate.");

        });
        alert()->success("Candidate has been <span style='font-weight:bold;color:blue'>Registered</span> Successfully", 'Job Done')->html()->autoclose(6000);
        return redirect()->back();
    }

    public function candidate_api(Request $request){
        if ($request->has('doc_no')) {
        /* Checking If There is Any Other Candidate Present with Same Document */

            $data = AppHelper::instance()->checkDoc($request->doc_no);
            if ($data['status']) {
                return response()->json(['success' => true, 'candidate' => null], 200);
            } else {
                if ($data['user'] == 'candidate') {
                    $candidate = Candidate::find($data['userid']);
                    if ($candidate->status) {
                        foreach ($candidate->centermap as $center) {
                            if (!$center->dropout) {
                                if (is_null($center->passed) || !$center->passed) {
                                    return response()->json(['success' => false, 'message' => 'Candidate with this Doc No is already Registered with SCPwD'], 200);
                                }
                            }
                        }
                    } else {
                        return response()->json(['success' => false, 'message' => 'Candidate with this Doc No is Blacklisted, Contact with SCPwD'], 200);
                    }                    
                    return response()->json(['success' => true,'candidate'=> $candidate], 200);
                } else {
                    return response()->json(['success' => false, 'message' => 'We have This Doc No Registered with Someone else'], 200);
                }
            }

        /* End Checking If There is Any Other Candidate Present with Same Document */    
        } elseif ($request->has('email')) {
            $emaildata = AppHelper::instance()->checkEmail($request->email);
            $contactdata = AppHelper::instance()->checkContact($request->contact);
            
            $array = [];
            if ($emaildata['status']) {
                $array['email'] = true;
            } else {
                if ($emaildata['user'] == 'candidate') {
                    if ($emaildata['docno'] == $request->doc_no) {
                        $array['email'] = true;
                    } else {
                        $array['email'] = false;
                    }
                } else {
                    $array['email'] = false;
                }
            }
            
            if ($contactdata['status']) {
                $array['mobile'] = true;
            } else {
                if ($contactdata['user'] == 'candidate') {
                    if ($contactdata['docno'] == $request->doc_no) {
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



            // if ($emaildata['status'] && $contactdata['status']) {
            //     // No Duplicate
            //     return response()->json(['success' => true], 200);
                
            // } elseif ($emaildata['status'] && !$contactdata['status']) {
            //     // Duplicate Contact
            //     return response()->json(['success' => false, 'message' => 'We have This Contact No Registered with Someone else'], 200);
                
            // } elseif (!$emaildata['status'] && $contactdata['status']) {
            //     // Duplicate Email    
            //     return response()->json(['success' => false, 'message' => 'We have This Email Registered with Someone else'], 200);
                
            // } elseif (!$emaildata['status'] || !$contactdata['status']) {
            //     // Duplicate Email & Contact    
            //     return response()->json(['success' => false, 'message' => 'We have This Email & Contact No Registered with Someone else'], 200);
           
            // }

        } elseif ($request->has('jobid')) {
            $centerJob = CenterJobRole::find($request->jobid);
            if ($centerJob) {
                return response()->json(['success' => true, 'disabilities' => $centerJob->partnerjobrole->jobrole->expositories], 200);
            } else {
                return response()->json(['success' => false], 200);
            }
            
        } elseif ($request->has('job')) {
            
            $centerCandidate = CenterCandidateMap::where([['cd_id',$request->id],['tc_job_id',$request->job],['passed',1]])->first();
            if ($centerCandidate) {
                return response()->json(['success' => false, 'message' => 'This Candidate already <span style="color:blue;font-weight:bold">Received</span> a <span style="color:blue;font-weight:bold">Ceritificate</span> under this Job Role, Try Another Job Role'], 200);                
            } else {
                return response()->json(['success' => true]);
            }
        }
    }


    public function dropout_candidate(Request $request)
    {
        if ($request->has('data')) {

            if ($id=AppHelper::instance()->decryptThis($request->data)) {
                $centerCandidate = CenterCandidateMap::find($id);
                if ($centerCandidate) {
                    if ($centerCandidate->candidate->status && !$centerCandidate->dropout) {
                        if (!is_null($request->reason) && $request->reason != '') {
                            $centerCandidate->dropout = 1;
                            $centerCandidate->dropout_at = Carbon::now();
                            $centerCandidate->save();
                            $reason = new Reason; 
                            $reason->rel_id = $centerCandidate->id;
                            $reason->rel_with = 'center';
                            $reason->reason = $request->reason;
                            $reason->save();
                            
                            $name = $centerCandidate->candidate->name;
                            $tcid = $centerCandidate->center->tc_id;
                            AppHelper::instance()->writeNotification($centerCandidate->center->tp_id,'partner','Candidate Dropped Out',"Candidate (<span style='color:blue;'>$name</span>) is Dropped Out by TC <span style='color:red;'>$tcid</span>.");
                            $array = array('type' => 'success', 'message' => "Candidate <span style='font-weight:bold;color:blue'>$name</span> is now <span style='font-weight:bold;color:red'>De-Linked</span> from your Training Center");
                        
                        } else {
                            $array = array('type' => 'error', 'message' => "Drop Out Reason can not be <span style='font-weight:bold;color:red'>NULL</span>");
                        }
                    } else {
                        $array = array('type' => 'error', 'message' => "Something went Wrong, Try Again 1");
                    }
                    return response()->json($array,200);
                } else {
                    return response()->json(array('type' => 'error', 'message' => "We Could not find this Candidate"),400);
                }

            } else {
                return response()->json(array('type' => 'error', 'message' => "Something went Wrong, Try Again"),400);
            }
        } 
    }

    public function candidateApi(Request $request)
    {
        if ($request->has('id')) {
            $centerCandidates = CenterCandidateMap::where([['cd_id','=', $request->id], ['tc_id','=', $this->guard()->user()->id]])->get();
            foreach ($centerCandidates as $centerCandidate) {

                $route = route('center.candidate.view',Crypt::encrypt($centerCandidate->id));
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

                $popup = Crypt::encrypt($centerCandidate->id).','.$centerCandidate->candidate->status.','.$centerCandidate->candidate->name;

                $centerCandidate->centerid = $centerCandidate->center->tc_id;
                $centerCandidate->partnerid = $centerCandidate->center->partner->tp_id;
                $centerCandidate->job = $centerCandidate->jobrole->partnerjobrole->jobrole->job_role;
                $centerCandidate->status = ($centerCandidate->dropout)?'<span style="color:blue">Dropped out</span>':$state;
                if ($centerCandidate->dropout) {
                    $centerCandidate->btn = "<button type='button' class='badge bg-green margin-0' onclick='location.href=\"$route\"'>View</button>";
                } else {
                    if ($centerCandidate->batchcandidate) {
                        if (Carbon::parse($centerCandidate->batchcandidate->batch->batch_end.' 23:59:00') < Carbon::now()) {
                            $centerCandidate->btn = "<button type='button' class='badge bg-green margin-0' onclick='location.href=\"$route\"'>View</button>";
                        } else {
                            $centerCandidate->btn = "<button type='button' class='badge bg-red margin-0' onclick='popup(\"$popup\")'>Dropout</button>&nbsp;&nbsp;&nbsp;<button type='button' class='badge bg-green margin-0' onclick='location.href=\"$route\"'>View</button>";
                        }
                    } else {
                        $centerCandidate->btn = "<button type='button' class='badge bg-red margin-0' onclick='popup(\"$popup\")'>Dropout</button>&nbsp;&nbsp;&nbsp;<button type='button' class='badge bg-green margin-0' onclick='location.href=\"$route\"'>View</button>";
                    }
                }
                
 
            }
            return response()->json(['success' => true, 'data' => $centerCandidates], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Something went Wrong, Try Again'], 400);
        }
    }


    public function placements()
    {
        $placements = Placement::where('tc_id', $this->guard()->user()->id)->get();
        return view('common.placements')->with(compact('placements'));
    }

    public function viewPlacement(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $placement = Placement::findOrFail($id);
            if ($placement->tc_id == $this->guard()->user()->id) {
                return view('common.view-placement')->with(compact('placement'));
            } else {
                return abort(403,'You are Not Authorized for this Action');
            }
        }
    }

    public function addPlacement()
    {
        $center_candidates = CenterCandidateMap::where([['tc_id',$this->guard()->user()->id],['passed',1]])->get();
        $states = DB::table('state_district')->get();

        return view('center.addplacement')->with(compact('center_candidates','states'));
    }

    public function submitPlacement(Request $request)
    {

        $request->validate([
            'candidate'=>'required|numeric',
            'org_name'=>'required',
            'employment_date'=>'required',
            'emp_type'=>'required',
            'org_address'=>'required',
            'state_district'=>'required|numeric',
            'spoc_name'=>'nullable',
            'spoc_mobile'=>'nullable',
            'spoc_email'=>'nullable',
            'offer_letter'=>'required|file',
            'appointment_letter'=>'nullable|file',
            'payslip'=>'nullable|array|min:3|max:3',
            'payslip.*' => 'distinct|file|mimes:jpeg,jpg,png,pdf'
        ]);

        $placement = new Placement;
        $placement->tp_id = $this->guard()->user()->tp_id;
        $placement->tc_id = $this->guard()->user()->id;
        $placement->ccd_id = $request->candidate;
        $placement->org_name = $request->org_name;
        $placement->employment_date = $request->employment_date;
        
        $placement->emp_type = $request->emp_type;
        $placement->org_address = $request->org_address;
        $placement->org_state_dist = $request->state_district;
        $placement->emp_spoc_name = $request->spoc_name;
        $placement->emp_spoc_mobile = $request->spoc_mobile;
        $placement->emp_spoc_email = $request->spoc_email;

        $placement->offer_letter = Storage::disk('myDisk')->put('/placement', $request->offer_letter);
        if ($request->has('appointment_letter')) {
            $placement->appointment_letter = Storage::disk('myDisk')->put('/placement', $request->appointment_letter);
        }

        if ($request->has('payslip')) {
            $placement->payslip1 = Storage::disk('myDisk')->put('/placement', $request->payslip[0]);
            $placement->payslip2 = Storage::disk('myDisk')->put('/placement', $request->payslip[1]);
            $placement->payslip3 = Storage::disk('myDisk')->put('/placement', $request->payslip[2]);
        }
        $placement->save();
        
        alert()->success("A New Placement Record has been <span style='color:blue;font-weight:bold'>Added</span>", 'Job Done')->html()->autoclose(4000);
        return redirect()->back();
    }
}
