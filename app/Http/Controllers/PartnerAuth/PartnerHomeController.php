<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Requests\TPFormValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\CenterJobRole;
use App\PartnerJobrole;
use App\Notification;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Partner;
use App\Holiday;
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
    public function __construct()
    {
        $this->middleware('partner');
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function index() {
        return view('partner.home')->with('partner',Auth::guard('partner')->user());
    }

    public function jobroles(){
        $data = [
            'partner' => Auth::guard('partner')->user(),
            'jobroles' => PartnerJobrole::where('tp_id',Auth::guard('partner')->user()->id)->get()
        ];
        return view('common.jobroles')->with($data);
    }

    public function viewjobrole($id){

        $partner_job = PartnerJobrole::where('tp_id',Auth::guard('partner')->user()->id)->findOrFail($id);
        $data = [
            'partner' => Auth::guard('partner')->user(),
            'schemesectorjobrole' => $partner_job->scheme->scheme.'/'.$partner_job->sector->sector.'/'.$partner_job->jobrole->job_role,
            'centers' => CenterJobRole::where('tp_job_id', $partner_job->id)->get()
        ];
        return view('partner.viewjobrole')->with($data);
    }


    
    /* View The Complete Registrattion Form */
    public function showCompleteRegistrationForm(){
        $data = [
            'partner'  => Auth::guard('partner')->user(),
            'parliaments'   => DB::table('parliament')->get(),
            'states'   => DB::table('state_district')->get(),
        ];
        return (Auth::guard('partner')->user()->complete_profile) ? redirect(route('partner.dashboard.dashboard')) : view('partner.completeregistration')->with($data);
    }

    /* Submit Complete Registration Form Data */
    public function submitCompleteRegistrationForm(TPFormValidation $request){

        // $this->authorize('partner-profile-verified', Auth::guard('partner')->user()); 

        if (!Auth::guard('partner')->user()->can('partner-profile-verified')) {
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
            
            /* For Admin */
            $notification = new Notification;
            $notification->rel_id = 1;
            $notification->rel_with = 'admin';
            $notification->title = 'New Registration';
            $notification->message = "<span style='color:blue;'>".$partner->spoc_name."</span> has Submitted Registration Form. Pending Trining Partner Account Verification";
            $notification->save();
            
    
            alert()->success("Your Application has been Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(8000);
            return redirect(route('partner.dashboard.dashboard'));

        } else {
            throw new \Illuminate\Auth\Access\AuthorizationException;
        }
        
        
    }

    public function profile(){
        $partner = Auth::guard('partner')->user();
        return view('common.profile')->with(compact('partner'));
    }

    public function profile_update(Request $request){

        if (Gate::allows('partner-profile-verified', Auth::shouldUse('partner'))) {

            $partner = Auth::guard('partner')->user();
            if ($partner->spoc_name == $request->spoc_name && $partner->email == $request->email && $partner->spoc_mobile == $request->spoc_mobile && is_null($request->password)) {
                alert()->info("You Have not changed any value", 'Abort')->autoclose(3000);
                return redirect()->back();
            } else {
                $request->validate([
                    'spoc_name' => 'required',
                    'email' => 'required|email|unique:partners,email,'.Auth::guard('partner')->user()->id,
                    'spoc_mobile' => 'required|numeric',
                    'password' => 'nullable',
                ]);
                if (!is_null($request->password)) {
                    $partner->password =  Hash::make($request->password);
                }
                $partner->spoc_name = $request->spoc_name;
                $partner->email = $request->email;
                $partner->spoc_mobile = $request->spoc_mobile;
                $partner->save();
                
                alert()->success("Your <span style='color:blue'>Profile</span> has been <span style='color:blue'>Updated</span>",'Awesome')->html()->autoclose('8000');
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

    public function test(){
        $hds = Holiday::all();
        $holidays = [];
        foreach ($hds as $hd) {
            array_push($holidays, Carbon::parse($hd->holiday_date)->toDateString());
        }
        $total_hours = 25; 
        /* End Custom Holiday List */

        // $cascades = CarbonInterval::getCascadeFactors(); // save initial factors

        // CarbonInterval::setCascadeFactors([
        //     'day' => [1.5, 'hours'],
        // ]);

        // $total_days = CarbonInterval::fromString($total_hours.'h')->cascade()->total('days');
        // CarbonInterval::setCascadeFactors($cascades);

        $total_days = ceil($total_hours/2);


        $start_date = Carbon::parse('07-11-2019');
        $end_date_approx = $start_date->copy()->addDays($total_days-1);
        
                    
        if ($start_date->isWeekend() || in_array($start_date->toDateString(), $holidays)) {
            return response()->json(['success' => false, 'message' => 'Start Date Cannot be on a Holiday'],200);                    
        }
        $end_date = $end_date_approx->copy();
        
        $date = $start_date->copy(); // 15-11-2019
        $count = 0;
        while ($count <= ($total_days-1)) {
            if ($date->isWeekend() || in_array($date->toDateString(), $holidays)) {
                while ($date->isWeekend() || in_array($date->toDateString(), $holidays)) {
                    // echo $date.'WEEK END<br>';
                    $date->addDay();
                }
            } else {
                echo $date.'<br>';
                $count ++;
                $date->addDay();
            }

        }
        
        $end_date = $date->subDay();





        // if ($end_date->isWeekend() || in_array($end_date->toDateString(), $holidays)) {
        //     $end_date->addDay();
        // }
        

        $assesment_dates = [];             

        for ($edate = $end_date->copy()->addDay(); sizeof($assesment_dates) < 5 ; $edate->addDay()) { 
            if ($edate->isWeekend() || in_array($edate->toDateString(), $holidays)) {
                
            } else {
                array_push($assesment_dates, Carbon::parse($edate->toDateString())->format('d-m-Y'));
            }
        }

        print_r($assesment_dates);
        echo '<br>';

        // $data = [
        //     'startdate' => Carbon::parse($start_date->toDateString())->format('d-m-Y'),
        //     'noofdays' => $total_days,
        //     'enddate' => Carbon::parse($end_date->toDateString())->format('d-m-Y')
        // ];


        return $total_days;














        
        $date = '13-10-2019';

        return Carbon::parse($date);



        $cascades = CarbonInterval::getCascadeFactors(); // save initial factors

        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
            'day' => [1.5, 'hours'],
            'week' => [7, 'days'],
            // in this example the cascade won't go farther than week unit
        ]);

        $hours = 12;

        echo CarbonInterval::fromString($hours.'h')->cascade()->total('days');   
        echo '<br>';
        

        $date = "2015-01-01 8:00 pm";
        $dt = Carbon::parse($date);

        return 'ho';



        // $holidays = ["2015-01-01", "2015-01-02"];

        // $date = "12/31/14";
        // $MyDateCarbon = Carbon::parse($date);

        // $MyDateCarbon->addWeekdays(3);

        // for ($i = 1; $i <= 3; $i++) {

        //     if (in_array(Carbon::parse($date)->addWeekdays($i)->toDateString(), $holidays)) {

        //         $MyDateCarbon->addDay();

        //     }
        // }

        // dd($MyDateCarbon);
    
        // $date = "2019-10-20";
        // $datework = new Carbon($date);
        // $now = Carbon::now();
        // $diff = $datework->diffInDays($now);
        // return $diff;



        $start_date = Carbon::parse('15-10-2019');
        // $start_date = $start_date_exact->copy()->addDay();
        $end_date_approx = $start_date->copy()->addDays(10);
        // $end_date = $start_date->copy()->add(25, 'days');
        // $end_date = Carbon::parse('30-09-2019');

        // return $end_date;

        // $dt2 = Carbon::create(2019, 10, 29);
        // $date = '31-10-2019';
        // echo $date.'<br>';
        // $new = Carbon::parse($date);
        // echo $new.'<br>';
        // return 'hi';
        $dates = [];
        $hds = Holiday::all();
        $holidays = [];
        foreach ($hds as $hd) {
            array_push($holidays, $hd->holiday_date);
        }
        $end_date = $end_date_approx->copy();
        for($date = $start_date->copy(); $date->lte($end_date_approx); $date->addDay()) {
            if ($date->isWeekend() || in_array($date->toDateString(), $holidays)) {
                echo $date->toDateString().'<br>';
                $end_date->addDay();
            }
        }
        return 'Start Date: '.$start_date->toDateString().'<br>Approx End Date: '.$end_date_approx->toDateString().'<br>End Date: '.$end_date->toDateString().'<br>';

        

        $daysForExtraCoding = $start_date->diffInDaysFiltered(function(Carbon $date) {
        $hds = Holiday::all();
        $holidays = [];
        foreach ($hds as $hd) {
            array_push($holidays, $hd->holiday_date);
        }    
            // echo $date->toDateString().'<br>';
            // if (in_array($date->toDateString(), $holidays)) {
            //     echo 'Present<br>';
                
            // } else {
                
            //     echo 'Not Present<br>';
            // }
    
            if ($date->isWeekend() || in_array($date->toDateString(), $holidays)) {
                echo $date->toDateString().' Holiday<br>';
                return false;
            } else {
                echo 'its Not<br>';
                return true;
            }
    
            
            // return !$date->isWeekend();
            // return false;
        }, $end_date_approx);

        return $daysForExtraCoding;
    

    
    }

}