<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Mail;
use Crypt;
use App\Center;
use App\Reason;
use App\Batch;
use App\Scheme;
use App\Sector;
use App\Partner;
use App\TrainerStatus;
use Carbon\Carbon;
use App\Mail\TPMail;
use App\CenterJobRole;
use App\PartnerJobrole;
use App\Helpers\AppHelper;
use App\Events\TCMailEvent;
use App\Events\TPMailEvent;
use Illuminate\Http\Request;
use App\PartnerJobRoleReason;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminPartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }


    public function partners(){
        $data=Partner::where('pending_verify',0)->get();
        return view('admin.partners.partners')->with(compact('data'));
    }

    public function pendingPartners(){
        $data=Partner::where('pending_verify','=',1)
        ->orWhere('pending_verify','=',null)
        ->get();

        return view('admin.partners.pending-partners')->with(compact('data'));
    }



    // * Training Partner Activation Deactvation
    
    public function partnerStatusAction(Request $request){
        if ($request->has('data')) {

            if ($id=$this->decryptThis($request->data)) {
                $data = explode(',',$id);
                $partner = Partner::find($data[0]);

                if ($partner) {
                    $dataMail = collect();

                    if ($partner->status) {
                        if (!is_null($request->reason) && $request->reason != '') {
                            if ($request->blacklist) {
                                foreach ($partner->centers as $center) {
                                    foreach ($center->candidatesmap as $centercandidate) {
                                        if (!$centercandidate->dropout) {
                                            $centercandidate->dropout = 1;
                                            $centercandidate->save();
                                        }
                                    }
                                }

                                foreach ($partner->trainers as $trainer) {
                                    
                                    foreach ($trainer->batches as $batch) {
                                        if (Carbon::parse($batch->batch_end.' 23:59')>Carbon::now()) {
                                            $batch->active = 0;
                                            $batch->save();
                                        }
                                    }
                                    $trainerStatus=TrainerStatus::where('prv_id',$trainer->id)->orderBy('created_at', 'desc')->first();
                                    if ($trainerStatus) {
                                        $trainerStatus->attached=0;        
                                        $trainerStatus->dlink_reason='TP Blacklisted';
                                        $trainerStatus->save();
                                    }
                                    $trainer->delete();

                                }



                            }
                            
                            $partner->status = 0;
                            $partner->save();
                            $reason = new Reason;
                            $reason->rel_id = $data[0];
                            $reason->rel_with = 'partner';
                            $reason->reason = $request->reason;
                            $reason->save();

                            $dataMail->reason = $request->reason;
                            $dataMail->tag = 'tpdeactive';
                            
                            $array = array('type' => 'success', 'message' => "Training Partner Account is <span style='font-weight:bold;color:red'>Deactivated</span> now");
                        } else {
                            $array = array('type' => 'error', 'message' => "Deactivation Reason can not be <span style='font-weight:bold;color:red'>NULL</span>");
                        }
                    } else {
                        $partner->status = 1;
                        $partner->save();
                        $dataMail->tp_id = $partner->tp_id;
                        $dataMail->tag = 'tpactive';
                        
                        $array = array('type' => 'success', 'message' => "Training Partner Account is <span style='font-weight:bold;color:blue'>Activated</span> now");
                    }

                    // * Mail Events
                    if ($array['type'] == 'success') {
                        $dataMail->spoc_name = $partner->spoc_name;
                        $dataMail->email = $partner->email;
                        event(new TPMailEvent($dataMail));
                        foreach ($partner->centers as $center) {
                            if ($center->status) {
                                $dataMail->spoc_name = $center->spoc_name;
                                $dataMail->email = $center->email;
                                event(new TCMailEvent($dataMail));
                            }
                        }
                    }
                    // * End Mail Events

                    return response()->json($array,200);
                } else {
                    return response()->json(array('type' => 'error', 'message' => "We Could not find this Training Partner Account"),400);
                }

            } else {
                return response()->json(array('type' => 'error', 'message' => "Requested Account is not Found"),400);
            }
        }        
    }

    // * End Training Partner Activation Deactvation

    // * Training Partner View with ID
    
    public function partnerView($id){
        if ($id=$this->decryptThis($id)) {
            $partnerData=Partner::findOrFail($id); 
            $partnerState=DB::table('partners')
            ->join('state_district','partners.state_district','=','state_district.id')
            ->join('parliament','partners.parliament','=','parliament.id')
            ->first();

            $partner_scheme=PartnerJobrole::where('tp_id',$id)
            ->groupBy('scheme_id')->get();
    
            if ($partnerData->complete_profile) {
                return view('admin.partners.view-partner')->with(compact('partnerData','partnerState','partner_scheme'));
            } else {
                return redirect()->route('admin.tp.partners');
            }
        }   
    }
    
    // * End Training Partner View with ID

    public function partnerUpdate($id){
        try {
            $partner_id = Crypt::decrypt($id);
           
        } catch (DecryptException $e) {
            abort(404);
        }
        $partner=Partner::findOrFail($partner_id);
        $states=DB::table('state_district')->get();
        $parliaments=DB::table('parliament')->get();
        
        return view('admin.partners.partner-update')->with(compact('partner','states','parliaments'));
    }



    // * Training Partner Accept Reject
    
    public function partnerAction(Request $request){
        if ($req=$this->decryptThis($request->id)) {
            $data = explode(',',$req);
            $partner = Partner::findOrFail($data[0]);
            if ($partner->pending_verify) {
                $dataMail = collect();
                if ($data[1]) {
                    $data=DB::table('partners')->select(DB::raw('SUBSTRING(tp_id,3) as tp_id'))->where("tp_id", "LIKE", "TP%")->get();
                    $year =( date('m') > 3) ? date('y').(date('y') + 1) : (date('y')-1).date('y');
                    
                    if (count($data) > 0) {
                        $array = array();
                        foreach ($data as $key=>$data) {
                            $array[$key]=$data->tp_id;
                        }
                        $lastid= max($array);
                        $new_tpid = (substr($lastid, 0, 4)== $year) ? 'TP'.($lastid + 1) : 'TP'.$year.'000001' ;
                    } else {
                        $new_tpid = 'TP'.$year.'000001';
                    }

                    $fmonth=date('F');
                    $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');

                    $partner->tp_id=$new_tpid;
                    $partner->f_month=$fmonth;
                    $partner->f_year=$fyear;
                    $partner->pending_verify=0;
                    $partner->save();
                    AppHelper::instance()->writeNotification($partner->id,'partner','Account Activated',"Your Profile has been <span style='color:blue;'>Approved</span>.", NULL);
                    $dataMail->tag = 'tpaccept';
                    $dataMail->tp_id = $new_tpid;
                    alert()->success("Training Partner Account has been <span style='color:blue;font-weight:bold;'>Approved</span>", "Job Done")->html()->autoclose(4000);

                } else {
                    DB::transaction(function() use ($request, $partner){

                        DB::table('rejected_partners')->insert(
                        
                            ['spoc_name' => $partner->spoc_name	,
                            'spoc_mobile' => $partner->spoc_mobile,	
                            'email' => $partner->email,	 
                            'incorp_doc'=> $partner->incorp_doc,	
                            'org_name'=> $partner->org_name,	
                            'org_type'=> $partner->org_type,	
                            'estab_year'=> $partner->estab_year,	
                            'landline'=> $partner->landline,	
                            'website'=> $partner->website,	
                            'ceo_name'=> $partner->ceo_name,	
                            'ceo_email'=> $partner->ceo_email,	
                            'ceo_mobile'=> $partner->ceo_mobile,	
                            'signatory_name'=> $partner->signatory_name,	
                            'signatory_email'=> $partner->signatory_email,	
                            'signatory_mobile'=> $partner->signatory_mobile,	
                            'org_address'=> $partner->org_address,	
                            'landmark'=> $partner->landmark,	
                            'addr_proof'=> $partner->addr_proof,	
                            'addr_doc'=> $partner->addr_doc,	
                            'city'=> $partner->city,	
                            'block'=> $partner->block,	
                            'pin'=> $partner->pin,	
                            'state_district'=> $partner->state_district,	
                            'parliament'=> $partner->parliament,	
                            'pan'=> $partner->pan,	
                            'pan_doc'=> $partner->pan_doc,	
                            'gst'=> $partner->gst,	
                            'gst_doc'=> $partner->gst_doc,	
                            'ca1_doc'=> $partner->ca1_doc,	
                            'ca1_year'=> $partner->ca1_year,	
                            'ca2_doc'=> $partner->ca2_doc,	
                            'ca2_year'=> $partner->ca2_year,	
                            'ca3_doc'=> $partner->ca3_doc,	
                            'ca3_year'=> $partner->ca3_year,	
                            'ca4_doc'=> $partner->ca4_doc,	
                            'ca4_year'=> $partner->ca4_year,	
                            'offer'=> $partner->offer,	
                            'offer_date'=> $partner->offer_date,	
                            'offer_doc'=> $partner->offer_doc,	
                            'sanction'=> $partner->sanction,	
                            'sanction_date'=> $partner->sanction_date,	
                            'sanction_doc'=> $partner->sanction_doc,	
                            'reason'=> $request->reason,
                            'remember_token'=> 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                            ]
                        );
                    });
                    $dataMail->tag = 'tpreject';
                    $dataMail->reason = $request->reason;                      
                    alert()->success("Training Partner Account has been <span style='color:red;font-weight:bold'>Rejected</span>", "Job Done")->html()->autoclose(4000);
                }
                
                $dataMail->spoc_name = $partner->spoc_name;
                $dataMail->email = $partner->email;
                event(new TPMailEvent($dataMail));
                $partner->delete();
                
                return redirect(route('admin.tp.partners'));
            } else {
                alert()->error("Training Partner Account already been <span style='color:blue;font-weight:bold'>Approved</span>", "Done")->html()->autoclose(3000);
                return redirect(route('admin.tp.partners'));
            }   
        }
    }

    // * End Training Partner Accept Reject
    
    public function partnerDetailsUpdate(Request $request){
      
        $initial_year = (Carbon::now()->format('m') <= 3)?(Carbon::now()->format('Y')-1):Carbon::now()->format('Y');
        $partner=Partner::findOrFail($request->id);
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

        if($request->hasFile('addr_doc')){
            $addr_doc = Storage::disk('myDisk')->put('/partners', $request['addr_doc']);
            $partner->addr_doc = $addr_doc;
        }
            $partner->city = $request->city;
            $partner->block = $request->block;
            $partner->pin = $request->pin;
            $partner->state_district = $request->state_district;
            $partner->parliament = $request->parliament;
            $partner->pan = $request->pan;
            if($request->hasFile('pan_doc')){
                $partner->pan_doc = Storage::disk('myDisk')->put('/partners', $request['pan_doc']);
            }
            $partner->gst = $request->gst;

            if ($request->addr_proof == 'GST Registration Certificate') {
                if($request->hasFile('addr_doc')){
                $partner->gst_doc = $addr_doc;
                }
            } else {
                if($request->hasFile('gst_doc')){
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
            if ($request->hasFile('offer_doc')) {
                $partner->offer_doc = Storage::disk('myDisk')->put('/partners', $request['offer_doc']);
            }

            $partner->sanction = $request->sanction;
            $partner->sanction_date = $request->sanction_date;
            if ($request->hasFile('sanction_doc')) {
                $partner->sanction_doc = Storage::disk('myDisk')->put('/partners', $request['sanction_doc']);
            }
            $partner->save();

            AppHelper::instance()->writeNotification($partner->id,'partner','Account Updated',"Your Profile has been <span style='color:blue;'>Updated</span>.", NULL);

            alert()->success("Training Partner profile has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(2000);
            return redirect()->back();


    }



    // * View Partner Target Page
    
    public function partnerTargetView($id){        
        if ($id=$this->decryptThis($id)) {
            $data = [
                'partner' => Partner::findOrFail($id),
                'sectors' => Sector::all(),
                'schemes' => Scheme::all(),
            ];            
            return view('admin.partners.partner-target')->with($data);
        }
    }
    
    // * End View Partner Target Page

    
    // * TP Fetch Target Data API
    
    public function fetchJobrole(Request $request){
        $jobroles=DB::table('job_roles')->where('sector_id','=',$request->sector)->get(); 
        return response()->json(['jobroles' => $jobroles],200); 
    }

    public function fetchData(Request $request){
        if (is_null($request->data)) {            
            $data = [
                'job' => DB::table('job_roles')->where('sector_id',1)->get(),
                'sectors' => Sector::all(),
                'schemes' => Scheme::all(),
            ];
        } else {
            $val = PartnerJobrole::findOrFail($request->data);
            $data = [
                'data' => $val,
                'job' => DB::table('job_roles')->where('sector_id',$val->sector_id)->get(),
                'sectors' => Sector::all(),
                'schemes' => Scheme::all(),
            ];
        }
        return response()->json($data,200); 
    }
    
    // * End TP Fetch Target Data API


    // * Training Partner JobRole Target Section
    
    public function partnerTargetAction(Request $request)
    {
        if (is_null($request->jobid)) {
            $partnerJob=PartnerJobrole::where([['tp_id','=',$request->userid],['scheme_id','=',$request->scheme],['sector_id','=',$request->sector],['jobrole_id','=',$request->jobrole]])->first();
            if ($partnerJob) {
                alert()->error("Jobrole with these details already <span style='font-weight:bold;color:blue'>Assigned</span> to This Training Partner", 'Abort')->html()->autoclose(5000);
                return redirect()->back();
            } else {
                $partnerjob = new PartnerJobrole;
                $partnerjob->tp_id=$request->userid;
                $partnerjob->scheme_id=$request->scheme;
                $partnerjob->sector_id=$request->sector;
                $partnerjob->jobrole_id=$request->jobrole;
                $partnerjob->target=$request->target;
                $partnerjob->save();
                
                AppHelper::instance()->writeNotification($request->userid,'partner','New Job Target',"New Jobrole with Target has been <span style='color:blue;'>Assigned</span> to you.", route('partner.dashboard.jobroles'));        
                alert()->success("New Job with Target has been <span style='font-weight:bold;color:blue'>Assigned</span> to This Training Partner", 'Job Done')->html()->autoclose(4000);
                return redirect()->back(); 
            }
        } else {
            $partnerJob=PartnerJobrole::find($request->jobid);
            if ($partnerJob) {
                if ($partnerJob->scheme_id==$request->scheme && $partnerJob->sector_id==$request->sector && $partnerJob->jobrole_id==$request->jobrole && $partnerJob->target==$request->target) {
                    alert()->info("You have not changed anything yet", 'Attention')->html()->autoclose(4000);
                } else {
                    $partnerJobFetch=PartnerJobrole::where([['id','<>',$request->jobid],['tp_id','==',$request->userid],['scheme_id','=',$request->scheme],['sector_id','=',$request->sector],['jobrole_id','=',$request->jobrole]])->first();
                    if ($partnerJobFetch) {
                        alert()->error("Jobrole with these details already <span style='font-weight:bold;color:blue'>Assigned</span> to This Training Partner", 'Abort')->html()->autoclose(5000);
                    } else {
                        $partnerJob->scheme_id=$request->scheme;
                        $partnerJob->sector_id=$request->sector;
                        $partnerJob->jobrole_id=$request->jobrole;
                        $partnerJob->target=$request->target;
                        $partnerJob->save();
                        AppHelper::instance()->writeNotification($request->userid,'partner','Jobrole Updated',"Your Jobrole has been <span style='color:blue;'>Updated</span> Kindly Check.", route('partner.dashboard.jobroles'));        
                        alert()->success("Jobrole of This Training Partner has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(4000);
                    }
                }
                return redirect()->back(); 
            } else {
                alert()->error("Could not find the Record you have <span style='font-weight:bold;color:blue'>Requested</span>", 'Attention')->html()->autoclose(2000);
                return redirect()->back();
            }            
        }
    }

    // * End Training Partner JobRole Target Section

    // * Training Partner Scheme Activation Deactivation

    public function partnerSchemeAction(Request $request){
        
        if ($request->has('data')) {

            if ($id=$this->decryptThis($request->data)) {
                $data = explode(',',$id);
                $partnerJob = PartnerJobrole::where([['tp_id',$data[0]],['scheme_id',$data[1]]])->get();
                if ($partnerJob[0]->scheme->status) {

                    DB::transaction(function() use($request,$data,$partnerJob){
                        foreach ($partnerJob as $job) {
                            $job->direct_action = $job->status;
                            $job->status = !$job->status;
                            $job->save();
                        }

                        if (!is_null($request->reason)) {
                            $p_job_reason= new PartnerJobRoleReason;
                            $p_job_reason->tp_id=$data[0];
                            $p_job_reason->scheme_id=$data[1];
                            $p_job_reason->reason=$request->reason;
                            $p_job_reason->save();
                        }
    
                        $partner = Partner::find($data[0]);
                        foreach($partner->centers as $center){
                            AppHelper::instance()->writeNotification($center->id,'center','Scheme Modified',"Your Training Partner Scheme has been Updated, Please Check your Job Roles", route('center.dashboard.jobroles'));
                        }
                        AppHelper::instance()->writeNotification($data[0],'partner','Scheme Modified',"One of Your Scheme Status Has been Updated, Please Check your Job Roles", route('partner.dashboard.jobroles'));
                    });

                    return response()->json(array('type' => 'success', 'message' => "Scheme has been <span style='font-weight:bold;color:blue'>Updated</span> Successfully"),200);

                } else {
                    return response()->json(array('type' => 'error', 'message' => "Scheme Cannot be <span style='font-weight:bold;color:blue'>Modified</span>, as Scheme Origin is <span style='font-weight:bold;color:red'>Deactivated</span>"),200);
                }
            } else {
                return response()->json(array('type' => 'error', 'message' => "Requested Scheme is not Found"),400);
            }
        }
    }

    // * End Training Partner Scheme Activation Deactivation

    public function update_partner_api(Request $request){
        if ($request->has('checkredundancy')) {
            if ($request->has('id')) {
                if (Partner::where([[$request->section,$request->checkredundancy],['id','!=',$request->id]])->first()) {
                    return response()->json(['success' => false], 200);
                } else {
                    return response()->json(['success' => true], 200);
                }
            }
        }
    }
}
