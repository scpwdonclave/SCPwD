<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\TPConfirmationMail;
use App\Partner;
use Mail;

use DB;
use Crypt;


class AdminPartnerController extends Controller
{

    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function partners(){

        $data=Partner::all();
        return view('admin.partners.partners')->with(compact('data'));
    }
    
    public function partnerVerify($id){

        $partnerData=Partner::findOrFail($id);
        return view('admin.partners.partner-verify')->with(compact('partnerData'));
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
        Mail::to($partner['spoc_email'])->send(new TPConfirmationMail($partner));
        alert()->success('Partner Accepted', 'Done')->autoclose(2000);
        return Redirect()->back();
    }
    public function partnerReject(Request $request){
        
        $partnerData=Partner::findOrFail($request->id);
        DB::transaction(function() use ($request,$partnerData){

            DB::table('rejected_partners')->insert(
               
                ['spoc_name' => $partnerData->spoc_name	,
                'spoc_mobile' => $partnerData->spoc_mobile,	
                'spoc_email' => $partnerData->spoc_email,	
                'password'=> $partnerData->password,
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
                'state'=> $partnerData->state,	
                'district'=> $partnerData->district,	
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
                'remember_token'=> '1',	
                'created_at'=> '2019-09-02 13:58:01',	
                'updated_at'=> '2019-09-02 13:58:01',
                ]
            );

            //$partnerData->delete();
           
        });

        return response()->json(['status' => 'done'],200);
        
       
    }
}
