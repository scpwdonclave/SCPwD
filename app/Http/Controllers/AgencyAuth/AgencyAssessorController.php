<?php

namespace App\Http\Controllers\AgencyAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use App\AgencySector;
use App\AgencyBatch;
use App\Notification;
use App\Assessor;
use App\AssessorJobRole;
use App\AssessorBatch;
use App\AssessorLanguage;
use App\Sector;
use App\Batch;
use Validator;
use Auth;
use Crypt;
use DB;

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

    public function assessorInsert(Request $request){
       // dd($request);
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

         /* Notification For Admin */
         $notification = new Notification;
         //$notification->rel_id =1;
         $notification->rel_with = 'admin';
         $notification->title = 'Assessor has been Register';
         $notification->message = "One assessor has been <span style='color:blue;'>Register</span>";
         $notification->save();
         /* End Notification For Admin */
         alert()->success("Assessor data has Been Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(8000);     
         return Redirect()->back();

    }

    public function assessorView($id){
        $id=$this->decryptThis($id);
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

    public function viewBatch($id){
        if ($id=$this->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            return view('common.view-batch')->with(compact('batchData'));
        }
    }

    // public function assessorApi(Request $request){

    //     if ($request->section=='mobile') {
    //         if($request->has('aa_id')){
    //         $validator = Validator::make($request->all(), [ 
              
    //             'checkredundancy' => [
    //                 'required',
    //                 'numeric',
    //                 'unique:trainers,mobile',
    //                 'unique:partners,spoc_mobile',
    //                 'unique:centers,mobile',
    //                 'unique:trainer_statuses,mobile',
    //                 'unique:agencies,mobile',
    //                 'unique:assessors,mobile,'.$request->as_id,
                    
    //             ],
    //         ]);
    //         }else{
    //             $validator = Validator::make($request->all(), [ 
              
    //                 'checkredundancy' => [
    //                     'required',
    //                     'numeric',
    //                     'unique:trainers,mobile',
    //                     'unique:partners,spoc_mobile',
    //                     'unique:centers,mobile',
    //                     'unique:trainer_statuses,mobile',
    //                     'unique:agencies,mobile',
    //                     'unique:assessors,mobile',
                        
    //                 ],
    //             ]); 
    //         }

    //         if ($validator->fails()) {
    //             return response()->json(['success' => false, 'errors'=>$validator->errors()]);
    //         } else {
    //             return response()->json(['success' => true], 200);
    //         }
        
    //     }
    //     else if ($request->section=='email') {
    //         if($request->has('aa_id')){
    //         $validator = Validator::make($request->all(), [ 
              
    //             'checkredundancy' => [
    //                 'required',
    //                 'unique:trainers,email',
    //                 'unique:partners,email',
    //                 'unique:centers,email',
    //                 'unique:trainer_statuses,email',
    //                 'unique:agencies,email',
    //                 'unique:assessors,email,'.$request->aa_id,
    //             ],
    //         ]);
            
    //         }else{
    //             $validator = Validator::make($request->all(), [ 
              
    //                 'checkredundancy' => [
    //                     'required',
    //                     'unique:trainers,email',
    //                     'unique:partners,email',
    //                     'unique:centers,email',
    //                     'unique:trainer_statuses,email',
    //                     'unique:agencies,email',
    //                     'unique:assessors,email',
    //                 ],
    //             ]);
    //         }

    //         if ($validator->fails()) {
    //             return response()->json(['success' => false, 'errors'=>$validator->errors()]);
    //         } else {
    //             return response()->json(['success' => true], 200);
    //         }
        
    //     }
    //     else if ($request->section=='aadhaar') {
    //         if($request->has('aa_id')){
    //         $validator = Validator::make($request->all(), [ 
    //            'checkredundancy' => [
    //                 'required',
    //                 'unique:trainers,doc_no',
    //                 'unique:trainer_statuses,doc_no',
    //                 'unique:agencies,aadhaar',
    //                 'unique:assessors,aadhaar,'.$request->aa_id,
                    
    //             ],
    //         ]);
                
    //         }else{
    //             $validator = Validator::make($request->all(), [ 
    //                 'checkredundancy' => [
    //                      'required',
    //                      'unique:trainers,doc_no',
    //                      'unique:trainer_statuses,doc_no',
    //                      'unique:agencies,aadhaar',
    //                      'unique:assessors,aadhaar',
                         
    //                  ],
    //              ]);
    //         }

    //         if ($validator->fails()) {
    //             return response()->json(['success' => false, 'errors'=>$validator->errors()]);
    //         } else {
    //             return response()->json(['success' => true], 200);
    //         }
        
    //     }
    // }

    public function assessorBatch($id){
        $id=$this->decryptThis($id);
        $assessor=Assessor::findOrFail($id);
        if(!$assessor->status || !$assessor->verified || $assessor->aa_id != $this->guard()->user()->id){
            abort(404);
        }
        return view('agency.assessor-batch')->with(compact('assessor'));


    }

    public function assessorFetchBatch(Request $request){
        $agencyBatch=AgencyBatch::where([['aa_id',$this->guard()->user()->id],['aa_verified','=',1]])->get();
        $assessorBatch=AssessorBatch::all();

        $selBatch=array();
        foreach ($assessorBatch as $value) {
            array_push($selBatch,$value->batch->id); 
        }

        $batch=array();
        foreach ($agencyBatch as  $batches) {
            $batchind= $batches->batch;
            if($batchind->jobrole_id==$request->job && $batchind->status && $batchind->verified && !$batchind->completed && $this->partnerstatus($batchind))
            array_push($batch,$batchind); 
        }
        
        return response()->json(['batch' => $batch,'selbatch'=>$selBatch],200);
    }

    public function assessorBatchInsert(Request $request){
        foreach ($request->batch as $batch) {
            $agencyBatch=new AssessorBatch;
            $agencyBatch->as_id=$request->as_id;
            $agencyBatch->bt_id=$batch;
            $agencyBatch->save();
         }

          /* Notification For Assessor */
        
        $notification = new Notification;
        $notification->rel_id = $request->as_id;
        $notification->rel_with = 'assessor';
        $notification->title = 'New Batch Added';
        $notification->message = "New Batch added by Agency";
        $notification->save();
        /* End Notification For Assessor */

         alert()->success("Batch has been <span style='color:blue;font-weight:bold'>Added</span> with Assessor", 'Job Done')->html()->autoclose(3000);
         return Redirect()->back();

    }

    public function deleteBatch(Request $request){
        $assessorBatch=AssessorBatch::findOrFail($request->id);

        /* Notification For Assessor */
        $batch_no=$assessorBatch->batch->batch_id;
        $notification = new Notification;
        $notification->rel_id = $assessorBatch->as_id;
        $notification->rel_with = 'assessor';
        $notification->title = 'Batch cancelled by Agency';
        $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment cancelled by Agency";
        $notification->save();
        /* End Notification For Assessor */

            
           // return response()->json(['status' => 'done'],200);


            // $data=Department::findOrFail($request->id);
            // $scheme=Scheme::where('dept_id',$request->id)->first();
             if(!is_null($assessorBatch->batch->batchassessment)){
                 return response()->json(['status' => 'fail'],200);
            
             }else{
                $assessorBatch->delete(); 
                 return response()->json(['status' => 'done'],200);
     
             }

        
    }

}
