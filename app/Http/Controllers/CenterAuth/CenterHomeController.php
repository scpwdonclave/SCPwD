<?php

namespace App\Http\Controllers\CenterAuth;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Requests\CandidateFormValidation;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\CenterJobRole;
use App\Notification;
use App\Candidate;
use Crypt;
use Auth;
use DB;

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

            alert()->success("Your <span style='font-weight:bold;color:blue'>Password</span> has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(4000);
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
        $data = [
            'center'  => $center,
            'candidates' => $center->candidates,
        ];
        return view('common.candidates')->with($data);
    }

    public function view_candidate($id){
        if ($id = $this->dycryptThis($id)) {
            $candidate = Candidate::where([['id',$id],['tc_id', $this->guard()->user()->id]])->firstOrFail();
            $state_dist = DB::table('state_district')->where('id',$candidate->state_district)->first();
            return view('common.view-candidate')->with(compact('candidate','state_dist'));
        }
    }

    public function addcandidate(){
        $data = [
            'center'  => $this->guard()->user(),
            'states'   => DB::table('state_district')->get(),
        ];
        return view('center.addcandidate')->with($data);
    }

    public function submit_candidate(CandidateFormValidation $request){

        DB::transaction(function() use ($request){ 
            $candidate = new Candidate;
            $candidate->tc_id = $this->guard()->user()->id;
            $candidate->tc_job_id = $request->job;
            $candidate->name = $request->name;
            $candidate->gender = $request->gender;
            $candidate->contact = $request->contact;
            $candidate->email = $request->email;
            $candidate->d_type = $request->d_type;
            if ($request->hasFile('d_cert')) {
                $candidate->d_cert = Storage::disk('myDisk')->put('/candidates', $request['d_cert']);            
            }
            $candidate->dob = $request->dob;
            $candidate->m_status = $request->m_status;
            $candidate->doc_no = $request->doc_no;
            $candidate->doc_file = Storage::disk('myDisk')->put('/candidates', $request['doc_file']);
            $candidate->category = $request->category;
            $candidate->service = $request->service;
            $candidate->education = $request->education;
            $candidate->g_name = $request->g_name;
            $candidate->g_type = $request->g_type;

            $candidate->address = $request->address;
            $candidate->state_district = $request->state_district;

            $candidate->save();

            $centerjob = CenterJobRole::find($request->job);
            $centerjob->enrolled += 1;
            $centerjob->save();

            /* For Admin */
            $center = $this->guard()->user(); 
            $notification = new Notification;
            $notification->rel_id = $center->partner->id;
            $notification->rel_with = 'partner';
            $notification->title = 'New Candidate Registration';
            $notification->message = "TC <span style='color:blue;'>".$center->tc_id."</span> has Registered a new Candidate.";
            $notification->save();
        });
        alert()->success("Candidate has been <span style='font-weight:bold;color:blue'>Registered</span> Successfully", 'Job Done')->html()->autoclose(6000);
        return redirect()->back();
    }

    public function candidate_api(Request $request){
        if ($request->has('doc_no')) {
        /* Checking If There is Any Other Candidate Present with Same Document */    
            $candidate = Candidate::where('doc_no', $request->doc_no)->first();
            if ($candidate) {
                return response()->json(['success' => false], 200);
            } else {
                return response()->json(['success' => true], 200);
            }
        /* End Checking If There is Any Other Candidate Present with Same Document */    
        } elseif ($request->has('checkredundancy')) {
            if (candidate::where($request->section,$request->checkredundancy)->first()) {
                return response()->json(['success' => false], 200);
            } else {
                return response()->json(['success' => true], 200);
            }
        } elseif ($request->has('jobid')) {
            $centerJob = CenterJobRole::find($request->jobid);
            if ($centerJob) {
                return response()->json(['success' => true, 'disabilities' => $centerJob->partnerjobrole->jobrole->expositories], 200);
            } else {
                return response()->json(['success' => false], 200);
            }
            
        }
    }
}
