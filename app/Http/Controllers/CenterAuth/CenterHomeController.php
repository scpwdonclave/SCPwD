<?php

namespace App\Http\Controllers\CenterAuth;

use Auth;
use Crypt;
use Throwable;
use App\Center;
use App\Reason;
use App\Candidate;
use App\Placement;
use Carbon\Carbon;
use App\Notification;
use App\OldCandidate;
use App\CenterJobRole;
use App\Helpers\AppHelper;
use App\CenterCandidateMap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function notifications()
    {
        $notifications = Notification::where([['rel_with','center'],['rel_id',$this->guard()->user()->id]])->get();
        return view('common.notifications')->with(compact('notifications'));
    }

    public function clearNotifications(Request $request)
    {   
        $request->validate([
            'dismiss'=>'required',
        ]);

        $notifications = Notification::where([['rel_with','center'],['rel_id',$this->guard()->user()->id],['read',0]])->get();

        foreach ($notifications as $notification) {
            $notification->read=1;
            $notification->read_by = $this->guard()->user()->spoc_name;
            $notification->save();
        }

        return response()->json(['success' => true],200);
    }

    public function clickNotification($id)
    {  
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $notification = Notification::findOrFail($id);
            if ($notification->rel_with === 'center' && $this->guard()->user()->id == $notification->rel_id) {
                if (!$notification->read) {
                    if (is_null($notification->url)) {
                        $route = redirect()->back();
                    } else {
                        $route = redirect($notification->url);
                    }
                    $notification->read_by = $this->guard()->user()->name;
                    $notification->read = 1;
                    $notification->save();
                    return $route;
                }
            }
        }
    }

    protected function dycryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function index() {

        $center = $this->guard()->user();
        $placed = 0;
        $dropped = 0;
        $registered = 0;
        $failed = 0;
        $passed = 0;
        $absent = 0;
        $assessment = 0;
        foreach ($center->candidatesmap as $centerCandidate) {
            if ($centerCandidate->placement) {
                $placed+=1;
            }

            if ($centerCandidate->dropout) {
                $dropped+=1;
            } elseif (is_null($centerCandidate->passed)) {
                $registered+=1;
            } elseif ($centerCandidate->passed == 0) {
                $failed+=1;
            } elseif ($centerCandidate->passed == 1) {
                $passed+=1;
            } else {
                $absent+=1;
            }

        }

        foreach ($center->batches as $batch) {
            if (Carbon::parse($batch->assessment) < Carbon::now()) {
                $assessment+=1;
            }
            if ($batch->reassessments) {
                foreach ($batch->reassessments as $reassessment) {
                    if (!is_null($reassessment->assessment) && Carbon::parse($reassessment->assessment) < Carbon::now()) {
                        $assessment+=1;
                    }
                }
            }
        }

        $data = [
            'center'=>$center,
            'placed'=>$placed,
            'dropped'=>$dropped,
            'registered'=>$registered,
            'failed'=>$failed,
            'absent'=>$absent,
            'passed'=>$passed,
            'assessment'=>$assessment,
        ];

        return view('center.home')->with($data);
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
                return view('common.view-candidate')->with(compact('center_candidate','state_dist'));
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
            $candidate->doc_type = $request->doc_type;
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
            if ($request->has('aadhaar_verify') && $request->aadhaar_verify === 'on') {
                $center_candidate->cd_verified = 1;
            }
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
            AppHelper::instance()->writeNotification($center->partner->id,'partner','New Candidate has Registered',"TC <span style='color:blue;'>".$center->tc_id."</span> has Registered a new Candidate.", route('partner.tc.candidate.view', Crypt::encrypt($center_candidate->id)));

        });
        alert()->success("Candidate has been <span style='font-weight:bold;color:blue'>Registered</span> Successfully", 'Job Done')->html()->autoclose(6000);
        return redirect()->back();
    }

    public function candidate_api(Request $request){
        if ($request->has('doc_no')) {

            /* Checking If There is Any Other Candidate Present with Same Document */

            $oldCandidate = OldCandidate::where('doc_no', $request->doc_no)->first();

            if ($oldCandidate) {
                // * Old Candidate Found with This Document
                $cert = Carbon::parse($oldCandidate->batch_end.' 23:59')->addYear(2); // * Adding 2 years to Batch End Date
                                        
                if ($cert > Carbon::now()) {
                    return response()->json(['success' => false, 'message' => 'Candidate with this Doc No has already Received a Valid Certificate from SCPwD', 'timer' => 6000], 200);
                }
            }

            $data = AppHelper::instance()->checkDoc($request->doc_no);
            if ($data['status']) {
                return response()->json(['success' => true, 'candidate' => null], 200);
            } else {
                if ($data['user'] == 'candidate') {
                    $candidate = Candidate::find($data['userid']);
                    if ($candidate->status) {
                        // * Candidate is Active

                        if (!$candidate->centerlatest->dropout) {
                            // * Candidate is Linked with a Center and Not Dropped Out
                        
                            if ($candidate->centerlatest->passed == '1') {
                                // * Candidate Passed An Assessment
                                
                                if (!is_null($candidate->centerlatest->certi_no)) {
                                    // * Candidate Have Received a Certificate

                                    // ? $value = explode(',', $candidate->centerlatest->assessment_certi_issued_on);
                                    
                                    $cert = Carbon::parse($candidate->centerlatest->batchcandidate->batch->batch_end)->addYear(2); // * Adding 2 years to Batch End Date
                                    
                                    if (Carbon::now() > $cert) {
                                        return response()->json(['success' => true,'candidate'=> $candidate], 200);
                                    } else {
                                        return response()->json(['success' => false, 'message' => 'Candidate with this Doc No has already Received a Valid Certificate from SCPwD', 'timer' => 6000], 200);
                                    }

                                }

                            } elseif ($candidate->centerlatest->passed == '2' || $candidate->centerlatest->passed == '0') {
                                
                                if ($candidate->centerlatest->reassessed=='0') {
                                    return response()->json(['success' => true,'candidate'=> $candidate], 200);
                                }

                            }
                            return response()->json(['success' => false, 'message' => 'Candidate with this Doc No is already Present'], 200);
                        
                        } else {
                            $dropout_limit = Carbon::parse($candidate->centerlatest->dropout_at)->addDays(2); // * Adding 2 days to Dropout Date
                            if (Carbon::now() < $dropout_limit) {
                                return response()->json(['success' => false, 'message' => 'Candidate with this Doc No is Locked out for 48 Hours from his/her last Dropout Session, Try again After That', 'timer' => 8000], 200);
                            }
                        }
                    
                    } else {
                        // * Candidate BlackListed

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


        } elseif ($request->has('jobid')) {
            $centerJob = CenterJobRole::find($request->jobid);
            if ($centerJob) {
                return response()->json(['success' => true, 'disabilities' => $centerJob->partnerjobrole->jobrole->expositories], 200);
            } else {
                return response()->json(['success' => false], 200);
            }
            
        } elseif ($request->has('job')) {

            $centerCandidate = CenterCandidateMap::where([['cd_id',$request->id],['tc_job_id',$request->job],['passed',1]])->first();
            if (!$centerCandidate) {            
                if ($request->aadhaar_flag === 'true') {
                
                    $stan = time();
                    $doc_no = $request->aadhaar;
                    $transmission_datetime = time().($this->guard()->user()->id);

                    return AppHelper::instance()->aadhaarVerify($stan, $doc_no, $transmission_datetime,'center', $this->guard()->user()->id, $this->guard()->user()->center_name, $request->gender, $request->dob);
                }
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'This Candidate already <span style="color:blue;font-weight:bold">Received</> a <span style="color:blue;font-weight:bold">Ceritificate</span> under this Job Role, Try Another Job Role'], 200);
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
                            AppHelper::instance()->writeNotification($centerCandidate->center->tp_id,'partner','Candidate Dropped Out',"Candidate (<span style='color:blue;'>$name</span>) is Dropped Out by TC <span style='color:red;'>$tcid</span>.", route('partner.tc.candidate.view', Crypt::encrypt($centerCandidate->id)));
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
            'first_payslip' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'second_payslip' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'third_payslip' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
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

        if ($request->has('first_payslip')) {
            $placement->payslip1 = Storage::disk('myDisk')->put('/placement', $request->first_payslip);
        }
        if ($request->has('second_payslip')) {
            $placement->payslip2 = Storage::disk('myDisk')->put('/placement', $request->second_payslip);
        }
        if ($request->has('third_payslip')) {
            $placement->payslip3 = Storage::disk('myDisk')->put('/placement', $request->third_payslip);
        }

        $placement->save();
        
        alert()->success("A New Placement Record has been <span style='color:blue;font-weight:bold'>Added</span>", 'Job Done')->html()->autoclose(4000);
        return redirect()->back();
    }

    public function updatePlacement(Request $request)
    {
        $request->validate([
            'pid'=> 'required',
            'payslip1' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'payslip2' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'payslip3' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ]);

        if (!$request->has('payslip1') && !$request->has('payslip2') && !$request->has('payslip3')) {
            alert()->info("Choose atleast one Salaryslip to <span style='color:blue;font-weight:bold'>Upload</span>", 'Attention')->html()->autoclose(4000);
            return redirect()->back(); 
        }

        if ($pid=AppHelper::instance()->decryptThis($request->pid)) {
            $placement = Placement::findOrFail($pid);
            if ($request->has('payslip1')) {
                if (is_null($placement->payslip1)) {
                    $placement->payslip1 = Storage::disk('myDisk')->put('/placement', $request->payslip1);
                }
            }
            if ($request->has('payslip2')) {
                if (is_null($placement->payslip2)) {
                    $placement->payslip2 = Storage::disk('myDisk')->put('/placement', $request->payslip2);
                }
            }
            if ($request->has('payslip3')) {
                if (is_null($placement->payslip3)) {
                    $placement->payslip3 = Storage::disk('myDisk')->put('/placement', $request->payslip3);
                }
            }

            $placement->save();

            $tcid = $this->guard()->user()->tc_id;
            $ccid = $placement->centercandidate->candidate->cd_id;
            AppHelper::instance()->writeNotification(NULL,'admin','TC Updated Salaryslip(s)',"TC (ID: <span style='color:blue;'>".$tcid."</span>) has uploaded new salarslip of a candidate (ID: <span style='color:blue;'>".$ccid."</span>).", route('admin.placement.view', Crypt::encrypt($placement->id)));

            alert()->success("Placement Salaryslip(s) Record has been <span style='color:blue;font-weight:bold'>Updated</span>", 'Job Done')->html()->autoclose(4000);
            return redirect()->back();
        }
    }
}
