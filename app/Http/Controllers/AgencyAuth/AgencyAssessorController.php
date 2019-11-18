<?php

namespace App\Http\Controllers\AgencyAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\AgencySector;
use App\Notification;
use App\Assessor;
use App\AssessorJobRole;
use App\AssessorLanguage;
use App\Sector;
use Validator;
use Auth;
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

    public function assessor(){

        $data=Assessor::all();
        return view('agency.assessor')->with(compact('data'));
    }

    public function addAssessor(){

        $states=DB::table('state_district')->get();
        $parliaments=DB::table('parliament')->get();
        $languages=DB::table('language')->get();
        $expositories=DB::table('expositories')->get();
        $sectors=AgencySector::where([['aa_id','=',$this->guard()->user()->id],['status','=',1]])->get();
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
         $notification->rel_id =1;
         $notification->rel_with = 'admin';
         $notification->title = 'Assessor has been Register';
         $notification->message = "One assessor <br>has been <span style='color:blue;'>Register</span>";
         $notification->save();
         /* End Notification For Admin */
        
        alert()->success('Assessor has been Registered wait for Approved', 'Job Done')->autoclose(3000);
        return Redirect()->back();

    }

    public function assessorView($id){
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

}
