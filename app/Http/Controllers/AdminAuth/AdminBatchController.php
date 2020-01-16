<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Mail;
use Crypt;
use App\Batch;
use App\Holiday;
use Carbon\Carbon;
use App\BatchUpdate;
use App\Helpers\AppHelper;
use App\Events\TCMailEvent;
use App\Events\TPMailEvent;
use Illuminate\Http\Request;
use App\BatchCenterCandidateMap;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;

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
        foreach ($batch->candidatesmap as $batchcentercandidate) {
            if (!$batchcentercandidate->centercandidate->candidate->status || !$this->partnerscheme($batchcentercandidate->centercandidate)) {
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
                $dataMail = collect();
                $dataMail->tag = 'btacceptreject';
                $dataMail->tp_name = $data->partner->spoc_name;
                $dataMail->tc_name = $data->center->spoc_name;
                $dataMail->email = $data->partner->email;


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
                        $fmonth=date('F');
                        $fyear =( date('m') > 3) ? date('y')."-".(date('y') + 1) : (date('y')-1)."-".date('y');

                        $data->batch_id=$new_batchid;
                        $data->f_month=$fmonth;	
                        $data->f_year=$fyear;	
                        $data->status=1;
                        $data->verified=1;
                        $data->save();
                
                        AppHelper::instance()->writeNotification($data->tp_id,'partner','Batch Approved',"Batch <br>(ID: <span style='color:blue;'>$new_batchid</span>) has been Approved");
                        AppHelper::instance()->writeNotification($data->tc_id,'center','Batch Approved',"Batch <br>(ID: <span style='color:blue;'>$new_batchid</span>) has been Approved");
                        $dataMail->status = 1;
                        $dataMail->bt_id = $new_batchid;
                        event(new TPMailEvent($dataMail));
                        $dataMail->email = $data->center->email;
                        event(new TCMailEvent($dataMail));
                        
                        alert()->success("Batch has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(3000);   
                    } else{
                        alert()->error("Either this Trainer is <span style='color:red;'>Pre-Occupied</span> at Provided Time or Candidate associated with This Batch is <span style='color:red;'>Inactive</span>, Cannot Proceed!", 'Attention')->html()->autoclose(6000);
                    }
                } elseif ($request->action === 'reject') {
                    if (!is_null($request->reason)) {
                        AppHelper::instance()->writeNotification($data->tp_id,'partner','Batch Rejected',"One of your Batch has been <span style='color:blue;'>Rejected</span>, Kindly Check your Mail");
                        AppHelper::instance()->writeNotification($data->tc_id,'center','Batch Rejected',"One of your Batch (Requested by your TP) has been <span style='color:blue;'>Rejected</span>");
                        
                        $dataMail->status = 0;
                        $dataMail->reason = $request->reason;
                        event(new TPMailEvent($dataMail));

                        // BatchCenterCandidateMap::where('bt_id',$id)->delete();
                        DB::table('trainer_batch_map')->where([['tr_id','=', $data->tr_id], ['bt_id','=', $data->id]])->delete();
                        DB::table('batch_trainer_map')->where([['bt_id','=', $data->id], ['tr_id','=', $data->tr_id]])->delete();
                        $data->candidatesmap()->delete();
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
            $dataMail = collect();
            $dataMail->tag = 'btupdateacceptreject';
            $dataMail->tp_name = $batchupdate->batch->partner->spoc_name;
            $dataMail->bt_id = $batchupdate->batch->batch_id;
            $dataMail->email = $batchupdate->batch->partner->email;
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

                    $dataMail->status = 1;
                    event(new TPMailEvent($dataMail));

                    AppHelper::instance()->writeNotification($batch->tp_id,'partner','Batch Update Accepted',"Your Requested Batch(ID: <span style='color:blue'>$batch->batch_id</span>) Update has been Accepted.");
                    AppHelper::instance()->writeNotification($batch->tc_id,'center','Batch Update Accepted',"Your Batch(ID: <span style='color:blue'>$batch->batch_id</span>) details has been Updated.");    
                    alert()->success('Batch Update Request has been <span style="color:blue;font-weight:bold">Approved</span> Successfully', 'Job Done')->html()->autoclose(3000);
                
                } elseif ($request->action === 'reject') {
                    
                    if (!is_null($request->reason)) {
                        $batchupdate->reason = $request->reason;
                        $batchupdate->action = 1;
                        $batchupdate->approved = 0;
                        $batchupdate->save();

                        
                        $dataMail->reason = $request->reason;
                        $dataMail->status = 0;
                        event(new TPMailEvent($dataMail));
                        $batchid = $batchupdate->batch->batch_id;
                        AppHelper::instance()->writeNotification($batchupdate->batch->tp_id,'partner','Batch Update Rejected',"Your Requested Batch(ID: <span style='color:blue'>$batchid</span>) Update has been Rejected.Kindly Check your Mail");

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
