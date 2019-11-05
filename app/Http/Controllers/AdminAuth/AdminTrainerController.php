<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Trainer;
use App\TrainerStatus;
use App\TrainerJobRole;
use App\Batch;
use App\Notification;
use App\Reason;
use Auth;
use Crypt;
use DB;

class AdminTrainerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function trainers(){
        $data=Trainer::where('verified',1)->get();
        $dlinkData=TrainerStatus::orderBy('id', 'desc')->get()->unique('trainer_id');
        return view('admin.trainers.trainers')->with(compact('data','dlinkData'));
    }
    public function pendingTrainers(){
        $data=Trainer::where([['verified',0],['reassign',0]])->get();
        $reassign_data=Trainer::where([['verified',0],['reassign',1]])->get();
        return view('admin.trainers.pending-trainers')->with(compact('data','reassign_data')); 

    }

    public function trainerView($id){

        $trainerData=Trainer::findOrFail($id);
        return view('common.view-trainer')->with(compact('trainerData'));
        
    }
    public function dlinkTrainerView($id){

        $trainerData=TrainerStatus::findOrFail($id);
        $trainerdoc=TrainerJobRole::where('tr_id',$trainerData->prv_id)->get();
        $dlinkData = collect([]);
        return view('common.view-trainer')->with(compact('trainerData','trainerdoc'));
        
    }
    public function trainerAccept($id){
        try {
            $trainer_id = Crypt::decrypt($id); 
        } catch (DecryptException $e) {
            abort(404);
        }
        $trainer=Trainer::findOrFail($trainer_id);

        if($trainer->verified==1){
            alert()->error("Trainer Account already <span style='color:blue;'>Approved</span>", "Done")->html()->autoclose(2000);
            return Redirect()->back(); 
        }
        
        $data=DB::table('trainers')
        ->select(\DB::raw('SUBSTRING(trainer_id,3) as trainer_id'))
        ->where("trainer_id", "LIKE", "TR%")->get();
       
       
        $dataStatus=DB::table('trainer_statuses')
        ->select(\DB::raw('SUBSTRING(trainer_id,3) as trainer_id'))
        ->where('attached',0)
        ->orderBy('id', 'desc')->get()->unique('trainer_id');
       
      
        $year = date('Y');
        if (count($data) > 0 || count($dataStatus) > 0 ) {

            $priceprod1 = array();
                foreach ($data as $key=>$data) {
                    $priceprod1[$key]=$data->trainer_id;
                }
            $priceprod2 = array();
                foreach ($dataStatus as $key=>$dataStatus) {
                    $priceprod2[$key]=$dataStatus->trainer_id;
                }
               $priceprod= array_merge($priceprod1,$priceprod2);
                $lastid= max($priceprod);
               
               
                $new_trid = (substr($lastid, 0, 4)== $year) ? 'TR'.($lastid + 1) : 'TR'.$year.'000001' ;
           
        } else {
            $new_trid = 'TR'.$year.'000001';
        }

        if($trainer->trainer_id ==null){
        $trainer->trainer_id=$new_trid;
        }
        $trainer->status=1;
        $trainer->ind_status=1;
        $trainer->verified=1;
        $trainer->save();

        $neutral=new TrainerStatus;
        $neutral->prv_id=$trainer->id;
        $neutral->trainer_id=$trainer->trainer_id;
        $neutral->tp_id=$trainer->tp_id;
        $neutral->name=$trainer->name;
        $neutral->doc_no=$trainer->doc_no;
        $neutral->doc_type=$trainer->doc_type;
        $neutral->doc_file=$trainer->doc_file;
        $neutral->mobile=$trainer->mobile;
        $neutral->email=$trainer->email;
       
        $neutral->scpwd_no=$trainer->scpwd_no;
        $neutral->scpwd_doc=$trainer->scpwd_doc;
        $neutral->scpwd_issued=$trainer->scpwd_issued;
        $neutral->scpwd_valid=$trainer->scpwd_valid;
        $neutral->resume=$trainer->resume;
        $neutral->other_doc=$trainer->other_doc;
        $neutral->status=1;
        $neutral->attached=1;
        $neutral->save();

        alert()->success("Trainer has been <span style='color:blue;'>Approved</span>", 'Job Done')->html()->autoclose(3000);
        return Redirect()->back();
    }

    public function trainerReject(Request $request){
        $trainer=Trainer::findOrFail($request->id);
        TrainerJobRole::where('tr_id',$request->id)->delete();
        $trainer->delete();
        return response()->json(['status' => 'done'],200);
    }

    public function trainerDlink(Request $request){
        $trainer=Trainer::findOrFail($request->id);
        $trainerStatus=TrainerStatus::where('prv_id',$request->id)->first();

        $batch=Batch::where('tr_id',$request->id)->get();
        if(count($batch)>0){
            return response()->json(['status' => 'fail'],200);
        }else{

        $trainerStatus->attached=0;        
        $trainerStatus->dlink_reason=$request->reason;   
        $trainerStatus->save();  
        $trainer->delete();   
        return response()->json(['status' => 'done'],200);
        }
    }

    public function trainerDeactive(Request $request){
        $trainer=Trainer::findOrFail($request->id);
        $trainer->status=0;
        $trainer->save(); 

        $reason = new Reason;
        $reason->rel_id = $trainer->id;
        $reason->rel_with = 'trainer';
        $reason->reason = $request->reason;
        $reason->save();

        /* Notification For Partner */
        $notification = new Notification;
        $notification->rel_id = $trainer->tp_id;
        $notification->rel_with = 'partner';
        $notification->title = 'Trainer Deactivated';
        $notification->message = "Trainer (ID $trainer->trainer_id) has been <span style='color:blue;'>Deactivated</span>.";
        $notification->save();
        /* End Notification For Partner */

        return response()->json(['status' => 'done'],200);

    }
    public function dlinkTrainerDeactive(Request $request){
        $trainer=TrainerStatus::findOrFail($request->id);
        $trainer->status=0;
        $trainer->save();

        $reason = new Reason;
        $reason->rel_id = $trainer->id;
        $reason->rel_with = 'dlink trainer';
        $reason->reason = $request->reason;
        $reason->save();

        return response()->json(['status' => 'done'],200);

    }
    public function trainerActive($id){
        try {
            $tr_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            abort(404);
        }
        $trainer=Trainer::findOrFail($tr_id);
        $trainer->status=1;
        $trainer->save();

        /* Notification For Partner */
        $notification = new Notification;
        $notification->rel_id = $trainer->tp_id;
        $notification->rel_with = 'partner';
        $notification->title = 'Trainer Activated';
        $notification->message = "Trainer (ID $trainer->trainer_id) has been <span style='color:blue;'>Activated</span>.";
        $notification->save();
        /* End Notification For Partner */

        alert()->success('Trainer has been Activated', 'Job Done')->autoclose(3000);
        return Redirect()->back();

    }
    public function dlinkTrainerActive($id){
        try {
            $tr_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            abort(404);
        }
        $trainer=TrainerStatus::findOrFail($tr_id);
        $trainer->status=1;
        $trainer->save();
        
        alert()->success('Trainer has been Activated', 'Job Done')->autoclose(3000);
        return Redirect()->back();

    }

    public function trainerEdit($id){
        try {
            $tr_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            abort(404);
        }
        $trainer=Trainer::findOrFail($tr_id);

        return view('admin.trainers.trainer-edit')->with(compact('trainer'));
    }

    public function trainerUpdate(Request $request){
        $trainer=Trainer::findOrFail($request->trid);
        $trainer_status=TrainerStatus::where('prv_id',$request->trid)->first();
        $trainer_job=TrainerJobRole::where('tr_id',$request->trid)->first();

        $trainer->name=$request->name;
        $trainer_status->name=$request->name;
        $trainer->mobile=$request->mobile;
        $trainer_status->mobile=$request->mobile;
        $trainer->email=$request->email;
        $trainer_status->email=$request->email;
        if ($request->hasFile('resume')) {
            $trainer->resume = Storage::disk('myDisk')->put('/trainers', $request['resume']);            
            $trainer_status->resume = Storage::disk('myDisk')->put('/trainers', $request['resume']);            
        }
        if ($request->hasFile('other_doc')) {
            $trainer->other_doc = Storage::disk('myDisk')->put('/trainers', $request['other_doc']);            
            $trainer_status->other_doc = Storage::disk('myDisk')->put('/trainers', $request['other_doc']);            
        }
        $trainer->scpwd_no=$request->scpwd_doc_no;
        if ($request->hasFile('scpwd_doc')) {
            $trainer->scpwd_doc = Storage::disk('myDisk')->put('/trainers', $request['scpwd_doc']);            
            $trainer_status->scpwd_doc = Storage::disk('myDisk')->put('/trainers', $request['scpwd_doc']);            
        }
        $trainer->scpwd_issued=$request->scpwd_start;
        $trainer_status->scpwd_issued=$request->scpwd_start;
        $trainer->scpwd_valid=$request->scpwd_end;
        $trainer_status->scpwd_valid=$request->scpwd_end;

        $trainer_job->qualification=$request->qualification;
        if ($request->hasFile('qualification_doc')) {
            $trainer_job->qualification_doc = Storage::disk('myDisk')->put('/trainers', $request['qualification_doc']);            
            
        }

        $trainer->save();
        $trainer_status->save();
        $trainer_job->save();

        alert()->success('Trainer has been Updated', 'Job Done')->autoclose(3000);
        return Redirect()->back();
       
    }

    public function trainerApi(Request $request){

        if ($request->has('checkredundancy')) {
            if ($request->has('id')) {
                if (Trainer::where([[$request->section,$request->checkredundancy],['id','!=',$request->id]])->first()) {
                    return response()->json(['success' => false], 200);
                } else {
                    return response()->json(['success' => true], 200);
                }
            }
        }

    }
}
