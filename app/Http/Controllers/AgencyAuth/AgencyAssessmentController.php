<?php

namespace App\Http\Controllers\AgencyAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use App\AgencyBatch;
use App\BatchAssessment;
use App\Notification;
use App\Reason;
use Auth;
use Crypt;

class AgencyAssessmentController extends Controller
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

    public function pendingAssessmentApproval(){
        $agencyBatch=AgencyBatch::where('aa_id',$this->guard()->user()->id)->get();

        return view('agency.assessment-approval')->with(compact('agencyBatch'));
        
    }

    public function allAssessment(){
        $agencyBatch=AgencyBatch::where('aa_id',$this->guard()->user()->id)->get();

        return view('agency.all-assessment')->with(compact('agencyBatch'));
    }

    public function assessmentView($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        return view('common.view-assessment')->with(compact('batchAssessment'));

    }

    public function assessmentAccept($id){
        $id= $this->decryptThis($id);
        $batchAssessment=BatchAssessment::findOrFail($id);
        if($batchAssessment->aa_verified==0 || ($batchAssessment->aa_verified==2 && $batchAssessment->recheck==1)){
        $batchAssessment->aa_verified=1;
        $batchAssessment->recheck=0;
        $batchAssessment->reject_note=null;
        $batchAssessment->save();

        
        /* Notification For Admin */
        $batch_no=$batchAssessment->batch->batch_id;
        $notification = new Notification;
        $notification->rel_with = 'admin';
        $notification->title = 'Assessment Approved by Agency';
        $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment approved by Agency";
        $notification->save();
        /* End Notification For Admin */

        alert()->success("Assessment has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(3000);
         return Redirect()->back();
        }else{
            abort(404);
        }
    }

    public function assessmentReject(Request $request){
        $batchAssessment=BatchAssessment::findOrFail($request->id);
        $batchAssessment->aa_verified=2;
        $batchAssessment->reject_note=$request->note;
        $batchAssessment->save();

         /* Notification For Assessor */
         $batch_no=$batchAssessment->batch->batch_id;
         $notification = new Notification;
         $notification->rel_id = $batchAssessment->batch->assessorbatch->as_id;
         $notification->rel_with = 'assessor';
         $notification->title = 'Assessment Rejected by Agency';
         $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) assessment rejected by Agency";
         $notification->save();
         /* End Notification For Assessor */

        return response()->json(['success' => true], 200);
    }

    public function myBatch(){
        $agencyBatch=AgencyBatch::where([['aa_id','=',$this->guard()->user()->id],['aa_verified','=',1]])->get();
        return view('agency.batch')->with(compact('agencyBatch'));


    }
    public function myPendingBatch(){
        $agencyBatch=AgencyBatch::where([['aa_id','=',$this->guard()->user()->id],['aa_verified','=',0]])->get();
        return view('agency.agency-pending-batch')->with(compact('agencyBatch'));
        }

    public function pendingBatchApproved($id){
        $id= $this->decryptThis($id);
        $agency_batch=AgencyBatch::findOrFail($id);
        $agency_batch->aa_verified=1;
        $agency_batch->save();

         /* Notification For Admin */
         $batch_no=$agency_batch->batch->batch_id;
         $notification = new Notification;
         $notification->rel_with = 'admin';
         $notification->title = 'Batch Accept by Agency';
         $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) accept by Agency";
         $notification->save();
         /* End Notification For Admin */
         alert()->success("Batch ID: <span style='color:blue;font-weight:bold'>$batch_no</span> has been <span style='color:blue;font-weight:bold'>Accepted</span>", 'Job Done')->html()->autoclose(3000);
         return Redirect()->back();
        
    }

    public function pendingBatchReject(Request $request){
        $data=AgencyBatch::findOrFail($request->id);
        $data['note'] = $request->note;
    //     // Mail::to($data->agency->email)->send(new ASRejectMail($data));

         /* Notification For Agency */
         $batch_no=$data->batch->batch_id;

         $notification = new Notification;
         $notification->rel_with = 'admin';
         $notification->title = 'Agency Batch Rejected';
         $notification->message = "Batch (ID: <span style='color:blue;'>$batch_no</span>) rejected by Agency";
         $notification->save();
         /* End Notification For Agency */
         $data->delete();

         $reason = new Reason;
         $reason->rel_with = 'admin';
         $reason->reason = $request->note;
         $reason->save();

         return response()->json(['status' => 'done'],200);

    }
    
}
