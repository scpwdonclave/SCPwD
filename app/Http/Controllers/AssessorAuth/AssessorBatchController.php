<?php

namespace App\Http\Controllers\AssessorAuth;

use DB;
use Auth;
use Crypt;
use App\Batch;
use Carbon\Carbon;
use App\Notification;
use App\AssessorBatch;
use App\Reassessment;
use App\CandidateMark;
use App\CandidateReMark;
use App\BatchAssessment;
use App\BatchReAssessment;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class AssessorBatchController extends Controller
{
    public function __construct()
    {
        $this->middleware(['assessor','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('assessor');
    }

    public function batches(){

        $assessorBatch=AssessorBatch::where('as_id','=',$this->guard()->user()->id)->get();
        $assessorReBatch = Reassessment::where('as_id',$this->guard()->user()->id)->get();
        return view('assessor.assessor-batch')->with(compact('assessorBatch','assessorReBatch'));
    }


    public function viewAssessmentBatch(Request $request)
    {
        if ($data=AppHelper::instance()->decryptThis($request->id)) {

            // * $data will consist of Batch/ReAssessment id and second parameter pointing the tables [1 for Assessment, 2 for ReAssessment]
            $id = explode(',',$data);
            $center_candidates = collect();

            if ($id[1]) {

                // * Request for Assessment Model

                $assessment_tag = 'Assessment';
                $batchData=Batch::findOrFail($id[0]);
                $assessment_date = $batchData->assessment;
                
                if ($batchData->assessorbatch->assessor->id != $this->guard()->user()->id) {
                    return abort(403, 'You are Not Authorized for This Action');
                }
                
                $assessor = $batchData->assessorbatch->assessor->name .' ('.$batchData->assessorbatch->assessor->as_id.')';
                
                foreach ($batchData->candidatesmap as $candidate) {
                    if ($batchData->batchassessment) {
                        if ($candidate->centercandidate->candidateMark->attendence==='present') {
                            $candidate->centercandidate->quilified = $candidate->centercandidate->candidateMark->passed;
                        } else {
                            $candidate->centercandidate->quilified = 2;
                        }
                    } else {
                        $candidate->centercandidate->quilified = null;
                    }
                    $center_candidates->push($candidate->centercandidate);
                }
            } else {
                
                // * Request for Re-Assessment Model

                $assessment_tag = 'Re-Assessment';
                $reassessment=Reassessment::findOrFail($id[0]);
                $assessment_date = $reassessment->assessment;
                $batchData = $reassessment->batch;

                if ($reassessment->as_id != $this->guard()->user()->id) {
                    return abort(403, 'You are Not Authorized for This Action');
                }
                
                $assessor = $reassessment->assessor->name .' ('.$reassessment->assessor->as_id.')';
                

                foreach ($reassessment->candidates as $candidate) {
                    if ($candidate->appear) {

                        if ($reassessment->batchreassessment) {
                            if ($candidate->candidateMark->attendence==='present') {
                                $candidate->centercandidate->quilified = $candidate->candidateMark->passed;
                            } else {
                                $candidate->centercandidate->quilified = 2;
                            }
                        } else {
                            $candidate->centercandidate->quilified = null;
                        }
                        $center_candidates->push($candidate->centercandidate);
                    }
                }
                
            } 
            
            return view('common.view-batch-assessment')->with(compact('assessor','assessment_tag','center_candidates','assessment_date','batchData'));
        }
    }




    public function assessmentStatus(){
        $assessorBatch=AssessorBatch::where([['as_id',$this->guard()->user()->id],['reass_id',NULL]])->get();
        return view('assessor.assessment-status')->with(compact('assessorBatch'));
    }

    public function candidateMarks($id){
        
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $batch=Batch::findOrFail($id);
            
            if(!$batch->status || !$batch->tpjobrole->status || Carbon::now() < Carbon::parse($batch->assessment) || !is_null($batch->batchassessment)){
                abort(404);
            }
            return view('assessor.candidate-marks')->with(compact('batch')); 
            
        }
    }


    public function candidateReMarks(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $reassessment = Reassessment::findOrFail($id);
            if (is_null($reassessment->batchreassessment)) {
                return view('assessor.candidate-re-marks')->with(compact('reassessment'));
            }
        }
    }


    public function candidateMarksInsert(Request $request){
        // dd($request);
        $batchassesst = BatchAssessment::where('bt_id', $request->bt_id)->first();
        if ($batchassesst) {
            alert()->info("Records have Already been <span style='font-weight:bold;color:blue'>Submitted</span> for Review", 'Attention')->html()->autoclose(4000);
            return redirect()->route('assessor.batch');
        } else {
            $batchAssessment= new BatchAssessment;
            $batchAssessment->bt_id	=$request->bt_id;
    
            if($request->hasFile('attendence_doc')){
               
                $batchAssessment->attendence_sheet = Storage::disk('myDisk')->put('/marksheet',$request->attendence_doc);
            }	
            if($request->hasFile('marksheet_doc')){
                $batchAssessment->mark_sheet = Storage::disk('myDisk')->put('/marksheet',$request->marksheet_doc);
            }

            $batchAssessment->f_month=date('F');
            $batchAssessment->f_year=( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');
            
            $batchAssessment->save();

            foreach ($request->candidate_id as $key => $value) {
                $a='remark'.($key+1);
                $candidatemark=new CandidateMark;
                $candidatemark->bt_assessment_id=$batchAssessment->id;	
                $candidatemark->candidate_id=$value;
                if($request->mark[$key]===null){
                    $candidatemark->mark=0;	 
                }else{
                    $candidatemark->mark=$request->mark[$key];	
                }	
                $candidatemark->attendence=$request->attendence[$key];
                if($request->$a===null){
                    $candidatemark->passed=0;    
                }else{
                    $candidatemark->passed=$request->$a;
                }
                $candidatemark->save();
            }
            $batch_no=$batchAssessment->batch->batch_id;
            $assessor = $this->guard()->user()->as_id;
            AppHelper::instance()->writeNotification($batchAssessment->batch->agencybatch->aa_id,'agency','Assessment Marks Submitted',"Assessor (ID: <span style='color:blue;'>$assessor</span>) has submitted Batch (ID: <span style='color:blue;'>$batch_no</span>) Marks", route('agency.assessment.view',Crypt::encrypt($batchAssessment->id)));

            alert()->success("Marks are Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified", 'Job Done')->html()->autoclose(8000);
            return redirect()->route('assessor.batch');
        }
    }

    // * Update Candidate Assessment & Re-Assessment Marks

    public function candidateMarksUpdate(Request $request){

        // ? $request->assessment_type [1 Assessmnt : 0 Re-Assessment]
        
        $type=AppHelper::instance()->decryptThis($request->assessment_type);
        if ($type) {
            // * Request For Assessment
            $assessment= BatchAssessment::findOrFail(AppHelper::instance()->decryptThis($request->bt_assessment_id));
            
        } else {
            // * Request For Re-Assessment
            $assessment= BatchReAssessment::findOrFail(AppHelper::instance()->decryptThis($request->bt_assessment_id));

        }

        

        if($request->hasFile('attendence_doc')){
            $assessment->attendence_sheet = Storage::disk('myDisk')->put('/marksheet',$request->attendence_doc);
        }	
        if($request->hasFile('marksheet_doc')){
            $assessment->mark_sheet = Storage::disk('myDisk')->put('/marksheet',$request->marksheet_doc);
        }	
        $assessment->recheck=1;
        $assessment->save();

        foreach ($assessment->candidateMarks as $key => $candidatemark) {
            $a='remark'.($key+1);
            if($request->mark[$key]===null){
                $candidatemark->mark=0;	
            }else{
                $candidatemark->mark=$request->mark[$key];	
            }
                //$candidatemark->mark=$request->mark[$key];	
            $candidatemark->attendence=$request->attendence[$key];
            if($request->$a===null){
                $candidatemark->passed=0;
            }else{
                $candidatemark->passed=$request->$a;
            }
            //$candidatemark->passed=$request->$a;
            
            $candidatemark->save();
        }

        $batch_no=$assessment->batch->batch_id;
        if($assessment->aa_verified==2){
            AppHelper::instance()->writeNotification($type?$assessment->batch->agencybatch->aa_id:$assessment->reassessment->aa_id,'agency',($type?'Assessment':'Reassessment').' Reviewed & Re-Submitted',"Batch (ID: <span style='color:blue;'>$batch_no</span>) marks reviewed & resubmitted by Assessor, Kindly <span style='color:blue;'>Accept</span> or <span style='color:red;'>Reject</span>", route('agency.reassessment.view',Crypt::encrypt($assessment->id)));
        }else if($assessment->admin_verified==2){
            AppHelper::instance()->writeNotification(0,'admin',($type?'Assessment':'Reassessment').' Reviewed & Re-Submitted',"Batch (ID: <span style='color:blue;'>$batch_no</span>) marks reviewed & resubmitted by Assessor, Kindly <span style='color:blue;'>Accept</span> or <span style='color:red;'>Reject</span>", $type?route('admin.assessment.view',Crypt::encrypt($assessment->id)):route('admin.reassessment.reassessment-status.view',Crypt::encrypt($assessment->id)));
        } elseif ($assessment->sup_admin_verified==2) {
            AppHelper::instance()->writeNotification(1,'admin',($type?'Assessment':'Reassessment').' Reviewed & Re-Submitted',"Batch (ID: <span style='color:blue;'>$batch_no</span>) marks reviewed & resubmitted by Assessor, Kindly <span style='color:blue;'>Accept</span> or <span style='color:red;'>Reject</span>", $type?route('admin.assessment.view',Crypt::encrypt($assessment->id)):route('admin.reassessment.reassessment-status.view',Crypt::encrypt($assessment->id)));
        }

        alert()->success("Marks are Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified", 'Job Done')->html()->autoclose(8000);
        return redirect()->route('assessor.batch');            
        

    }

    // * End Update Candidate Assessment & Re-Assessment Marks


    public function viewAssessment(Request $request){
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchAssessment=BatchAssessment::findOrFail($id);
            if ($this->guard()->user()->id == $batchAssessment->batch->assessorBatch->as_id) {
                return view('common.view-assessment')->with(compact('batchAssessment'));
            } else {
                return abort(403, 'You are Not Authorized for this Action');
            }
        }
    }

    public function editAssessment($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $assessment=BatchAssessment::findOrFail($id);
            if ($assessment->aa_verified==2 || $assessment->admin_verified==2 || $assessment->sup_admin_verified==2){
                $type=Crypt::encrypt('1');
                return view('assessor.candidate-marks-edit')->with(compact('assessment','type'));
                
            }else{
                abort(404);
            }
        }
            
    }
    public function editReAssessment($id){
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $assessment=BatchReAssessment::findOrFail($id);
            if ($assessment->aa_verified==2 || $assessment->admin_verified==2 || $assessment->sup_admin_verified==2){
                $type=Crypt::encrypt('0');
                return view('assessor.candidate-marks-edit')->with(compact('assessment','type'));
            }else{
                abort(404);
            }
        }
    }


    public function candidateReMarksInsert(Request $request)
    {
       
        $batchreassesst = BatchReAssessment::where('bt_reassid', $request->reassid)->first();
        if ($batchreassesst) {
            alert()->info("Records have Already been <span style='font-weight:bold;color:blue'>Submitted</span> for Review", 'Attention')->html()->autoclose(4000);
            return redirect()->route('assessor.batch');
        } else {
            $batchReAssessment= new BatchReAssessment;
            $batchReAssessment->bt_reassid = $request->reassid;
            $batchReAssessment->bt_id = $request->bt_id;
    
            if($request->hasFile('attendence_doc')){
                $batchReAssessment->attendence_sheet = Storage::disk('myDisk')->put('/marksheet',$request->attendence_doc);
            }	
            if($request->hasFile('marksheet_doc')){
                $batchReAssessment->mark_sheet = Storage::disk('myDisk')->put('/marksheet',$request->marksheet_doc);
            }

            $batchReAssessment->f_month=date('F');
            $batchReAssessment->f_year=( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');
            
            $batchReAssessment->save();

            foreach ($request->candidate_id as $key => $value) {
                $a='remark'.($key+1);
                $candidateremark=new CandidateReMark;
                $candidateremark->reass_candidate_id=$request->reass_candidate_id[$key];
                $candidateremark->bt_reassessment_id=$batchReAssessment->id;
                $candidateremark->candidate_id=$value;
                if($request->mark[$key]==null){
                    $candidateremark->mark=0;	 
                        }else{
                    $candidateremark->mark=$request->mark[$key];	
                        }	
                $candidateremark->attendence=$request->attendence[$key];
                if($request->$a===null){
                    $candidateremark->passed=0;
    
                }else{
                    $candidateremark->passed=$request->$a;
                }
                $candidateremark->save();
            }
            $batch_no=$batchReAssessment->reassessment->batch->batch_id;
            $assessor = $this->guard()->user()->as_id;
            $batch_no = $batchReAssessment->reassessment->batch->batch_id;
            AppHelper::instance()->writeNotification($batchReAssessment->reassessment->aa_id,'agency','Re-Assessment Marks Submitted',"Assessor (ID: <span style='color:blue;'>$assessor</span>) has submitted Batch (ID: <span style='color:blue;'>$batch_no</span>) Marks", route('agency.reassessment.view',Crypt::encrypt($batchReAssessment->id)));

            alert()->success("Marks are Submitted for Review, Once <span style='font-weight:bold;color:blue'>Approved</span> or <span style='font-weight:bold;color:red'>Rejected</span> you will get Notified", 'Job Done')->html()->autoclose(8000);
            return redirect()->route('assessor.batch');
        }
    }

    public function reAssessments()
    {
        $allreassessments = Reassessment::where('as_id', $this->guard()->user()->id)->get();
        $reassessments = collect();
        foreach ($allreassessments as $reass) {
            if($reass->batchreassessment){
                $reassessments->push($reass);
            }
        }
        return view('assessor.reassessment-status')->with(compact('reassessments'));

    }

    public function viewReAssessment(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $batchReAssessment = BatchReAssessment::findOrFail($id);
            if ($this->guard()->user()->id == $batchReAssessment->reassessment->as_id) {
                return view('common.view-reassessment-marks')->with(compact('batchReAssessment'));
            } else {
                return abort(403, 'You are not Authorized for This Action');
            }
        }
    }

}
