<?php

namespace App\Http\Controllers\AssessorAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use App\AssessorBatch;
use App\CandidateMark;
use App\Notification;
use App\Batch;
use App\BatchAssessment;
use Carbon\Carbon;
use Auth;
use Crypt;
use DB;

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
    
    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function batches(){

        $assessorBatch=AssessorBatch::where([['as_id','=',$this->guard()->user()->id],['verified','=',1]])->get();
      
        return view('assessor.assessor-batch')->with(compact('assessorBatch'));
    }

    public function pendingApproval(){
        $assessorBatch=AssessorBatch::where([['as_id','=',$this->guard()->user()->id],['verified','=',1]])->get();
        return view('assessor.assessor-batch-pending-approval')->with(compact('assessorBatch'));
        
    }

    public function candidateMarks($id){

        $batch=Batch::findOrFail($id);
        
        if(!$batch->status || !$batch->tpjobrole->status || Carbon::now() < Carbon::parse($batch->assessment) || !is_null($batch->batchassessment)){
            abort(404);
        }
        return view('assessor.candidate-marks')->with(compact('batch'));
    }

    public function candidateMarksInsert(Request $request){

        $batchAssessment= new BatchAssessment;
        $batchAssessment->bt_id	=$request->bt_id;

        if($request->hasFile('attendence_doc')){
            $batchAssessment->attendence_sheet = Storage::disk('myDisk')->put('/marksheet',$request->attendence_doc);
             }	
        if($request->hasFile('marksheet_doc')){
            $batchAssessment->mark_sheet = Storage::disk('myDisk')->put('/marksheet',$request->marksheet_doc);
             }	
             $batchAssessment->save();

        foreach ($request->candidate_id as $key => $value) {
            $a='remark'.($key+1);
            $candidatemark=new CandidateMark;
            $candidatemark->bt_assessment_id=$batchAssessment->id;	
            $candidatemark->candidate_id=$value;	
            $candidatemark->mark=$request->mark[$key];	
            $candidatemark->attendence=$request->attendence[$key];
            $candidatemark->passed=$request->$a;
            $candidatemark->save();
        }

        
        /* Notification For Agency */
          $batch_no=$batchAssessment->batch->batch_id;
          $notification = new Notification;
          $notification->rel_id =  $batchAssessment->batch->agencybatch->aa_id;
          $notification->rel_with = 'agency';
          $notification->title = 'Assessment Marks Submit';
          $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment marks submit by Assessor";
          $notification->save();
          /* End Notification For Agency */

       alert()->success('Marks has been Submitted wait for <span style="color:blue;font-weight:bold;"> Approved </span>', 'Job Done')->html()->autoclose(3000);
        return redirect()->route('assessor.batch');
    }

    public function candidateMarksUpdate(Request $request){
        $batchAssessment= BatchAssessment::findOrFail($request->bt_assessment_id);

        if($request->hasFile('attendence_doc')){
            $batchAssessment->attendence_sheet = Storage::disk('myDisk')->put('/marksheet',$request->attendence_doc);
             }	
        if($request->hasFile('marksheet_doc')){
            $batchAssessment->mark_sheet = Storage::disk('myDisk')->put('/marksheet',$request->marksheet_doc);
             }	
             $batchAssessment->recheck=1;
             $batchAssessment->save();

             foreach ($batchAssessment->candidateMarks as $key => $candidatemark) {
                $a='remark'.($key+1);
               
               	$candidatemark->mark=$request->mark[$key];	
                $candidatemark->attendence=$request->attendence[$key];
                $candidatemark->passed=$request->$a;
               
                $candidatemark->save();
            }

                $batch_no=$batchAssessment->batch->batch_id;
                if($batchAssessment->aa_verified==2){
                /* Notification For Agency */
                $notification = new Notification;
                $notification->rel_id =  $batchAssessment->batch->agencybatch->aa_id;
                $notification->rel_with = 'agency';
                $notification->title = 'Assessment Review & Submit';
                $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) review assessment submit by Assessor";
                $notification->save();
                /* End Notification For Agency */
                }else if($batchAssessment->admin_verified==2 || $batchAssessment->sup_admin_verified==2){
                /* Notification For Admin */
                $notification = new Notification;
                if($batchAssessment->sup_admin_verified==2){
                    
                    $notification->rel_id =2;
                }
                $notification->rel_with = 'admin';
                $notification->title = 'Assessment Review & Submit';
                $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) review assessment submit by Assessor";
                $notification->save();
                /* End Notification For Admin */
                }

            alert()->success('Marks has been Updated wait for <span style="color:blue;font-weight:bold;"> Approved </span>', 'Job Done')->html()->autoclose(3000);
            return redirect()->route('assessor.batch');

    }

    public function viewAssessment($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
       
        return view('common.view-assessment')->with(compact('batchAssessment','cc'));
    }

    public function editAssessment($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        if ($batchAssessment->aa_verified==2 || $batchAssessment->admin_verified==2 || $batchAssessment->sup_admin_verified==2){
            return view('assessor.candidate-marks-edit')->with(compact('batchAssessment'));

        }else{
            abort(404);
        }

    }
}
