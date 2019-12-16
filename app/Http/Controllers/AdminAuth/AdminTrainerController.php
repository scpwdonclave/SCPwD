<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TrainerJobRole;
use App\TrainerStatus;
use App\Notification;
use App\Trainer;
use App\Reason;
use App\Batch;
use Crypt;
use Auth;
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

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    protected function updateTrainerStatus($trainer,$for,$request,$id){
        if ($trainer->status) {
            // * Trainer is Active
            if (!is_null($request->reason) && $request->reason != '') {
                // * Trainer Deactivation Reason Provided so Deactivating
                
                $trainer->status = 0;
                $trainer->save();
                $reason = new Reason;
                $reason->rel_id = $id;
                $reason->rel_with = $for;
                $reason->reason = $request->reason;
                $reason->save();
                return array('type' => 'success', 'message' => "Trainer ($trainer->name) is <span style='font-weight:bold;color:red'>Deactive</span> now", 'title' => "Job Done");
                
            } else {
                // * Trainer Deactivation Reason Not Provided so Aborting
                
                return array('type' => 'error', 'message' => "Deactivation Reason can not be <span style='font-weight:bold;color:red'>NULL</span>", 'title' => "Aborted");
            }
            
        } else {
        // * Trainer is Inactive so Activating
        
            $trainer->status = 1;
            $trainer->save();
            return array('type' => 'success', 'message' => "Trainer ($trainer->name) is <span style='font-weight:bold;color:blue'>Active</span> now", 'title' => "Job Done");
        }
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
        if ($id=$this->decryptThis($id)) {
            $data = [
                'trainerData' => Trainer::findOrFail($id),
                'trainerdoc' => TrainerJobRole::where('tr_id',$id)->get(),
            ];
            return view('common.view-trainer')->with($data);
        }
    }
    public function dlinkTrainerView($id){
        if ($id=$this->decryptThis($id)) {
            $trainerData=TrainerStatus::findOrFail($id);
            $trainerdoc=TrainerJobRole::where('tr_id',$trainerData->prv_id)->get();
            $delinked = true;
            return view('common.view-trainer')->with(compact('trainerData','trainerdoc','delinked'));
        }
    }
    public function trainerAccept($id){
        if ($id=$this->decryptThis($id)) {
            $trainer=Trainer::findOrFail($id);
            if($trainer->verified){
                alert()->error("Trainer Account already <span style='color:blue;'>Approved</span>", "Done")->html()->autoclose(2000);
                return redirect()->back(); 
            }
    
            DB::transaction(function() use($trainer){
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
        
                if(is_null($trainer->trainer_id)){
                    $trainer->trainer_id=$new_trid;
                }
                $trainer->status=1;
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
                
                $neutral->qualification=$trainer->qualification;
                $neutral->sector_exp=$trainer->sector_exp;
                $neutral->teaching_exp=$trainer->teaching_exp;
                
                $neutral->qualification_doc=$trainer->qualification_doc;
                $neutral->ssc_no=$trainer->ssc_no;
                $neutral->ssc_doc=$trainer->ssc_doc;
                $neutral->ssc_issued=$trainer->ssc_issued;
                $neutral->ssc_valid=$trainer->ssc_valid;
                
                $neutral->resume=$trainer->resume;
                $neutral->other_doc=$trainer->other_doc;
                $neutral->status=1;
                $neutral->attached=1;
                $neutral->save();
            });
            alert()->success("Trainer has been <span style='color:blue;font-weight:bold;'>Approved</span>", 'Job Done')->html()->autoclose(3000);
            return redirect()->back();   
        }
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
        if ($id=$this->decryptThis($id)) {
            $trainer=Trainer::findOrFail($id);
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
    
            alert()->success("Trainer has been <span style='color:blue;font-weight:bold'>Activated</span>", 'Job Done')->html()->autoclose(3000);
            return redirect()->back();
        }
    }
    public function dlinkTrainerActive($id){
        if ($id=$this->decryptThis($id)) {
            if ($id=$this->decryptThis($id)) {
                $trainer=TrainerStatus::findOrFail($id);
                $trainer->status=1;
                $trainer->save();
                
                alert()->success("Trainer has been <span style='color:blue;font-weight:bold'>Activated</span>", 'Job Done')->html()->autoclose(3000);
                return Redirect()->back();
            }
        }
    }


    public function trainerStatusAction(Request $request)
    {
        if ($request->has('data')) {
        $data = explode(',',$request->data);

            if ($id=$this->decryptThis($data[0])) {
                
                if ($data[2]) {
                    // * Request for Trainers Table
                    $trainer = Trainer::find($id);
                    if ($trainer) {
                        // * Trainer is Present with That ID
                        if ($data[1]) {
                            // * Request for Change Trainer Status
                            $array = $this->updateTrainerStatus($trainer,'trainer',$request,$id);
                        } else {
                            // * Deling Process of a Trainer
                            $batch=Batch::where([['tr_id','=',$id],['completed','=',0]])->first();
                            if($batch){
                                // * Requested Trainer Linked with a Batch that is not yet Completed so Aborting

                                $array = array('type' => 'error', 'message' => "This Trainer is Actively Attached with a Batch That is not yet <span style='font-weight:bold;color:red'>Completed</span>", 'title' => "Aborted");
                            }else{
                                // * Proceeding to De Link the Requested Trainer
                                $trainerStatus=TrainerStatus::where('prv_id',$id)->orderBy('created_at', 'desc')->first();
                                $trainerStatus->attached=0;        
                                $trainerStatus->dlink_reason=$request->reason;   
                                $trainerStatus->save();  
                                $trainer->delete();
                                $array = array('type' => 'success', 'message' => "Trainer ($trainer->name) is <span style='font-weight:bold;color:blue'>De Linked</span> Successfully", 'title' => "Job Done");
                            }
                        }
                    } else {
                        // * Trainer Not Found With That ID

                        return response()->json(array('type' => 'error', 'message' => "We Could not find this Training Partner Account", 'title' =>  "Aborted"),200);
                    }
                } else {
                    // * Request for TrainerStatuses Table
                
                    $trainer = TrainerStatus::find($id);
                    if ($trainer) {
                        // * Trainer is Present with That ID
                        if ($data[1]) {
                            // * Request for Change Trainer Status
                            $array = $this->updateTrainerStatus($trainer,'dlink trainer',$request,$id);
                        } else {
                            // * Bad Request

                            return response()->json(array('type' => 'error'),400);
                        }
                    } else {
                        // * Trainer Not Found With That ID

                        return response()->json(array('type' => 'error', 'message' => "We Could not find this Training Partner Account", 'title' =>  "Aborted"),200);
                    }
                }

                return response()->json($array, 200);
            }
        }
    }





    public function trainerEdit($id){
        if ($id=$this->decryptThis($id)) {
            $trainer=Trainer::findOrFail($id);
            return view('admin.trainers.trainer-edit')->with(compact('trainer'));            
        }
    }

    public function trainerUpdate(Request $request){
        $trainer=Trainer::findOrFail($request->trid);
        $trainer_status=TrainerStatus::where('prv_id',$request->trid)->first();

        $trainer->name=$trainer_status->name=$request->name;
        $trainer->mobile=$trainer_status->mobile=$request->mobile;
        $trainer->email=$trainer_status->email=$request->email;

        if ($request->hasFile('resume')) {
            $trainer->resume =$trainer_status->resume = Storage::disk('myDisk')->put('/trainers', $request['resume']);            
        }
        if ($request->hasFile('other_doc')) {
            $trainer->other_doc = $trainer_status->other_doc = Storage::disk('myDisk')->put('/trainers', $request['other_doc']);            
        }
        $trainer->scpwd_no=$request->scpwd_doc_no;
        if ($request->hasFile('scpwd_doc')) {
            $trainer->scpwd_doc = $trainer_status->scpwd_doc = Storage::disk('myDisk')->put('/trainers', $request['scpwd_doc']);            
        }
        $trainer->scpwd_issued=$trainer_status->scpwd_issued=$request->scpwd_start;
        $trainer->scpwd_valid=$trainer_status->scpwd_valid=$request->scpwd_end;
        
        $trainer->ssc_no=$request->ssc_no;
        if ($request->hasFile('ssc_doc')) {
            $trainer->ssc_doc = $trainer_status->ssc_doc = Storage::disk('myDisk')->put('/trainers', $request['ssc_doc']);            
        }
        $trainer->ssc_issued=$trainer_status->ssc_issued=$request->ssc_start;
        $trainer->ssc_valid=$trainer_status->ssc_valid=$request->ssc_end;

        $trainer->qualification=$trainer_status->qualification=$request->qualification;
        $trainer->sector_exp = $trainer_status->sector_exp = $request->sector_exp;
        $trainer->teaching_exp = $trainer_status->teaching_exp = $request->teaching_exp;

        if ($request->hasFile('qualification_doc')) {
            $trainer_status->qualification_doc = $trainer->qualification_doc = Storage::disk('myDisk')->put('/trainers', $request['qualification_doc']);            
        }

        $trainer->save();
        $trainer_status->save();

        alert()->success("Trainer has been <span style='color:blue;font-weight:bold'>Updated</span>", 'Job Done')->html()->autoclose(3000);
        return redirect()->back();
       
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
