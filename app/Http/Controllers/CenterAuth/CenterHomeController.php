<?php

namespace App\Http\Controllers\CenterAuth;

use DB;
use Auth;
use Crypt;
use App\Candidate;
use App\Notification;
use App\CenterJobRole;
use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CandidateFormValidation;
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

    protected function writeNotification($relid,$relwith,$title,$msg){
        $notification = new Notification;
        $notification->rel_id = $relid;
        $notification->rel_with = $relwith;
        $notification->title = $title;
        $notification->message = $msg;
        $notification->save();
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

        // $candidates = collect([]);

        // foreach ($center->candidatesmap as $candidate) {

        //     dump($candidate);
        //     $candidates->push($candidate->candidate);
        // }



        $candidates = DB::table('candidates  as cd')->join('center_candidate_maps AS ccm', 'ccm.cd_id', '=', 'cd.id')
            ->orderBy('ccm.id', 'desc')            
            ->where('ccm.tc_id',$center->id)
            ->get()->unique('cd_id')->pluck('id')->toArray();
        $data = [
            'center'  => $center,
            'candidates' => CenterCandidateMap::whereIn('id', $candidates)->get(),
        ];
        return view('common.candidates')->with($data);
    }

    public function view_candidate($id){
        if ($id = $this->dycryptThis($id)) {
            $center_candidate = CenterCandidateMap::where([['cd_id',$id],['tc_id', $this->guard()->user()->id]])->get()->last();
            $state_dist = DB::table('state_district')->where('id',$center_candidate->state_district)->first();
            
            return view('common.view-candidate')->with(compact('center_candidate','state_dist'));
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
            $this->writeNotification($center->partner->id,'partner','New Candidate has Registered',"TC <span style='color:blue;'>".$center->tc_id."</span> has Registered a new Candidate.");

        });
        alert()->success("Candidate has been <span style='font-weight:bold;color:blue'>Registered</span> Successfully", 'Job Done')->html()->autoclose(6000);
        return redirect()->back();
    }

    public function candidate_api(Request $request){
        if ($request->has('doc_no')) {
        /* Checking If There is Any Other Candidate Present with Same Document */    
            $candidate = Candidate::where('doc_no', $request->doc_no)->first();
            if ($candidate) {

                foreach ($candidate->centermap as $center) {
                    if (is_null($center->passed) || !$center->passed) {
                        return response()->json(['success' => false], 200);
                    }
                }

                return response()->json(['success' => true,'candidate'=> $center->candidate], 200);
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
