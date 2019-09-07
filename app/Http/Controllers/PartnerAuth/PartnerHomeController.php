<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Requests\TPFormValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Partner;
use App\Notification;
use Alert;
use Auth;

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

    public function index() {
        return view('partner.home')->with('partner',Auth::guard('partner')->user());
    }
    
    /* View The Complete Registrattion Form */
    public function showCompleteRegistrationForm(){
        // $parliaments = DB::table('parliament')->get();
        // $states = DB::table('state_district')->get();
        $data = [
            'partner'  => Auth::guard('partner')->user(),
            'parliaments'   => DB::table('parliament')->get(),
            'states'   => DB::table('state_district')->get(),
        ];
        return (Auth::guard('partner')->user()->complete_profile) ? redirect(route('partner.dashboard.dashboard')) : view('partner.completeregistration')->with($data);
    }

    /* Submit Complete Registration Form Data */
    public function submitCompleteRegistrationForm(TPFormValidation $request){
        $initial_year = (Carbon::now()->format('m') <= 3)?(Carbon::now()->format('Y')-1):Carbon::now()->format('Y');

        $partner = Auth::guard('partner')->user();
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
        
        if ($request->addr_proof == 'Incorportaion Certificate') {
            /* Linking, Already Uploaded */
            $partner->addr_doc = $partner->incorp_doc;
        } else {
            $gstfilepath = Storage::disk('myDisk')->put('/partners', $request['addr_doc']);
            $partner->addr_doc = $gstfilepath;
        }
        
        
        $partner->city = $request->city;
        $partner->block = $request->block;
        $partner->pin = $request->pin;
        $partner->state_district = $request->state_district;
        $partner->parliament = $request->parliament;
        $partner->pan = $request->pan;
        $partner->pan_doc = Storage::disk('myDisk')->put('/partners', $request['pan_doc']);
        $partner->gst = $request->gst;
        
        if ($request->addr_proof == 'GST Registration Certificate') {
            $partner->gst_doc = $gstfilepath;
        } else {
            $partner->gst_doc = Storage::disk('myDisk')->put('/partners', $request['gst_doc']);
        }
        
        if ($request->hasFile('ca1_doc')) {
            $partner->ca1_doc = Storage::disk('myDisk')->put('/partners', $request['ca1_doc']);
            $partner->ca1_year = $initial_year.'-'.++$initial_year;
        }
        if ($request->hasFile('ca2_doc')) {
            $partner->ca2_doc = Storage::disk('myDisk')->put('/partners', $request['ca2_doc']);
            $partner->ca2_year = $initial_year.'-'.++$initial_year;
        }
        if ($request->hasFile('ca3_doc')) {
            $partner->ca3_doc = Storage::disk('myDisk')->put('/partners', $request['ca3_doc']);
            $partner->ca3_year = $initial_year.'-'.++$initial_year;
        }
        if ($request->hasFile('ca4_doc')) {
            $partner->ca4_doc = Storage::disk('myDisk')->put('/partners', $request['ca4_doc']);
            $partner->ca4_year = $initial_year.'-'.++$initial_year;
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
        
        /* For Admin */
        $notification = new Notification;
        $notification->rel_id = 1;
        $notification->rel_with = 'admin';
        $notification->title = 'New Registration';
        $notification->message = "<span style='color:blue;'>".$partner->spoc_name."</span> has Submitted Registration Form. Pending Trining Partner Account Verification";
        $notification->save();
        

        alert()->success("Your Application has been Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Reject</span> you will get Notified by your Email", 'Job Done')->html()->autoclose(8000);
        return redirect(route('partner.dashboard.dashboard'));
    }

    public function profile(){
        $partner = Auth::guard('partner')->user();
        return view('partner.profile')->with(compact('partner'));
    }

    public function profile_update(Request $request){


        if (Gate::allows('partner-update', Auth::shouldUse('partner'))) {

            $user = Auth::guard('partner')->user();
            if ($user->spoc_name == $request->spoc_name && $user->email == $request->email && $user->spoc_mobile == $request->spoc_mobile) {
                alert()->info("You Have not changed any value", 'Abort')->autoclose(3000);
                return redirect()->back();
            } else {
                $request->validate([
                    'spoc_name' => 'required',
                    'email' => 'required|email|unique:partners,email,'.Auth::guard('partner')->user()->id,
                    'spoc_mobile' => 'required|numeric',
                ]);
        
                DB::table('partner_update')->insert(
                    ['tp_id' => Auth::guard('partner')->user()->tp_id, 'spoc_name' => $request->spoc_name, 'email' => $request->email, 'spoc_mobile' => $request->spoc_mobile, 'created_at' => Carbon::now()]
                );

                /* For Admin */
                $notification = new Notification;
                $notification->rel_id = 1;
                $notification->rel_with = 'admin';
                $notification->title = 'Update Requested';
                $notification->message = "<span style='color:blue;'>".Auth::guard('partner')->user()->spoc_name."</span> has Submitted Registration Form. Pending Trining Partner Account Verification";
                $notification->save();

                alert()->success('Your Update request has been sent,<br> It will reflect as soon as Admin Verify it, You will get notified.','Request Received')->html()->autoclose('8000');
                return redirect()->back();
                // return 'Data Validated Need To Update The Profile with Given Data';
            }

        } else {
            return abort(403);
        }
    }

    public function centers(){
        return view('partner.centers')->with('partner',Auth::guard('partner')->user());
    }
}