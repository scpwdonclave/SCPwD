<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\TPConfirmationMail;
use App\PartnerJobRoleReason;
use App\Mail\TPUpdateAccept;
use App\Mail\TPUpdateReject;
use Illuminate\Http\Request;
use App\Mail\TPRejectMail;
use App\PartnerJobrole;
use App\CenterJobRole;
use App\Notification;
use Carbon\Carbon;
use App\Partner;
use App\Reason;
use App\Center;
use App\Sector;
use App\Scheme;
use Crypt;
use Mail;
use DB;

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


    public function partners(){
        $data=Partner::where([['pending_verify','=',0]])->get();
       
        return view('admin.partners.partners')->with(compact('data'));
    }

    public function pendingpartners(){
        $data=Partner::where('pending_verify','=',1)
        ->orWhere('pending_verify','=',null)
        ->get();

        return view('admin.partners.pending-partners')->with(compact('data'));
    }

    public function partnerDeactive(Request $request){
        $partnerData=Partner::findOrFail($request->id);
            DB::transaction(function() use ($partnerData){
                $partnerData->status=0;
                $partnerData->save();

                $reason = new Reason;
                $reason->rel_id = $partnerData->id;
                $reason->rel_with = 'partner';
                $reason->reason = $request->reason;
                $reason->save();

                foreach ($partnerData->partner_jobroles as $partnerjob) {
                    $partnerjob->status = 0;
                    $partnerjob->save();
                }
            });
        return response()->json(['status' => 'done'],200);
        
    }
    public function partnerActive($id){
        $partnerData=Partner::findOrFail($id);
        DB::transaction(function() use ($partnerData){
            $partnerData->status=1;
            $partnerData->save();
            foreach ($partnerData->partner_jobroles as $partnerjob) {
                if ($partnerjob->scheme->status) {
                    $partnerjob->status = 1;
                    $partnerjob->save();
                }
            }
        });
        // ! All Inactive Schemes Under Any Partner Will be Auto Re-Activated (IF THEY WERE PREVIOUSLY DEACTIVATED WITH PARTNER-SCHEME DEACTIVATION PROCESS)
        alert()->success("Partner and all its <span style='color:blue;'>Schemes, Jobroles</span> are now <span style='color:blue;'>Activated</span>", "Done")->autoclose(2000);
        return redirect()->back();
    }

    public function partnerVerify($id){

        $partnerData=Partner::findOrFail($id); 
        $partnerState=DB::table('partners')
        ->join('state_district','partners.state_district','=','state_district.id')
        ->join('parliament','partners.parliament','=','parliament.id')
        ->first();

        

        $centers=DB::table('centers')->where('tp_id',$id)->get();
        $partner_scheme=PartnerJobrole::where('tp_id',$id)
        ->groupBy('scheme_id')->get();

        if ($partnerData->complete_profile && $partnerData->status==1) {
            return view('admin.partners.partner-verify')->with(compact('partnerData','partnerState','centers','partner_scheme'));
        } else {
            return redirect()->route('admin.tp.partners');
        }
        
    }

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

    public function partnerAccept($id){
        try {
           $partner_id = Crypt::decrypt($id); 
        } catch (DecryptException $e) {
            abort(404);
        }
        $partner=Partner::findOrFail($partner_id);
        if($partner->pending_verify==0){
            alert()->error("Training Partner Account already <span style='color:blue;'>Approved</span>", "Done")->html()->autoclose(2000);
            return Redirect()->back(); 
        }
        $data=DB::table('partners')
        ->select(\DB::raw('SUBSTRING(tp_id,3) as tp_id'))
        ->where("tp_id", "LIKE", "TP%")->get();
        $year = date('Y');
        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->tp_id;
                }
                $lastid= max($priceprod);
               
                $new_tpid = (substr($lastid, 0, 4)== $year) ? 'TP'.($lastid + 1) : 'TP'.$year.'000001' ;
            //dd($new_tpid);
        } else {
            $new_tpid = 'TP'.$year.'000001';
        }

        $partner->tp_id=$new_tpid;
        $partner->pending_verify=0;
        $partner->save();
        
        /* Notification For Partner */
        $notification = new Notification;
        $notification->rel_id = $partner->id;
        $notification->rel_with = 'partner';
        $notification->title = 'Account Activated';
        $notification->message = "Your Profile has been <span style='color:blue;'>Approved</span>.";
        $notification->save();
        /* End Notification For Partner */
        
        Mail::to($partner['email'])->send(new TPConfirmationMail($partner));
        alert()->success("Training Partner Account has been <span style='color:blue;'>Approved</span>", "Done")->html()->autoclose(4000);
        return Redirect()->back();
    }
    public function partnerReject(Request $request){
        
        $partnerData=Partner::findOrFail($request->id);
        DB::transaction(function() use ($request,$partnerData){

            DB::table('rejected_partners')->insert(
               
                ['spoc_name' => $partnerData->spoc_name	,
                'spoc_mobile' => $partnerData->spoc_mobile,	
                'email' => $partnerData->email,	 
                'incorp_doc'=> $partnerData->incorp_doc,	
                'org_name'=> $partnerData->org_name,	
                'org_type'=> $partnerData->org_type,	
                'estab_year'=> $partnerData->estab_year,	
                'landline'=> $partnerData->landline,	
                'website'=> $partnerData->website,	
                'ceo_name'=> $partnerData->ceo_name,	
                'ceo_email'=> $partnerData->ceo_email,	
                'ceo_mobile'=> $partnerData->ceo_mobile,	
                'signatory_name'=> $partnerData->signatory_name,	
                'signatory_email'=> $partnerData->signatory_email,	
                'signatory_mobile'=> $partnerData->signatory_mobile,	
                'org_address'=> $partnerData->org_address,	
                'landmark'=> $partnerData->landmark,	
                'addr_proof'=> $partnerData->addr_proof,	
                'addr_doc'=> $partnerData->addr_doc,	
                'city'=> $partnerData->city,	
                'block'=> $partnerData->block,	
                'pin'=> $partnerData->pin,	
                'state_district'=> $partnerData->state_district,	
                'parliament'=> $partnerData->parliament,	
                'pan'=> $partnerData->pan,	
                'pan_doc'=> $partnerData->pan_doc,	
                'gst'=> $partnerData->gst,	
                'gst_doc'=> $partnerData->gst_doc,	
                'ca1_doc'=> $partnerData->ca1_doc,	
                'ca1_year'=> $partnerData->ca1_year,	
                'ca2_doc'=> $partnerData->ca2_doc,	
                'ca2_year'=> $partnerData->ca2_year,	
                'ca3_doc'=> $partnerData->ca3_doc,	
                'ca3_year'=> $partnerData->ca3_year,	
                'ca4_doc'=> $partnerData->ca4_doc,	
                'ca4_year'=> $partnerData->ca4_year,	
                'offer'=> $partnerData->offer,	
                'offer_date'=> $partnerData->offer_date,	
                'offer_doc'=> $partnerData->offer_doc,	
                'sanction'=> $partnerData->sanction,	
                'sanction_date'=> $partnerData->sanction_date,	
                'sanction_doc'=> $partnerData->sanction_doc,	
                'reason'=> $request->note,
                'remember_token'=> 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]
            );
            $data = $partnerData;
            $data['note'] = $request->note;
            $partnerData->delete();
            Mail::to($data->email)->send(new TPRejectMail($data));
            
        });
        return response()->json(['status' => 'done'],200);
        
       
    }
    public function partnerUpdateAccept($id,$tpid){
       $updt= DB::table('partner_update')->where([['id','=',$id],['tp_id','=',$tpid]])->first();
       $updated_partner= DB::table('partners')->where('tp_id','=',$tpid)->first();
       if(!$updt) abort(404);
    
       DB::table('partner_update')
       ->where('id', $id)->update(['action' => 1,'approve'=>1,'created_at' => Carbon::now(),
       'updated_at' => Carbon::now()]);
       DB::table('partners')
       ->where('tp_id', $tpid)
       ->update(['spoc_name' => $updt->spoc_name,'email'=>$updt->email,'spoc_mobile'=>$updt->spoc_mobile,'updated_at' => Carbon::now()]);
      
       /* Notification For Partner */
       $notification = new Notification;
       $notification->rel_id = $updated_partner->id;
       $notification->rel_with = 'partner';
       $notification->title = 'Account Updated';
       $notification->message = "Your Profile has been <span style='color:blue;'>Updated</span>.";
       $notification->save();
       /* End Notification For Partner */
       
       Mail::to($updt->email)->send(new TPUpdateAccept($updt));
      alert()->success('Partner Accepted', 'Done')->autoclose(2000);
      return Redirect()->back();

        
    }
    public function partnerUpdateReject(Request $request){

        $updated_partner= DB::table('partners')->where('tp_id','=',$request->tpid)->first();
        DB::table('partner_update')
        ->where('id',$request->id)->update(['action' => 1,'approve'=>0,'comment'=>$request->note,'updated_at' => Carbon::now()]);
        
         /* Notification For Partner */
       $notification = new Notification;
       $notification->rel_id = $updated_partner->id;
       $notification->rel_with = 'partner';
       $notification->title = 'Account Update Request Cancel';
       $notification->message = "Your Profile update request has been <span style='color:blue;'>Rejected</span>.";
       $notification->save();
       /* End Notification For Partner */
         $updated_partner->note = $request->note;
       Mail::to($updated_partner->email)->send(new TPUpdateReject($updated_partner));

        return response()->json(['status' => 'done'],200);
    }

    

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

             /* For partner */
             $notification = new Notification;
             $notification->rel_id = $partner->id;
             $notification->rel_with = 'partner';
             $notification->title = 'Partner Update';
             $notification->message = "<span style='color:blue;'>".$partner->spoc_name."</span> your profile has been Updated";
             $notification->save();

             alert()->success("Training Partner profile has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(2000);
             return Redirect()->back();


    }

    public function partnerTarget($id){
        // $data=DB::table('orders')
        // ->join('customers','orders.customer_id','=','customers.cust_id')
        // ->select('orders.id','orders.order_date','orders.order_no','orders.order_date','orders.total_amount','customers.customer_display_name')
        // ->get();
        try {
           $partner_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            abort(404);
        }
        $partner= Partner::findOrFail($partner_id);
        // $tp_job=DB::table('partner_jobroles AS p')
        //     ->join('sectors AS s','p.sector_id','=','s.id')
        //     ->join('job_roles AS r','p.jobrole_id','=','r.id')
        //     ->join('schemes AS sc','p.scheme_id','=','sc.id')
        //     ->select('p.id as id','p.scheme_id as scheme_id','p.sector_id as sector_id','p.target as target','p.status as status','s.sector as sector','r.job_role as job_role','sc.scheme')
        //     ->where('p.tp_id',$partner->tp_id)->get();
        $sectors=Sector::all();
        $schemes=Scheme::all();
        
        return view('admin.partners.partner-target')->with(compact('sectors','partner','schemes'));
    }

    public function fetchJobrole(Request $request){

        $jobroles=DB::table('job_roles')->where('sector_id','=',$request->sector)->get();
        return response()->json(['jobroles' => $jobroles],200); 
    }

    public function fetchPrvData(Request $request){

        $data=DB::table('partner_jobroles')->where('id','=',$request->e_id)->first();
        $job=DB::table('job_roles')->where('sector_id','=',$data->sector_id)->get();
        $sectors=Sector::all();
        $schemes=Scheme::all();
        return response()->json(['sectors' => $sectors,'data'=>$data,'job'=>$job,'schemes'=>$schemes],200); 
    }
    //Job Submit
    public function jobTarget(Request $request){
        $data=PartnerJobrole::where([['tp_id','=',$request->tpid],
                                    ['scheme_id','=',$request->scheme2],
                                    ['sector_id','=',$request->sector2],
                                    ['jobrole_id','=',$request->jobrole2]])->get();
            
        if(count($data)>0){
            alert()->error("Training Partner Job Target with this details already <span style='font-weight:bold;color:blue'>Assign</span>", 'Abort')->html()->autoclose(5000);
        return Redirect()->back();
        }else{
        $partnerjob = new PartnerJobrole;
        $partnerjob->tp_id=$request->tpid;
        $partnerjob->scheme_id=$request->scheme2;
        $partnerjob->sector_id=$request->sector2;
        $partnerjob->jobrole_id=$request->jobrole2;
        $partnerjob->target=$request->target;
        $partnerjob->save();

        $notification = new Notification;
        $notification->rel_id =$request->tpid;
        $notification->rel_with = 'partner';
        $notification->title = 'Partner Job Target';
        $notification->message = "Job target has been Updated";
        $notification->save();

        alert()->success("Training Partner Job Target <span style='font-weight:bold;color:blue'>Assign</span>", 'Job Done')->html()->autoclose(2000);
        return Redirect()->back();
        }
    }
    public function jobTargetUpdate(Request $request){
       
        $data=PartnerJobrole::where([
                                    ['scheme_id','=',$request->scheme2_u],
                                    ['sector_id','=',$request->sector2_u],
                                    ['jobrole_id','=',$request->jobrole2_u],
                                    ['target','=',$request->target_u]])->get();
        if(count($data)>0){
            alert()->error("Training Partner Job Target with this details already <span style='font-weight:bold;color:blue'>Assign</span>", 'Abort')->html()->autoclose(5000);
        return Redirect()->back();
        }else{
        $partnerjob =PartnerJobrole::findOrFail($request->p_job_id) ;
       
        $partnerjob->scheme_id=$request->scheme2_u;
        $partnerjob->sector_id=$request->sector2_u;
        $partnerjob->jobrole_id=$request->jobrole2_u;
        $partnerjob->target=$request->target_u;
        $partnerjob->save();

        $notification = new Notification;
        $notification->rel_id =$request->tpid2;
        $notification->rel_with = 'partner';
        $notification->title = 'Partner Job Target';
        $notification->message = "Job target has been Updated";
        $notification->save();

        alert()->success("Training Partner Job Target <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(2000);
        return Redirect()->back();
        }
    }

    public function jobroleDeactive(Request $request){
        $partnerJob=PartnerJobrole::findOrFail($request->id);
        $partnerJob->status=0;
        $partnerJob->save();
        return response()->json(['status' => 'done'],200);
    }

    public function jobroleActive($id){
        $partnerJob=PartnerJobrole::findOrFail($id);
        $partnerJob->status=1;
        $partnerJob->save();
        alert()->success("Training Partner Job Target <span style='font-weight:bold;color:blue'>Activated</span>", 'Activated')->html()->autoclose(2000);
        return Redirect()->back();
    }

    // public function partnerScheme($id){
    //     $partner_id = Crypt::decrypt($id);
    //     $partner_dtl=Partner::findOrFail($partner_id);
    //     $partner_scheme=PartnerJobrole::where('tp_id',$partner_id)
    //     ->groupBy('scheme_id')->get();

    //     return view('admin.partners.partner-scheme')->with(compact('partner_scheme','partner_dtl'));
        
    // }

    public function partnerSchemeDeactive(Request $request){

        $partnerScheme=PartnerJobrole::where([['scheme_id','=',$request->id],['tp_id','=',$request->pid]])->get();
        
        foreach ($partnerScheme as  $scheme) {
            
            $scheme->save();

           $p_job_reason= new PartnerJobRoleReason;
           $p_job_reason->partner_job_id=$scheme->id;
           $p_job_reason->reason=$request->reason;
           $p_job_reason->save();
            
            $get_tc_job=CenterJobRole::where('tp_job_id',$scheme->id)->get();
            
            foreach ($get_tc_job as  $tcid) {
                $tcid->save();
               
            }

        }
        $partner = Partner::find($request->id);
        foreach($partner->centers as $center){
            $notification = new Notification;
            $notification->rel_id =$center->id;
            $notification->rel_with = 'center';
            $notification->title = 'Scheme Deactivated';
            $notification->message = "Your Training Partner Scheme has been Deactivated";
            $notification->save();
            
        }
            $notification = new Notification;
            $notification->rel_id =$request->pid;
            $notification->rel_with = 'partner';
            $notification->title = 'Scheme Deactivated';
            $notification->message = "One of Your Scheme has been Deactivated";
            $notification->save();

        return response()->json(['status' => 'done'],200);

    }

    public function partnerSchemeActive($id,$pid){
        try {
            $id = Crypt::decrypt($id);
            $pid = Crypt::decrypt($pid);
           
        } catch (DecryptException $e) {
            abort(404);
        }
        $partnerScheme=PartnerJobrole::where([['scheme_id','=',$id],['tp_id','=',$pid]])->get();

        foreach ($partnerScheme as  $scheme) {
            
            $scheme->save();
            
            $get_tc_job=CenterJobRole::where('tp_job_id',$scheme->id)->get();
            
            foreach ($get_tc_job as  $tcid) {
                $tcid->save();
                
            }

        }

        $partner = Partner::find($pid);
        foreach($partner->centers as $center){
            $notification = new Notification;
            $notification->rel_id =$center->id;
            $notification->rel_with = 'center';
            $notification->title = 'Scheme Activated';
            $notification->message = "Your Training Partner Scheme has been Activated";
            $notification->save();
            
        }
            $notification = new Notification;
            $notification->rel_id =$pid;
            $notification->rel_with = 'partner';
            $notification->title = 'Scheme Activated';
            $notification->message = "One of Your Scheme has been Activated";
            $notification->save();
        alert()->success("Training Partner Scheme <span style='font-weight:bold;color:blue'>Activated</span>", 'Activated')->html()->autoclose(2000);
        return Redirect()->back();
    }

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
