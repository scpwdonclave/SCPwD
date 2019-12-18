<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use App\BatchUpdate;
use App\Holiday;
use App\Batch;
use App\BatchCandidateMap;
use App\Mail\BTRejectMail;
use App\Notification;
use Carbon\Carbon;
use Crypt;
use DB;
use Mail;

class AdminBatchController extends Controller
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

    protected function getHolidays(){
        $hds = Holiday::all();
        $holidays = [];
        foreach ($hds as $hd) {
            array_push($holidays, Carbon::parse($hd->holiday_date)->toDateString());
        }
        return $holidays;
    }

    protected function isHoliday($date){
        if ($date->isWeekend() || in_array($date->toDateString(), $this->getHolidays())) {
            return true;
        } else {
            return false;
        }
        
    }

    protected function getLastActiveDay($date){
        while ($this->isHoliday($date)) {
            $date->subDay();
        }
        return $date->format('d-m-Y');
    }

    protected function trainer_availability($trainer_id, $starttime, $endtime){
        $trainer_batches = Batch::where([['verified', 1],['completed', 0],['tr_id', $trainer_id]])->get();
        if ($trainer_batches) {
            foreach ($trainer_batches as $trainer_batch) {
                $start = Carbon::parse($trainer_batch->start_time); 
                $end = Carbon::parse($trainer_batch->end_time); 
                if ($starttime->lessThan($start)) {
                    if ($endtime->greaterThan($start)) {
                        return false;
                    }
                } else {
                    if ($starttime->lessThan($end)) {
                        return false;
                    }                
                }
            }
        } else {
            return true;
        }
        return true;
    }
    
    protected function partnerscheme($candidate){
        return $candidate->jobrole->partnerjobrole->status;
    }
    protected function candidate_availability($batchid){
        $batch = Batch::find($batchid);
        foreach ($batch->candidatesmap as $candidate) {
            if (!$candidate->candidate->status || !$this->partnerscheme($candidate->candidate)) {
                    return false;
            }
        }
        return true;
    }


    public function batches(){
        $data=Batch::where('verified',1)->get();
        return view('common.batches')->with(compact('data')); 
    }

    public function pendingBatches(){
        $data=Batch::where('verified',0)->get();
        return view('admin.batches.pending-batches')->with(compact('data')); 
    }
    public function viewBatch($id){
        if ($id=$this->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            return view('common.view-batch')->with(compact('batchData'));
        }
    }


    public function batchAction(Request $request){
        if ($id=$this->decryptThis($request->id)) {
            $data=Batch::findOrFail($id);
            $scheme=$data->scheme->scheme;
            $sch_len=4+strlen($scheme)+1+1;
            
            if (!$data->verified) {
                if ($request->action === 'accept') {

                    if ($this->trainer_availability($data->tr_id, Carbon::parse($data->start_time), Carbon::parse($data->end_time)) && $this->candidate_availability($data->id)) {
                        $records=DB::table('batches')->select(DB::raw("SUBSTRING(batch_id,$sch_len) as batch_id"))->where("batch_id", "LIKE", "PwD_".$scheme."%")->get();
                        $year = date('Y');
                        if (count($records) > 0) {
                            $priceprod = array();
                            foreach ($records as $key=>$record) {
                                $priceprod[$key]=$record->batch_id;
                            }
                            $lastid= max($priceprod);
                            $new_batchid =  'PwD_'.$scheme.'_'.sprintf("%05d", $lastid + 1);
                        } else {
                            $new_batchid = 'PwD_'.$scheme.'_'.sprintf("%05d", 1); // sprintf("%02d", 4444)
                        }
                        
                        //dd($new_batchid); 
                        $data->batch_id=$new_batchid;
                        $data->status=1;
                        $data->verified=1;
                        $data->save();
                
                        /* Notification For Partner */
                        $notification = new Notification;
                        $notification->rel_id = $data->tp_id;
                        $notification->rel_with = 'partner';
                        $notification->title = 'Batch has been Approved';
                        $notification->message = "Batch <br>(ID: <span style='color:blue;'>$new_batchid</span>) has been Approved";
                        $notification->save();
                        /* End Notification For Partner */
                
                        alert()->success("Batch has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(3000);   
                    } else{
                        alert()->error("Either this Trainer is <span style='color:red;'>Pre-Occupied</span> at Provided Time or Candidate associated with This Batch is <span style='color:red;'>Inactive</span>, Cannot Proceed!", 'Attention')->html()->autoclose(6000);
                    }
                } elseif ($request->action === 'reject') {
                    if (!is_null($request->reason)) {
                        $data['note'] = $request->reason;
                        Mail::to($data->partner->email)->send(new BTRejectMail($data));
                        
                        /* Notification For Partner */
                        $notification = new Notification;
                        $notification->rel_id = $data->tp_id;
                        $notification->rel_with = 'partner';
                        $notification->title = 'Batch Rejected';
                        $notification->message = "One of your Batch has been <span style='color:blue;'>Rejected</span>, Please Check your Mail";
                        $notification->save();
                        /* End Notification For Partner */
                        
                        BatchCandidateMap::where('bt_id',$id)->delete();
                        $data->delete();
                        alert()->success("Batch has been <span style='color:blue;font-weight:bold'>Rejected</span>", 'Job Done')->html()->autoclose(3000);         
                    } else {
                        alert()->error('Please Provide a Reason First', 'Job Done')->autoclose(3000);
                    }
                }
                return redirect()->route('admin.batch.batches');
                
            } else {
                return redirect()->route('admin.batch.batches');
            }
        }
    }

    public function batchUpdates(){
        $data = [
            'batchupdates' => BatchUpdate::where('action', 1)->get(),
            'updaterequests' => BatchUpdate::where('action', 0)->get()
        ];
        return view('admin.batches.batch-updates')->with($data);
    }

    public function batchUpdateAction(Request $request){
        if ($id=$this->decryptThis($request->id)) {
            $batchupdate = BatchUpdate::findOrFail($id);
            if (!$batchupdate->action) {
                if ($request->action === 'accept') {
                    if ($this->isHoliday(Carbon::parse($batchupdate->end_date))) {
                        alert()->error('Batch End Date is on a <span style="color:red">Holiday</span>, Can not Proceed', 'Abort')->html()->autoclose(3000);
                        return redirect()->route('admin.batch.bu');
                    }
    
                    $batch = Batch::findOrFail($batchupdate->batch->id);
                    DB::transaction(function () use($batch,$batchupdate){
                        if ($batch->tr_id != $batchupdate->new_tr_id) {
                            if ($this->isHoliday(Carbon::parse($batchupdate->new_tr_start))) {
                                alert()->error('New Trainer Start Date is on a <span style="color:red">Holiday</span>, Can not Proceed', 'Abort')->html()->autoclose(3000);
                                return redirect()->route('admin.batch.bu');
                            }
                            $old_trainer_end_date = $this->getLastActiveDay(Carbon::parse($batchupdate->new_tr_start)->subDay());
                            DB::table('batch_trainer_map')->insert(['bt_id' => $batch->id, 'tr_id' => $batchupdate->new_tr_id, 'assign_date' => $batchupdate->new_tr_start]);
                            DB::table('trainer_batch_map')->where(['bt_id' => $batch->id, 'tr_id' => $batch->tr_id])->update(['end' => $old_trainer_end_date]);
                            DB::table('trainer_batch_map')->insert(['bt_id' => $batch->id, 'tr_id' => $batchupdate->new_tr_id, 'start' => $batchupdate->new_tr_start, 'end' => $batchupdate->end_date]);
                        }
                        
                        $batch->tr_id = $batchupdate->new_tr_id;
                        $batch->batch_end = $batchupdate->end_date;
                        $batch->assessment = $batchupdate->assessment;
                        $batch->save();
                        $batchupdate->action = 1;
                        $batchupdate->approved = 1;
                        $batchupdate->save();
                    });
    
                    alert()->success('Batch Update Request has been <span style="color:blue;font-weight:bold">Approved</span> Successfully', 'Job Done')->html()->autoclose(3000);
                
                } elseif ($request->action === 'reject') {
                    
                    if (!is_null($request->reason)) {
                        $batchupdate->reason = $request->reason;
                        $batchupdate->action = 1;
                        $batchupdate->approved = 0;
                        $batchupdate->save();

                        $batchupdate['note'] = $request->reason;
                        Mail::to($batchupdate->partner->email)->send(new BTRejectMail($batchupdate));

                        alert()->success('Batch Update Request has been <span style="color:red;font-weight:bold">Rejected</span> Successfully', 'Job Done')->html()->autoclose(3000);
                    } else {
                        alert()->error('Please Provide a Reason First', 'Job Done')->autoclose(3000);
                    }                    
                }
            }
            return redirect()->route('admin.batch.bu');
        }
    }
}
