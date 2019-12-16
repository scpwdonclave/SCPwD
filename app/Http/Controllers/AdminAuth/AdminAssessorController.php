<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Mail\ASConfirmationMail;
use App\Mail\ASRejectMail;
use App\Assessor;
use App\Notification;
use App\Reason;
use App\AssessorLanguage;
use App\AssessorBatch;
use App\AssessorJobRole;
use App\AgencySector;
use App\Sector;
use Auth;
use Crypt;
use DB;
use Mail;

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

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function assessor(){
        $data=Assessor::where('verified',1)->get();
        return view('admin.assessors.assessors')->with(compact('data'));
    }

    public function assessorView($id){
        $id=$this->decryptThis($id);
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

    public function pendingBatch(){
        $pending_as_batch=AssessorBatch::where('verified',0)->orderBy('id', 'desc')->get()->unique('as_id');

        return view('admin.assessors.pending-batch')->with(compact('pending_as_batch'));
    }

    public function viewBatch($id){
        $id=$this->decryptThis($id);
        $assessorBatch=AssessorBatch::where('as_id',$id)->where('verified',0)->get();
        return view('admin.assessors.pending-batch-details')->with(compact('assessorBatch'));
    }

    public function rejectBatch(Request $request){
        $data=AssessorBatch::findOrFail($request->id);
        $data['note'] = $request->note;
        // Mail::to($data->agency->email)->send(new ASRejectMail($data));

         /* Notification For Agency */
         $notification = new Notification;
         $notification->rel_id = $data->assessor->agency->id;
         $notification->rel_with = 'agency';
         $notification->title = 'Assessor Batch Rejected';
         $notification->message = "One of your Batch has been (Spoc Name: <span style='color:blue;'>Rejected</span>) ";
         $notification->save();
         /* End Notification For Agency */
         $data->delete();
         return response()->json(['status' => 'done'],200);
    }

    public function acceptBatch($id){
        $as_batch_id=$this->decryptThis($id);
        $assessor_batch=AssessorBatch::findOrFail($as_batch_id);
        $assessor_batch->verified=1;
        $assessor_batch->save();

        /* Notification For Agency */
        $notification = new Notification;
        $notification->rel_id = $assessor_batch->assessor->agency->id;
        $notification->rel_with = 'agency';
        $notification->title = 'Assessor Batch Activated';
        $notification->message = "Assessor (BATCH ID ".$assessor_batch->batch->batch_id.") has been <span style='color:blue;'>Accepted</span>.";
        $notification->save();
        /* End Notification For Agency */

        alert()->success('Assessor Batch has been Activated', 'Job Done')->autoclose(3000);
        return Redirect()->back();
    }

    public function assessorDeactive(Request $request){

        $assessor=Assessor::findOrFail($request->id);
        $assessor->status=0;
        $assessor->save(); 

        $reason = new Reason;
        $reason->rel_id = $assessor->id;
        $reason->rel_with = 'assessor';
        $reason->reason = $request->reason;
        $reason->save();

        /* Notification For Partner */
        $notification = new Notification;
        $notification->rel_id = $assessor->aa_id;
        $notification->rel_with = 'agency';
        $notification->title = 'assessor Deactivated';
        $notification->message = "assessor (ID $assessor->as_id) has been <span style='color:blue;'>Deactivated</span>.";
        $notification->save();
        /* End Notification For Partner */

        return response()->json(['status' => 'done'],200);
    }

    public function assessorActive($id){
        
        $as_id=$this->decryptThis($id);
        $assessor=Assessor::findOrFail($as_id);
        $assessor->status=1;
        $assessor->save();

        /* Notification For Partner */
        $notification = new Notification;
        $notification->rel_id = $assessor->aa_id;
        $notification->rel_with = 'agency';
        $notification->title = 'Assessor Activated';
        $notification->message = "Assessor (ID $assessor->as_id) has been <span style='color:blue;'>Activated</span>.";
        $notification->save();
        /* End Notification For Partner */

        alert()->success('Assessor has been Activated', 'Job Done')->autoclose(3000);
        return Redirect()->back();
    }

    public function assessorAccept($id){
        
        $id=$this->decryptThis($id);
        $assessor=Assessor::findOrFail($id);
        if($assessor->verified==1){
            alert()->error("This Assessor already <span style='color:blue;'>Approved</span>", "Done")->html()->autoclose(2000);
            return Redirect()->back(); 
        }
        $data=DB::table('assessors')
        ->select(\DB::raw('SUBSTRING(as_id,3) as as_id'))
        ->where("as_id", "LIKE", "AS%")->get();
       // dd(count($data));
        $year = date('Y');
        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->as_id;
                }
                $lastid= max($priceprod);
               
                $new_asid = (substr($lastid, 0, 4)== $year) ? 'AS'.($lastid + 1) : 'AS'.$year.'000001' ;
            //dd($new_tpid);
        } else {
            $new_asid = 'AS'.$year.'000001';
        }

        $assessor_password = str_random(8);
        $assessor->as_id=$new_asid;
        $assessor->password=Hash::make($assessor_password);
        $assessor->verified=1;
        $assessor->save();

          /* Notification For Agency */
          $notification = new Notification;
          $notification->rel_id = $assessor->aa_id;
          $notification->rel_with = 'agency';
          $notification->title = 'Assessor has been Approved';
          $notification->message = "assessor <br>(ID: <span style='color:blue;'>$new_asid</span>) has been Approved";
          $notification->save();
          /* End Notification For Agency */
          $assessor['password']=$assessor_password;
          Mail::to($assessor->email)->send(new ASConfirmationMail($assessor));

          alert()->success('Assessor has been Approved', 'Job Done')->autoclose(3000);
          return Redirect()->back();

    }

    public function fetchJobrole(Request $request){
        $jobroles=DB::table('job_roles')->where('sector_id','=',$request->sector)->get(); 
        return response()->json(['jobroles' => $jobroles],200); 
    }

    public function assessorReject(Request $request){
        $data=Assessor::findOrFail($request->id);
        $data['note'] = $request->note;
         Mail::to($data->agency->email)->send(new ASRejectMail($data));
         /* Notification For Agency */
         $notification = new Notification;
         $notification->rel_id = $data->aa_id;
         $notification->rel_with = 'agency';
         $notification->title = 'Assessor Rejected';
         $notification->message = "One of your Assessor has been (Spoc Name: <span style='color:blue;'>Rejected</span>) ";
         $notification->save();
         /* End Notification For Agency */
         AssessorLanguage::where('as_id',$request->id)->delete();
         AssessorJobRole::where('as_id',$request->id)->delete();
         
         $data->delete();
         return response()->json(['status' => 'done'],200);
    }

    public function assessorEdit($id){
        $as_id=$this->decryptThis($id);
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
