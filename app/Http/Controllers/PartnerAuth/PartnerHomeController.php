<?php

namespace App\Http\Controllers\PartnerAuth;

use Auth;
use Alert;
use Crypt;
use App\Holiday;
use App\Partner;
use App\Placement;
use Carbon\Carbon;
use App\Notification;
use App\CenterJobRole;
use App\PartnerJobrole;
use App\Helpers\AppHelper;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TPFormValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class PartnerHomeController extends Controller
{

    protected $redirectTo = '/partner/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the Partner dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('partner');
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function notifications()
    {
        $notifications = Notification::where([['rel_with','partner'],['rel_id',$this->guard()->user()->id]])->get();
        $partner = $this->guard()->user();
        return view('common.notifications')->with(compact('notifications','partner'));
    }

    public function clearNotifications(Request $request)
    {   
        $request->validate([
            'dismiss'=>'required',
        ]);

        $notifications = Notification::where([['rel_with','partner'],['rel_id',$this->guard()->user()->id],['read',0]])->get();

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
            if ($notification->rel_with === 'partner' && $this->guard()->user()->id == $notification->rel_id) {
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

    public function index() {

        $partner = $this->guard()->user();
        $candidate=0;
        $placed = 0;
        $dropped = 0;
        $registered = 0;
        $failed = 0;
        $passed = 0;
        $absent = 0;
        $assessment = 0;

        foreach ($partner->centers as $center) {
            $candidate +=count($center->candidatesmap);

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

        }

        $data = [
            'partner' => $partner,
            'placed'=>$placed,
            'dropped'=>$dropped,
            'registered'=>$registered,
            'failed'=>$failed,
            'absent'=>$absent,
            'passed'=>$passed,
            'assessment'=>$assessment,
            'candidate' => $candidate,
        ];

        return view('partner.home')->with($data);
    }

    public function jobroles(){
        $data = [
            'partner' => $this->guard()->user(),
            'jobroles' => PartnerJobrole::where('tp_id',$this->guard()->user()->id)->get()
        ];
        return view('common.jobroles')->with($data);
    }

    public function viewjobrole($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $partner_job = PartnerJobrole::where('tp_id',$this->guard()->user()->id)->findOrFail($id);
            $data = [
                'partner' => $this->guard()->user(),
                'schemesectorjobrole' => $partner_job->scheme->scheme.'/'.$partner_job->sector->sector.'/'.$partner_job->jobrole->job_role,
                'centers' => CenterJobRole::where('tp_job_id', $partner_job->id)->get()
            ];
            
            return view('partner.viewjobrole')->with($data);
        }
    }


    
    /* View The Complete Registrattion Form */
    public function showCompleteRegistrationForm(){
        $data = [
            'partner'  => $this->guard()->user(),
            'parliaments'   => DB::table('parliament')->get(),
            'states'   => DB::table('state_district')->get(),
        ];
        return ($this->guard()->user()->complete_profile) ? redirect(route('partner.dashboard.dashboard')) : view('partner.completeregistration')->with($data);
    }

    /* Submit Complete Registration Form Data */
    public function submitCompleteRegistrationForm(TPFormValidation $request){

        // $this->authorize('partner-profile-verified', $this->guard()->user()); 

        if (!$this->guard()->user()->can('partner-profile-verified')) {
            $initial_year = (Carbon::now()->format('m') <= 3)?(Carbon::now()->format('Y')-1):Carbon::now()->format('Y');
            $partner = $this->guard()->user();
            $partner->org_name = $request->org_name;
            $partner->org_type = $request->org_type;
            $partner->estab_year = $request->estab_year;
            $partner->landline = $request->landline;
    
            $partner->website = $request->website;
            $partner->ceo_name = $request->ceo_name;
            $partner->ceo_email = $request->ceo_email;
            $partner->ceo_mobile = $request->ceo_mobile;
            $partner->signatory_name = $request->signatory_name;
            $partner->signatory_email = $request->signatory_email;
            $partner->signatory_mobile = $request->signatory_mobile;
            $partner->org_address = $request->org_address;
            $partner->landmark = $request->landmark;
            $partner->addr_proof = $request->addr_proof;
            
            $addr_doc = Storage::disk('myDisk')->put('/partners', $request['addr_doc']);
            $partner->addr_doc = $addr_doc;
            
            
            $partner->city = $request->city;
            $partner->block = $request->block;
            $partner->pin = $request->pin;
            $partner->state_district = $request->state_district;
            $partner->parliament = $request->parliament;
            $partner->pan = $request->pan;
            $partner->pan_doc = Storage::disk('myDisk')->put('/partners', $request['pan_doc']);
            $partner->gst = $request->gst;
            
            if ($request->addr_proof == 'GST Registration Certificate') {
                $partner->gst_doc = $addr_doc;
            } else {
                if ($request->hasFile('gst_doc')) {
                    $partner->gst_doc = Storage::disk('myDisk')->put('/partners', $request['gst_doc']);
                }
            }
            
            if ($request->hasFile('ca1_doc')) {
                $partner->ca1_doc = Storage::disk('myDisk')->put('/partners', $request['ca1_doc']);
                $partner->ca1_year = $initial_year.'-'.($initial_year+1);
            }
            if ($request->hasFile('ca2_doc')) {
                $partner->ca2_doc = Storage::disk('myDisk')->put('/partners', $request['ca2_doc']);
                $partner->ca2_year = ($initial_year-1).'-'.$initial_year;
            }
            if ($request->hasFile('ca3_doc')) {
                $partner->ca3_doc = Storage::disk('myDisk')->put('/partners', $request['ca3_doc']);
                $partner->ca3_year = ($initial_year-2).'-'.($initial_year-1);
            }
            if ($request->hasFile('ca4_doc')) {
                $partner->ca4_doc = Storage::disk('myDisk')->put('/partners', $request['ca4_doc']);
                $partner->ca4_year = ($initial_year-3).'-'.($initial_year-2);
            }
    
            $partner->offer = $request->offer;
            $partner->offer_date = $request->offer_date;
            $partner->offer_doc = Storage::disk('myDisk')->put('/partners', $request['offer_doc']);
            
            $partner->sanction = $request->sanction;
            $partner->sanction_date = $request->sanction_date;
            $partner->sanction_doc = Storage::disk('myDisk')->put('/partners', $request['sanction_doc']);
    
            /* Flag Section */
            $partner->complete_profile = 1;
            $partner->pending_verify = 1;
    
            $partner->save();
            
            AppHelper::instance()->writeNotification(NULL,'admin','New TP Registration',"<span style='color:blue;'>".$partner->spoc_name."</span> has Submitted a TP Registration Form. Pending Trining Partner Account Verification. Kindly <span style='color:blue;'>Approve</span> or <span style='color:red;'>Reject</span>", route('admin.tp.partner.view', Crypt::encrypt($partner->id)));
    
            alert()->success("Your Application has been Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(8000);
            return redirect(route('partner.dashboard.dashboard'));

        } else {
            throw new \Illuminate\Auth\Access\AuthorizationException;
        }
        
        
    }

    public function profile(){
        $partner = $this->guard()->user();
        return view('common.profile')->with(compact('partner'));
    }

    public function profile_update(Request $request){

        if (Gate::allows('partner-profile-verified', Auth::shouldUse('partner'))) {

            $partner = $this->guard()->user();
            if ($partner->spoc_name == $request->name && $partner->email == $request->email && $partner->spoc_mobile == $request->mobile && is_null($request->password)) {
                alert()->info("You Have not changed any value", 'Abort')->autoclose(3000);
                return redirect()->back();
            } else {
                $request->validate([
                    'name' => 'required', 
                    'password' => 'nullable',
                    'email' => [
                        'required',
                        'email',
                        'unique:admins,email',
                        'unique:partners,email,'.$this->guard()->user()->id,
                        'unique:centers,email',
                        'unique:trainer_statuses,email',
                        'unique:agencies,email',
                        'unique:assessors,email',
                        'unique:candidates,email',
                    ],
                    'mobile' => [
                        'required',
                        'numeric',
                        'min:10',
                        'unique:partners,spoc_mobile,'.$this->guard()->user()->id,
                        'unique:centers,mobile',
                        'unique:trainer_statuses,mobile',
                        'unique:agencies,mobile',
                        'unique:assessors,mobile',
                        'unique:candidates,contact',
                    ],
                ]);
                if (!is_null($request->password)) {
                    $partner->password =  Hash::make($request->password);
                }
                $partner->spoc_name = $request->name;
                $partner->email = $request->email;
                $partner->spoc_mobile = $request->mobile;
                $partner->save();
                
                alert()->success("Your <span style='color:blue'>Profile</span> has been <span style='color:blue'>Updated</span>",'Awesome')->html()->autoclose('4000');
                return redirect()->back();
            }

        } else {
            return abort(403);
        }
    }


    public function api_partner(Request $request){
        if ($request->has('checkredundancy')) {
            if (Partner::where($request->section,$request->checkredundancy)->first()) {
                return response()->json(['success' => false], 200);
            } else {
                return response()->json(['success' => true], 200);
            }
        }
    }


    public function placements()
    {
        $placements = Placement::where('tp_id', $this->guard()->user()->id)->get();
        $partner = $this->guard()->user();
        return view('common.placements')->with(compact('placements','partner'));
    }

    public function viewPlacement(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $placement = Placement::findOrFail($id);
            if ($placement->tp_id == $this->guard()->user()->id) {
                $partner = $this->guard()->user();
                return view('common.view-placement')->with(compact('placement','partner'));
            } else {
                return abort(403,'You are Not Authorized for this Action');
            }
        }
    }

}