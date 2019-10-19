<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batch;
use App\BatchCandidateMap;
use App\Mail\BTRejectMail;
use App\Notification;
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

    public function batches(){
        $data=Batch::where('verified',1)->get();
        return view('common.batches')->with(compact('data')); 
    }

    public function pendingBatches(){
        $data=Batch::where('verified',0)->get();
        return view('admin.batches.pending-batches')->with(compact('data'));
    }
    public function viewBatch($id){
        $id = Crypt::decrypt($id); 
        $batchData=Batch::findOrFail($id);
        $candidates=BatchCandidateMap::where('bt_id',$id)->get();
        return view('admin.batches.view-batch')->with(compact('batchData','candidates'));


    }

    public function batchAccept($id){
        $id = Crypt::decrypt($id); 
        $batch=Batch::findOrFail($id);

        $data=DB::table('batches')
        ->select(\DB::raw('SUBSTRING(batch_id,3) as batch_id'))
        ->where("batch_id", "LIKE", "BT%")->get();
       // dd(count($data));
        $year = date('Y');
        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->batch_id;
                }
                $lastid= max($priceprod);
               
                $new_batchid = (substr($lastid, 0, 4)== $year) ? 'BT'.($lastid + 1) : 'BT'.$year.'000001' ;
            //dd($new_tpid);
        } else {
            $new_batchid = 'BT'.$year.'000001';
        }

        $batch->batch_id=$new_batchid;
        $batch->status=1;
        $batch->ind_status=1;
        $batch->verified=1;
        $batch->save();

          /* Notification For Partner */
          $notification = new Notification;
          $notification->rel_id = $batch->tp_id;
          $notification->rel_with = 'partner';
          $notification->title = 'Batch has been Approved';
          $notification->message = "Batch <br>(ID: <span style='color:blue;'>$new_batchid</span>) has been Approved";
          $notification->save();
          /* End Notification For Partner */

          alert()->success('Batch has been Approved', 'Job Done')->autoclose(3000);
          return Redirect()->back();
    }

    public function batchReject(Request $request){
        $data=Batch::findOrFail($request->id);
        $data['note'] = $request->note;
         Mail::to($data->partner->email)->send(new BTRejectMail($data));
         /* Notification For Partner */
         $notification = new Notification;
         $notification->rel_id = $data->tp_id;
         $notification->rel_with = 'partner';
         $notification->title = 'Batch Rejected';
         $notification->message = "One of your Batch has been (Spoc Name: <span style='color:blue;'>Rejected</span>) ";
         $notification->save();
         /* End Notification For Partner */
         BatchCandidateMap::where('bt_id',$request->id)->delete();
         $data->delete();
         return response()->json(['status' => 'done'],200);
    }
}
