<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TPConfirmationMail;
use App\Mail\TPUpdateAccept;
use App\Mail\TPUpdateReject;
use App\Mail\TPRejectMail;
use App\Partner;
use App\JobRole;
use App\Disability;
use App\Sector;
use App\Notification;
use Mail;
use Carbon\Carbon;
use DB;
use Crypt;

class AdminHomeController extends Controller
{
    

    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function dashboard(){
        return view('admin.home');
    }

    public function disability(){
        $disabilities = Disability::all();
        return view('admin.dashboard.disability')->with(compact('disabilities'));
    }

    
    public function disability_action(Request $request){
        if ($request->has('disability')) {
            return $this->dispatchNow(new \App\Jobs\AddDisability($request));
        } else if ($request->has('name')) {
            return $this->dispatchNow(new \App\Jobs\UpdateDisability($request));
        }
        return abort(404);
        // return response()->view('authentication.page404');
    }
    
    public function job_roles(){

        $sectors = Sector::all();
        $disabilities = Disability::where('status',1)->get();
        $jobroles = JobRole::all();
        return view('admin.dashboard.jobroles')->with(compact('sectors','disabilities','jobroles'));
    }
    
    public function job_roles_action(Request $request){
        if ($request->has('sector')) {
            return $this->dispatchNow(new \App\Jobs\AddSector($request));
        } else if ($request->has('name')) {
            return $this->dispatchNow(new \App\Jobs\RemoveSector($request));
        } else if ($request->has('sector_id')) {
            return $this->dispatchNow(new \App\Jobs\AddJobRole($request));
        }
        dd($request);
    }


    public function partners(){

        $data=Partner::all();
        $tp_updt_req=DB::table('partner_update as p_updt')
                        ->join('partners as p','p.tp_id','=','p_updt.tp_id')
                        ->select('p_updt.id as id','p_updt.tp_id as tp_id','p_updt.spoc_name as uname','p_updt.email as uemail','p_updt.spoc_mobile as umobile',
                        'p.spoc_name as pname','p.email as pemail','p.spoc_mobile as pmobile')
                        ->where('p_updt.action',0)->get();
        return view('admin.partners.partners')->with(compact('data','tp_updt_req'));
    }
    
    public function partnerVerify($id){

        $partnerData=Partner::findOrFail($id);
        if ($partnerData->complete_profile) {
            return view('admin.partners.partner-verify')->with(compact('partnerData'));
        } else {
            return redirect()->route('admin.partners');
        }
        
    }
    public function partnerAccept($id){
        $partner_id = Crypt::decrypt($id); 
        $partner=Partner::findOrFail($partner_id);
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
        alert()->success('Partner Accepted', 'Done')->autoclose(2000);
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
}
