<?php

namespace App\Http\Controllers\AgencyAuth;

use DB;
use Auth;
use Crypt;
use App\Batch;
use Validator;
use App\Sector;
use App\Assessor;
use Carbon\Carbon;
use App\AgencyBatch;
use App\AgencySector;
use App\AssessorBatch;
use App\AssessorJobRole;
use App\AssessorLanguage;
use App\Helpers\AppHelper;
use App\Events\ASMailEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ASFormValidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class AgencyAssessorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['agency','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('agency');
    }

    protected function partnerstatus($batch){
        if ($batch->partner->status && $batch->tpjobrole->status) {
            return true;
        } else {
            return false;
        }
    }

    public function assessor(){

        $data=Assessor::where('aa_id',$this->guard()->user()->id)->get();
        
        return view('agency.assessor')->with(compact('data'));
    }

    public function addAssessor(){

        $states=DB::table('state_district')->get();
        $parliaments=DB::table('parliament')->get();
        $languages=DB::table('language')->get();
        $expositories=DB::table('expositories')->get();
        $sectors=AgencySector::where('aa_id',$this->guard()->user()->id)->get();
        $allsector=Sector::all();
        
        return view('agency.addassessor')->with(compact('languages','expositories','sectors','allsector','states','parliaments'));
    }

    public function fetchJobrole(Request $request){
        $jobroles=DB::table('job_roles')->where('sector_id','=',$request->sector)->get(); 
        return response()->json(['jobroles' => $jobroles],200); 
    }

    public function assessorInsert(ASFormValidation $request){
        $assessor=new Assessor;
        $assessor->aa_id=$this->guard()->user()->id;	
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
        $assessor->industry_dtl=$request->industry_dtl;
        $assessor->domain_certi_end_date=$request->domain_certi_end_date;
        
        if($request->hasFile('exp_doc')){
            $assessor->exp_doc = Storage::disk('myDisk')->put('/assessor', $request['exp_doc']);
        }	
        if($request->hasFile('resume')){
            $assessor->resume = Storage::disk('myDisk')->put('/assessor', $request['resume']);
        }
        
        $assessor->domain_doc = Storage::disk('myDisk')->put('/assessor', $request['domain_doc']);
        	
        $assessor->sector_id=$request->sector;	
        $assessor->scpwd_certi_no=$request->scpwd_certi_no;	
        $assessor->certi_date=$request->certi_date;	
        $assessor->scpwd_doc=$request->scpwd_doc;	
        $assessor->scpwd_doc = Storage::disk('myDisk')->put('/assessor', $request['scpwd_doc']);
        $assessor->certi_end_date=$request->certi_end_date;
        $assessor->save();

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
        $aaid = $this->guard()->user()->aa_id;
        AppHelper::instance()->writeNotification(NULL,'admin','New Assessor Added',"Agency <br>(ID: <span style='color:blue;'>$aaid</span>) has added an <span style='color:blue;'>Assessor</span>. Pending Approval", route('admin.as.assessor.view', Crypt::encrypt($assessor->id)));
        
        alert()->success("Assessor data has Been Submitted for Review, Once <span style='color:blue'>Approved</span> or <span style='color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(5000);     
        return redirect()->back();
    }

    public function assessorView($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $assessorData=Assessor::findOrFail($id);
            if($assessorData->aa_id != $this->guard()->user()->id){
                abort(404);
            }
            $assessorState=DB::table('assessors')
            ->join('state_district','assessors.state_district','=','state_district.id')
            ->join('parliament','assessors.parliament','=','parliament.id')
            ->first();
            $language=DB::table('assessor_languages')
            ->join('language','language.id','=','assessor_languages.language_id')
            ->where('assessor_languages.as_id',$id)->get();
            return view('common.view-assessor')->with(compact('assessorData','language','assessorState'));
        }
    }

    public function viewBatch($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            return view('common.view-batch')->with(compact('batchData'));
        }
    }

    public function assessorApi(Request $request){

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
            return response()->json(['success' => false, 'message'=>$message]);
        }

    }


    public function assessorBatch($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $assessor=Assessor::findOrFail($id);
            if(!$assessor->status || !$assessor->verified || $assessor->aa_id != $this->guard()->user()->id){
                abort(404);
            }
            return view('agency.assessor-batch')->with(compact('assessor'));
        }
    }

    public function assessorFetchBatch(Request $request){
        $agencyBatch=AgencyBatch::where([['aa_id',$this->guard()->user()->id],['aa_verified','=',1]])->get();
        $assessorBatch=AssessorBatch::all();

        $selBatch=array();
        foreach ($assessorBatch as $value) {
            array_push($selBatch,$value->aa_bt_id); 
        }

        $batch=array();
        $aa_batch=array();
        foreach ($agencyBatch as $batches) {
            $batchind= $batches->batch;
            if($batchind->jobrole_id==$request->job && $batchind->status && $batchind->verified  && $this->partnerstatus($batchind)){ //&& (Carbon::parse($batchind->batch_end.' 23:59') > Carbon::now())--remove
                array_push($batch,$batchind); 
                array_push($aa_batch,$batches); 
                }
            }
        
        return response()->json(['batch' => $batch,'aa_batch'=>$aa_batch,'selbatch'=>$selBatch],200);
    }

    public function assessorBatchInsert(Request $request){
        $assessor = Assessor::find($request->as_id);
        
        if (Carbon::now() <= Carbon::parse($assessor->domain_certi_end_date) && Carbon::now() <= Carbon::parse($assessor->certi_end_date)) {
            
            foreach ($request->batch as $batch) {
                
                $ex_bt=explode(',', $batch);
                $assessorBatch=new AssessorBatch;
                $assessorBatch->as_id=$request->as_id;
                $assessorBatch->bt_id=$ex_bt[0];
                $route_parameter = $ex_bt[0];
                if($ex_bt[1] != 'null'){
                    
                    $assessorBatch->reass_id=$ex_bt[1];
                    $assessorBatch->reassessment->as_id =  $request->as_id;
                    $assessorBatch->reassessment->save();
                    $route_parameter = $ex_bt[1];
    
                }
                $assessorBatch->aa_bt_id=$ex_bt[2];
    
                $assessorBatch->save();
            }
    
    
            $dataMail = collect();
            $dataMail->tag = 'btassignremove';
            $dataMail->status = 1;
            $dataMail->name = $assessor->name;
            $dataMail->email = $assessor->email;
            event(new ASMailEvent($dataMail));
    
            AppHelper::instance()->writeNotification($request->as_id,'assessor','New Batch(es) Assigned',"Batch(es) are <span style='color:blue;'>assigned</span> to you by your Assessment Agency.", route('assessor.batch'));
    
            alert()->success("Batch(es) are <span style='color:blue;'>Assigned</span> to this Assessor", 'Job Done')->html()->autoclose(4000);
            return redirect()->back();
            
        } else {
            alert()->error("Assessor Certificate(s) has <span style='color:red;'>Expired</span> Kindly <span style='color:blue;'>Renew</span> them first", 'Attention')->html()->autoclose(5000);
            return redirect()->back();
        }

    }

    public function removeBatch(Request $request){

        $assessorBatch=AssessorBatch::findOrFail($request->id);

        $batch_no=$assessorBatch->batch->batch_id;
        $dataMail = collect();
        $dataMail->tag = 'btassignremove';
        $dataMail->status = 0;
        $dataMail->name = $assessorBatch->assessor->name;
        $dataMail->bt_id = $assessorBatch->batch->batch_id;
        $dataMail->email = $assessorBatch->assessor->email;

        if (is_null($assessorBatch->batch->batchassessment)) {
            event(new ASMailEvent($dataMail));
            AppHelper::instance()->writeNotification($assessorBatch->as_id,'assessor',"Batch Revoked By Agency","A Batch (ID: <span style='color:blue;'>$batch_no</span>) has been revoked by your <span style='color:blue;'>Agency</span>.", route('assessor.batch'));
            $assessorBatch->delete();
            return response()->json(["status" => true],200);
        } else {
            return response()->json(["status" => false ],200);
        }
        
    }

}
