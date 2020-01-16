<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Auth;
use Mail;
use Crypt;
use App\Reason;
use App\Sector;
use App\Assessor;
use App\AgencySector;
use App\Notification;
use App\AssessorBatch;
use App\AssessorJobRole;
use App\AssessorLanguage;
use App\Helpers\AppHelper;
use App\Events\AAMailEvent;
use App\Events\ASMailEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminAssessorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']); 
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function assessor(){
        $data=Assessor::where('verified',1)->get();
        return view('admin.assessors.assessors')->with(compact('data'));
    }

    public function assessorView($id){
        $id=AppHelper::instance()->decryptThis($id);
        $assessorData=Assessor::findOrFail($id);
        $assessorState=DB::table('assessors')
        ->join('state_district','assessors.state_district','=','state_district.id')
        ->join('parliament','assessors.parliament','=','parliament.id')
        ->first();
        $language=DB::table('assessor_languages')
         ->join('language','language.id','=','assessor_languages.language_id')
         ->where('assessor_languages.as_id',$id)->get();
        return view('common.view-assessor')->with(compact('assessorData','language','assessorState'));
    }

    public function pendingAssessors(){
        $data=Assessor::where('verified',0)->get();
        return view('admin.assessors.pending-assessors')->with(compact('data'));
    }



    // * Assessor Activation Deactvation

        public function assessorStatusAction(Request $request){
            if ($request->has('data')) {
    
                if ($id=AppHelper::instance()->decryptThis($request->data)) {
                    $data = explode(',',$id);
                    $assessor = Assessor::find($data[0]);
    
                    if ($assessor) {
                        $dataMail = collect();
                        $dataMail->tag = 'asactivedeactive'; // * Mailling Tag
                        $dataMail->aa_name = $assessor->agency->name;
                        $dataMail->as_id = $assessor->as_id;
                        $dataMail->status = !$assessor->status;
                        $dataMail->name = $assessor->name;
                        $dataMail->email = $assessor->email;

                        if ($assessor->status) {
                            if (!is_null($request->reason) && $request->reason != '') {
                                $assessor->status = 0;
                                $assessor->save();
                                $reason = new Reason;
                                $reason->rel_id = $data[0];
                                $reason->rel_with = 'assessor';
                                $reason->reason = $request->reason;
                                $reason->save();
    
                                $dataMail->reason = $request->reason; 
                                
                                AppHelper::instance()->writeNotification($assessor->aa_id,'agency','Assessor Deactivated',"AS (ID: <span style='color:blue;'>$assessor->as_id</span>) Account is now <span style='color:red;'>Dectivated</span>.");
                                $array = array('type' => 'success', 'message' => "Assessor Account is <span style='font-weight:bold;color:red'>Deactivated</span> now");
                            } else {
                                $array = array('type' => 'error', 'message' => "Deactivation Reason can not be <span style='font-weight:bold;color:red'>NULL</span>");
                            }
                        } else {
                            $assessor->status = 1;
                            $assessor->save();
    
                            AppHelper::instance()->writeNotification($assessor->aa_id,'agency','Assessor Activated',"TC (ID: <span style='color:blue;'>$assessor->as_id</span>) Account is now <span style='color:blue;'>Activated</span>.");
                            $array = array('type' => 'success', 'message' => "Assessor Account is <span style='font-weight:bold;color:blue'>Activated</span> now");
                        }
    
                        if ($assessor->agency->status) {

                            event(new ASMailEvent($dataMail));
                            $dataMail->name = $assessor->agency->name;
                            $dataMail->email = $assessor->agency->email;
                            event(new AAMailEvent($dataMail));

                        }
                        return response()->json($array,200);
                    } else {
                        return response()->json(array('type' => 'error', 'message' => "We Could not find this Assessor Account"),400);
                    }
    
                } else {
                    return response()->json(array('type' => 'error', 'message' => "Requested Account is not Found"),400);
                }
            }        
        }
    
    // * End Assessor Activation Deactvation


    // * Assessor Approve Reject

    public function assessorAction(Request $request){

        if ($req=AppHelper::instance()->decryptThis($request->id)) {
            $data = explode(',',$req);
            $assessor = Assessor::findOrFail($data[0]);
            if (!$assessor->verified) {
                if (!$assessor->agency->status) {
                    alert()->error('Please <span style="color:blue;">Re-Activate</span> Assessment Agency of This Assessor Before you Proceed', 'Aborting')->html()->autoclose(5000);
                    return redirect()->back();
                } else {
                    $dataMail = collect();
                    $dataMail->tag = 'asacceptreject';
                    $dataMail->name = $assessor->name;
                    $dataMail->aa_name = $assessor->agency->name;
                    $dataMail->status = $data[1];
                    if ($data[1]) {
                        $assessor_password = str_random(8);

                        DB::transaction(function() use($assessor, $assessor_password){
                            $data=DB::table('assessors')
                            ->select(\DB::raw('SUBSTRING(as_id,3) as as_id'))
                            ->where("as_id", "LIKE", "AS%")->get();
                            $year = date('Y');
                            if (count($data) > 0) {
                    
                                $priceprod = array();
                                    foreach ($data as $key=>$data) {
                                        $priceprod[$key]=$data->as_id;
                                    }
                                    $lastid= max($priceprod);
                                   
                                    $new_asid = (substr($lastid, 0, 4)== $year) ? 'AS'.($lastid + 1) : 'AS'.$year.'000001' ;
                            } else {
                                $new_asid = 'AS'.$year.'000001';
                            }
                    
                            $fmonth=date('F');
                            $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');
                    
                            $assessor->as_id=$new_asid;

                            if(is_null($assessor->as_id)){
                                $assessor->as_id=$new_asid;
                            }

                            $assessor->password=Hash::make($assessor_password);
                            $assessor->f_month=$fmonth;
                            $assessor->f_year=$fyear;

                            $assessor->status=1;
                            $assessor->verified=1;
                            $assessor->save();                            
                        });

                        $dataMail->as_id = $assessor->as_id;
                        $dataMail->password = $assessor_password;
                        $dataMail->email = $assessor->email;
                        event(new ASMailEvent($dataMail));
                        $dataMail->email = $assessor->agency->email;
                        event(new AAMailEvent($dataMail));
                        
                        AppHelper::instance()->writeNotification($assessor->agency->id,'agency','Assessor Accepted',"Your Assessor (ID: <span style='color:blue'>$assessor->as_id</span>) has been <span style='color:blue;'>Approved</span>.");
                        alert()->success("Assessor has been <span style='color:blue;font-weight:bold;'>Approved</span>", 'Job Done')->html()->autoclose(3000);
                        
                        
                    } else {
                        $dataMail->email = $assessor->agency->email;
                        $dataMail->reason = $request->reason;
                        DB::transaction(function() use ($assessor){
                            $assessor->assessorJob()->delete();
                            $assessor->assessorLanguage()->delete();
                            $assessor->delete();
                        });

                        $dataMail->reason = $request->reason;

                        event(new AAMailEvent($dataMail));

                        AppHelper::instance()->writeNotification($assessor->agency->id,'agency','Assessor Rejected',"Your Requested Assessor has been <span style='color:red;'>Rejected</span>.Kindly check your mail");
                        alert()->success("Assessor has been <span style='color:red;font-weight:bold'>Rejected</span>", "Job Done")->html()->autoclose(4000);
                    }
                    return redirect(route('admin.as.assessors'));
                }
            } else {
                alert()->error("Assessor has already been <span style='color:blue;font-weight:bold'>Approved</span>", "Done")->html()->autoclose(3000);
                return redirect(route('admin.as.assessors'));
            }
        }
    }

    // * End Assessor Approve Reject


    public function assessorApi(Request $request)
    {
        switch ($request->section) {
            case 'aadhaar':
                $data = AppHelper::instance()->checkDoc($request->checkredundancy);
                $message = 'This Aadhaar is already present';
            break;
            case 'mobile':
                $data = AppHelper::instance()->checkContact($request->checkredundancy);
                $message = 'This Mobile No is already taken';
            break;
            case 'email':
                $data = AppHelper::instance()->checkEmail($request->checkredundancy);
                $message = 'This Email is already taken';
            break;
            default:
                return abort(401);
            break;

        }
        if ($data['status']) {
            return response()->json(['success' => true]);
        } else {
            if ($data['user'] === 'assessor' && $data['userid']== $request->id) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message'=>$message]);
            }
        }
    }

    public function fetchJobrole(Request $request){
        $jobroles=DB::table('job_roles')->where('sector_id','=',$request->sector)->get(); 
        return response()->json(['jobroles' => $jobroles],200); 
    }

    public function assessorEdit($id){
        $as_id=AppHelper::instance()->decryptThis($id);
        $assessor=Assessor::findOrFail($as_id);
        $states=DB::table('state_district')->get();
        $parliaments=DB::table('parliament')->get();
        $expositories=DB::table('expositories')->get();
        $languages=DB::table('language')->get();
        $sectors=AgencySector::where('aa_id',$assessor->aa_id)->get();
        $allsector=Sector::all();
        $selJob=array();
        foreach ($assessor->assessorJob as $item){
            
            array_push($selJob,$item->job_role_id); 
         
         }


        $selLang=array();
        foreach ($assessor->assessorLanguage as $item){
            
           array_push($selLang,$item->language_id); 
        
        }
      

        return view('admin.assessors.assessor-edit')->with(compact('assessor','languages','selLang','states','parliaments','expositories','sectors','allsector','selJob'));
    }

    public function assessorUpdate(Request $request){
        
        $assessor=Assessor::findOrFail($request->as_id);
        $assessor->name=$request->name;	
        $assessor->birth=$request->birth;	
        $assessor->gender=$request->gender;	
        $assessor->religion=$request->religion;	
        $assessor->category	=$request->category;
        $assessor->d_type=$request->d_type;	
       
        if($request->hasFile('d_certificate')){
           $assessor->d_certificate = Storage::disk('myDisk')->put('/assessor', $request['d_certificate']);
            }	
        $assessor->aadhaar=$request->aadhaar;	
      
        if($request->hasFile('aadhaar_doc')){
            $assessor->aadhaar_doc = Storage::disk('myDisk')->put('/assessor', $request['aadhaar_doc']);
             }	
        $assessor->pan=$request->pan;	
       
        if($request->hasFile('pan_doc')){
            $assessor->pan_doc = Storage::disk('myDisk')->put('/assessor', $request['pan_doc']);
             }	
        $assessor->mobile=$request->mobile;	
        $assessor->email=$request->email;	
       
        if($request->hasFile('photo')){
            $assessor->photo = Storage::disk('myDisk')->put('/assessor', $request['photo']);
             }
        $assessor->applicant_cat=$request->applicant_cat;	
        $assessor->address=$request->address;	
        $assessor->post_office=$request->post_office;	
        $assessor->state_district=$request->state_district;	
        $assessor->sub_district=$request->sub_district;	
        $assessor->parliament=$request->parliament;	
        $assessor->city	=$request->city;
        $assessor->pin=$request->pin;	
        $assessor->education=$request->education;	
        $assessor->edu_details=$request->edu_details;	
        
        if($request->hasFile('edu_doc')){
            $assessor->edu_doc = Storage::disk('myDisk')->put('/assessor', $request['edu_doc']);
             }	
        $assessor->relevant_sector=$request->relevant_sector;	
        $assessor->exp_year	=$request->exp_year;
        $assessor->exp_month=$request->exp_month;	
        $assessor->exp_dtl=$request->exp_dtl;	
        $assessor->industry_dtl	=$request->industry_dtl;
        
        if($request->hasFile('exp_doc')){
            $assessor->exp_doc = Storage::disk('myDisk')->put('/assessor', $request['exp_doc']);
             }	
        if($request->hasFile('resume')){
            $assessor->resume = Storage::disk('myDisk')->put('/assessor', $request['resume']);
             }	
       if($request->hasFile('domain_doc')){
            $assessor->domain_doc = Storage::disk('myDisk')->put('/assessor', $request['domain_doc']);
             }	
        $assessor->sector_id=$request->sector;	
        $assessor->scpwd_certi_no=$request->scpwd_certi_no;	
        $assessor->certi_date=$request->certi_date;	
        $assessor->scpwd_doc=$request->scpwd_doc;	
        $assessor->certi_end_date=$request->certi_end_date;
        $assessor->save();

        AssessorJobRole::where('as_id',$request->as_id)->delete();
        AssessorLanguage::where('as_id',$request->as_id)->delete();

        foreach ($request->job_role as $value) {
            $job=new AssessorJobRole;
            $job->as_id=$assessor->id;
            $job->job_role_id=$value;
            $job->save();
        }
        foreach ($request->language as $language) {
            $languages=new AssessorLanguage;
            $languages->as_id=$assessor->id;
            $languages->language_id=$language;
            $languages->save();
        }

        /* Notification For Agency */
        $notification = new Notification;
        $notification->rel_id =$assessor->aa_id;
        $notification->rel_with = 'agency';
        $notification->title = 'Assessor has been Updated';
        $notification->message = "Assessor ID: <span style='color:blue;'>$assessor->as_id</span><br> has been <span style='color:blue;'>Updated</span>";
        $notification->save();
        /* End Notification For Agency */
        
        alert()->success("This Assessor ID <span style='color:blue;'>".$assessor->as_id."</span> has Update", 'Job Done')->html()->autoclose(3000);
        return Redirect()->back();
    }
}
