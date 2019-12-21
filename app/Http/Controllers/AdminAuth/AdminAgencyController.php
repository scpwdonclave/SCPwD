<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\AAConfirmationMail;
use App\Agency;
use App\AgencyBatch;
use App\AssessorBatch;
use App\Reason;
use App\AgencySector;
use App\JobRole;
use Validator;
use Crypt;
use DB;
use Mail;
use Storage;

class AdminAgencyController extends Controller
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

    protected function partnerstatus($batch){
        if ($batch->partner->status && $batch->tpjobrole->status) {
            return true;
        } else {
            return false;
        }
    }

    public function agencies(){
        $data=Agency::where('status',1)->get();
        $deactiveData=Agency::where('status',0)->get();
        return view('admin.agencies.agencies')->with(compact('data','deactiveData'));
     }

    public function addAgency(){
        $states=DB::table('state_district')->get();
        $parliaments=DB::table('parliament')->get();
        $sectors=DB::table('sectors')->get();
        return view('admin.agencies.addagency')->with(compact('states','parliaments','sectors'));
    }
    public function insertAgency(Request $request){
        $data=DB::table('agencies')
        ->select(\DB::raw('SUBSTRING(aa_id,3) as aa_id'))
        ->where("aa_id", "LIKE", "AA%")->get();
       // dd(count($data));
        $year = date('Y');
        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->aa_id;
                }
                $lastid= max($priceprod);
               
                $new_aaid = (substr($lastid, 0, 4)== $year) ? 'AA'.($lastid + 1) : 'AA'.$year.'000001' ;
            //dd($new_tpid);
        } else {
            $new_aaid = 'AA'.$year.'000001';
        }

        $agency_password = str_random(8);

        $agency = new Agency;
        $agency->aa_id=$new_aaid;
        $agency->password=Hash::make($agency_password);
        $agency->agency_name=$request->agency_name;
        $agency->org_type=$request->org_type;	
        $agency->org_id	=$request->org_id;
        $agency->sla_date=$request->sla_date;	
        $agency->sla_end_date=$request->sla_end_date;

        $agency->ceo_name=$request->ceo_name;	
        $agency->ceo_aadhaar=$request->ceo_aadhaar;
        $agency->ceo_email=$request->ceo_email;	
        $agency->ceo_mobile	=$request->ceo_mobile;
        $agency->ceo_gender	=$request->ceo_gender;
        $agency->ceo_designation=$request->ceo_designation;	
        $agency->ceo_landline=$request->ceo_landline;

        $agency->name=$request->name;	
        $agency->aadhaar=$request->aadhaar;	
        $agency->email=$request->email;
        $agency->mobile=$request->mobile;	
        $agency->gender=$request->gender;	
        $agency->designation=$request->designation;	
        $agency->landline=$request->landline;

        $agency->org_address=$request->org_address;	
        $agency->post_office=$request->post_office;	
        $agency->state_district	=$request->state_district;
        $agency->parliament	=$request->parliament;
        $agency->city=$request->city;	
        $agency->sub_district=$request->sub_district;	
        $agency->pin=$request->pin;	
        $agency->org_landline=$request->org_landline;	
        $agency->website=$request->website;	
        $agency->save();

        foreach ($request->sector as $sector) {
            $agencySector = new AgencySector;
            $agencySector->aa_id=$agency->id;
            $agencySector->sector=$sector;
            $agencySector->save();

        }

        $agency['password']=$agency_password;
        Mail::to($agency['email'])->send(new AAConfirmationMail($agency));

        alert()->success("Assessment Agency has been <span style='color:blue;font-weight:bold'>Registered</span>", 'Job Done')->html()->autoclose(3000);
        return Redirect()->back();

    }

    public function agencyView($id){
        $id=$this->decryptThis($id);
        $agency=Agency::findOrFail($id);
        $agencyState=DB::table('agencies')
        ->join('state_district','agencies.state_district','=','state_district.id')
        ->join('parliament','agencies.parliament','=','parliament.id')
        ->first();
        return view('admin.agencies.view-agency')->with(compact('agency','agencyState'));
    }

    public function agencyEdit($id){
        $aa_id =$this->decryptThis($id);
         $agency=Agency::findOrFail($aa_id);
         $states=DB::table('state_district')->get();
         $parliaments=DB::table('parliament')->get();
         $sectors=DB::table('sectors')->get();

         $selSector=array();
         foreach ($agency->agencySector as $item){
           
            array_push($selSector,$item->sector); 
            
         }
         
         return view('admin.agencies.agency-edit')->with(compact('agency','states','parliaments','sectors','selSector'));
    }

    public function agencyUpdate(Request $request){
        $agency=Agency::findOrFail($request->aa_id);
        $agency->agency_name=$request->agency_name;
        $agency->org_type=$request->org_type;	
        $agency->org_id	=$request->org_id;
        $agency->sla_date=$request->sla_date;	
        $agency->sla_end_date=$request->sla_end_date;

        $agency->ceo_name=$request->ceo_name;	
        $agency->ceo_aadhaar=$request->ceo_aadhaar;
        $agency->ceo_email=$request->ceo_email;	
        $agency->ceo_mobile	=$request->ceo_mobile;
        $agency->ceo_gender	=$request->ceo_gender;
        $agency->ceo_designation=$request->ceo_designation;	
        $agency->ceo_landline=$request->ceo_landline;

        $agency->name=$request->name;	
        $agency->aadhaar=$request->aadhaar;	
        $agency->email=$request->email;
        $agency->mobile=$request->mobile;	
        $agency->gender=$request->gender;	
        $agency->designation=$request->designation;	
        $agency->landline=$request->landline;

        $agency->org_address=$request->org_address;	
        $agency->post_office=$request->post_office;	
        $agency->state_district	=$request->state_district;
        $agency->parliament	=$request->parliament;
        $agency->city=$request->city;	
        $agency->sub_district=$request->sub_district;	
        $agency->pin=$request->pin;	
        $agency->org_landline=$request->org_landline;	
        $agency->website=$request->website;	
        $agency->save();

       AgencySector::where('aa_id',$request->aa_id)->delete();
       

          foreach ($request->sector as $sector) {
            $agencySector = new AgencySector;
            $agencySector->aa_id=$agency->id;
            $agencySector->sector=$sector;
            $agencySector->save();

        }

        alert()->success("Assessment Agency has been <span style='color:blue;font-weight:bold'>Updated</span>", 'Job Done')->html()->autoclose(3000);
        return Redirect()->back();
        }

    public function agencyDeactive(Request $request){
        $agency=Agency::findOrFail($request->id);
        $agency->status=0;
        $agency->save();

        $reason = new Reason;
        $reason->rel_id = $agency->id;
        $reason->rel_with = 'agency';
        $reason->reason = $request->reason;
        $reason->save();

        return response()->json(['status' => 'done'],200);
    }

    public function agencyActive($id){
        try {
           $aa_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            abort(404);
        }
        $agency=Agency::findOrFail($aa_id);
        $agency->status=1;
        $agency->save();

        alert()->success("Assessment Agency has been <span style='color:blue;font-weight:bold'>Activated</span>", 'Job Done')->html()->autoclose(3000);
        return Redirect()->back();
    }

    public function agencyApi(Request $request){

        if ($request->section=='mobile') {
            if($request->has('aa_id')){
            $validator = Validator::make($request->all(), [ 
              
                'checkredundancy' => [
                    'required',
                    'numeric',
                    'unique:trainers,mobile',
                    'unique:partners,spoc_mobile',
                    'unique:centers,mobile',
                    'unique:trainer_statuses,mobile',
                    'unique:assessors,mobile',
                    'unique:agencies,mobile,'.$request->aa_id,
                    
                ],
            ]);
            }else{
                $validator = Validator::make($request->all(), [ 
              
                    'checkredundancy' => [
                        'required',
                        'numeric',
                        'unique:trainers,mobile',
                        'unique:partners,spoc_mobile',
                        'unique:centers,mobile',
                        'unique:trainer_statuses,mobile',
                        'unique:assessors,mobile',
                        'unique:agencies,mobile',
                        
                    ],
                ]); 
            }

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->errors()]);
            } else {
                return response()->json(['success' => true], 200);
            }
        
        }
        else if ($request->section=='email') {
            if($request->has('aa_id')){
            $validator = Validator::make($request->all(), [ 
              
                'checkredundancy' => [
                    'required',
                    'unique:trainers,email',
                    'unique:partners,email',
                    'unique:centers,email',
                    'unique:trainer_statuses,email',
                    'unique:assessors,email',
                    'unique:agencies,email,'.$request->aa_id,
                ],
            ]);
            
            }else{
                $validator = Validator::make($request->all(), [ 
              
                    'checkredundancy' => [
                        'required',
                        'unique:trainers,email',
                        'unique:partners,email',
                        'unique:centers,email',
                        'unique:trainer_statuses,email',
                        'unique:assessors,email',
                        'unique:agencies,email',
                    ],
                ]);
            }

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->errors()]);
            } else {
                return response()->json(['success' => true], 200);
            }
        
        }
        else if ($request->section=='aadhaar') {
            if($request->has('aa_id')){
            $validator = Validator::make($request->all(), [ 
               'checkredundancy' => [
                    'required',
                    'unique:trainers,doc_no',
                    'unique:trainer_statuses,doc_no',
                    'unique:assessors,aadhaar',
                    'unique:agencies,aadhaar,'.$request->aa_id,
                    
                ],
            ]);
                
            }else{
                $validator = Validator::make($request->all(), [ 
                    'checkredundancy' => [
                         'required',
                         'unique:trainers,doc_no',
                         'unique:trainer_statuses,doc_no',
                         'unique:assessors,aadhaar',
                         'unique:agencies,aadhaar',
                         
                     ],
                 ]);
            }

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors'=>$validator->errors()]);
            } else {
                return response()->json(['success' => true], 200);
            }
        
        }

    }

    public function agencyBatch($id){
        $id=$this->decryptThis($id); 
        $agency=Agency::where([['id','=',$id],['status','=',1]])->get();
        if(count($agency)==null){
           abort(404);
        }
        return view('admin.agencies.agency-batch')->with(compact('agency'));
        
    }

    public function agencyFetchBatch(Request $request){
        
        $jobroles=JobRole::where('sector_id','=',$request->sector)->get(); 
        $agencyBatch=AgencyBatch::all();
        $selBatch=array();
        foreach ($agencyBatch as $value) {
            array_push($selBatch,$value->batch->id); 
        }
        $batch=array();
        foreach ($jobroles as  $job) {
        foreach ($job->batches as  $job2) {
            if($job2->status && $job2->verified && !$job2->completed && $this->partnerstatus($job2)){
                array_push($batch,$job2); 
            }
            
        }
    }
  

        return response()->json(['batch' => $batch,'selbatch'=>$selBatch],200);  
    }

    public function agencyBatchInsert(Request $request){
        foreach ($request->batch as $batch) {
           $agencyBatch=new AgencyBatch;
           $agencyBatch->aa_id=$request->aa_id;
           $agencyBatch->bt_id=$batch;
           $agencyBatch->save();
        }
        alert()->success("Batch has been <span style='color:blue;font-weight:bold'>Added</span> with Assessment Agency", 'Job Done')->html()->autoclose(3000);
        return Redirect()->back();
    }

    public function agencyBatchDelete(Request $request){
        $agencyBatch=AgencyBatch::findOrFail($request->id);

        $assessorBatch=AssessorBatch::where('bt_id',$agencyBatch->bt_id)->first();
        if($assessorBatch !=null){
            return response()->json(['status' => 'fail'],200);

        }else{
            $agencyBatch->delete();
            return response()->json(['status' => 'done'],200);

        }
    }
}
