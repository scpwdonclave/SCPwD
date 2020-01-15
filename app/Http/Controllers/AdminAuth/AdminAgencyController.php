<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Mail;
use Crypt;
use Validator;
use App\Agency;
use App\Reason;
use App\Sector;
use App\JobRole;
use App\AgencyBatch;
use App\AgencySector;
use App\AssessorBatch;
use App\Helpers\AppHelper;
use App\Events\AAMailEvent;
use App\Events\ASMailEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\AAConfirmationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;

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
        $sectors=Sector::all();
        return view('admin.agencies.addagency')->with(compact('states','parliaments','sectors'));
    }
    public function insertAgency(Request $request){
        $data=DB::table('agencies')
        ->select(\DB::raw('SUBSTRING(aa_id,3) as aa_id'))
        ->where("aa_id", "LIKE", "AA%")->get();
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

        $fmonth=date('F');
        $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');

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
        $agency->f_month=$fmonth;	
        $agency->f_year=$fyear;	
        $agency->save();

        foreach ($request->sector as $sector) {
            $agencySector = new AgencySector;
            $agencySector->aa_id=$agency->id;
            $agencySector->sector=$sector;
            $agencySector->save();

        }

        $agency['password']=$agency_password;
        
        $dataMail = collect();
        $dataMail->tag = 'aaconfirmation';
        $dataMail->name = $request->name;
        $dataMail->aaid = $new_aaid;
        $dataMail->password = $agency_password;
        $dataMail->email = $request->email;

        event(new AAMailEvent($dataMail));

        alert()->success("A New Assessment Agency account has been <span style='color:blue;font-weight:bold'>Created</span>", 'Job Done')->html()->autoclose(4000);
        return redirect()->back();

    }

    public function agencyView($id){
        $id=AppHelper::instance()->decryptThis($id);
        $agency=Agency::findOrFail($id);
        $agencyState=DB::table('agencies')
        ->join('state_district','agencies.state_district','=','state_district.id')
        ->join('parliament','agencies.parliament','=','parliament.id')
        ->first();
        return view('admin.agencies.view-agency')->with(compact('agency','agencyState'));
    }

    public function agencyEdit($id){
        $aa_id=AppHelper::instance()->decryptThis($id);
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

    public function agencyStatusAction(Request $request){
        if ($request->has('data')) {

            if ($id=AppHelper::instance()->decryptThis($request->data)) {
                $data = explode(',',$id);
                $agency = Agency::find($data[0]);

                if ($agency) {
                    $dataMail = collect();
                    $dataMail->tag = 'aaactivedeactive';
                    $dataMail->status = !$agency->status;

                    $dataMail->aa_id = $agency->aa_id;
                    $dataMail->name = $agency->name;
                    $dataMail->email = $agency->email;

                    if ($agency->status) {
                        if (!is_null($request->reason) && $request->reason != '') {
                            $agency->status = 0;
                            $agency->save();
                            $reason = new Reason;
                            $reason->rel_id = $data[0];
                            $reason->rel_with = 'agency';
                            $reason->reason = $request->reason;
                            $reason->save();

                            $dataMail->reason = $request->reason;
                            
                            $array = array('type' => 'success', 'message' => "Assessment Agency Account is <span style='font-weight:bold;color:red'>Deactivated</span> now");
                        } else {
                            $array = array('type' => 'error', 'message' => "Deactivation Reason can not be <span style='font-weight:bold;color:red'>NULL</span>");
                        }
                    } else {
                        $agency->status = 1;
                        $agency->save();
                        
                        $array = array('type' => 'success', 'message' => "Assessment Agency Account is <span style='font-weight:bold;color:blue'>Activated</span> now");
                    }

                    // * Mail Events
                    if ($array['type'] == 'success') {
                        event(new AAMailEvent($dataMail));
                        foreach ($agency->assessors as $assessor) {
                            if ($assessor->status) {
                                $dataMail->name = $assessor->name;
                                $dataMail->email = $assessor->email;
                                event(new ASMailEvent($dataMail));
                            }
                        }
                    }
                    // * End Mail Events

                    return response()->json($array,200);
                } else {
                    return response()->json(array('type' => 'error', 'message' => "We Could not find this Assessment Agency Account"),400);
                }

            } else {
                return response()->json(array('type' => 'error', 'message' => "Requested Account is not Found"),400);
            }
        }
    }

    public function agencyApi(Request $request){

        if ($request->section=='mobile') {
            if($request->has('aa_id')){
                $validator = Validator::make($request->all(), [ 
                
                    'checkredundancy' => [
                        'required',
                        'numeric',
                        'unique:partners,spoc_mobile',
                        'unique:centers,mobile',
                        'unique:candidates,contact',
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
                        'unique:partners,spoc_mobile',
                        'unique:centers,mobile',
                        'unique:candidates,contact',
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
        
        } else if ($request->section=='email') {
            if($request->has('aa_id')){
            $validator = Validator::make($request->all(), [ 
              
                'checkredundancy' => [
                    'required',
                    'email',
                    'unique:admins,email',
                    'unique:partners,email',
                    'unique:centers,email',
                    'unique:candidates,email',
                    'unique:trainer_statuses,email',
                    'unique:assessors,email',
                    'unique:agencies,email,'.$request->aa_id,
                ],
            ]);
            
            }else{
                $validator = Validator::make($request->all(), [ 
              
                    'checkredundancy' => [
                        'required',
                        'email',
                        'unique:admins,email',
                        'unique:partners,email',
                        'unique:centers,email',
                        'unique:candidates,contact',
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
        
        } else if ($request->section=='aadhaar') {
            if($request->has('aa_id')){
            $validator = Validator::make($request->all(), [ 
               'checkredundancy' => [
                    'required',
                    'unique:trainer_statuses,doc_no',
                    'unique:assessors,aadhaar',
                    'unique:candidates,doc_no',
                    'unique:agencies,aadhaar,'.$request->aa_id,
                    
                ],
                ]);
                
            }else{
                $validator = Validator::make($request->all(), [ 
                    'checkredundancy' => [
                        'required',
                        'unique:trainer_statuses,doc_no',
                        'unique:assessors,aadhaar',
                        'unique:agencies,aadhaar',
                        'unique:candidates,doc_no',
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
        $id=AppHelper::instance()->decryptThis($id); 
        $agency=Agency::findOrFail($id);
        return view('admin.agencies.agency-batch')->with(compact('agency'));
    }

    public function agencyFetchBatch(Request $request){
        
        $jobroles=JobRole::where('sector_id','=',$request->sector)->get(); 
        $agencyBatch=AgencyBatch::all();
        $selBatch=array();
        foreach ($agencyBatch as $value) {
            if ($value->batch->status) {
                array_push($selBatch,$value->batch->id); 
            }
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

        AppHelper::instance()->writeNotification($request->aa_id,'agency','Batch Added',"Admin has <span style='color:blue;'>assigned</span> you one or more batch(es) Kindly <span style='color:blue;'>Approve</span> or <span style='color:red;'>Reject</span> Them");
        alert()->success("Batch(es) has been <span style='color:blue;font-weight:bold'>Added</span> with Assessment Agency", 'Job Done')->html()->autoclose(3000);
        return redirect()->back();
    }

    public function agencyBatchDelete(Request $request){
        $agencyBatch=AgencyBatch::findOrFail($request->id);

        if ($agencyBatch->batch->assessorbatch) {
            return response()->json(['status' => 'fail'],200);
        } else {
            $agencyBatch->delete();
            return response()->json(['status' => 'done'],200);
        }
    }
}
