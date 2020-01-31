<?php

namespace App\Http\Controllers\AdminAuth;

use DB;
use Auth;
use Crypt;
use App\Batch;
use App\Reason;
use App\Trainer;
use Carbon\Carbon;
use App\Notification;
use App\TrainerStatus;
use App\TrainerJobRole;
use App\Helpers\AppHelper;
use App\Events\TPMailEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

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
        
        $dataMail = collect();
        if ($for == 'trainer') {
            $dataMail->tag = 'tractivedeactive';
            $dataMail->name = $trainer->name;
            $dataMail->tp_name = $trainer->partner->spoc_name;
            $dataMail->tr_id = $trainer->trainer_id;
            $dataMail->email = $trainer->partner->email;
        }

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
                $dataMail->reason = $request->reason;
                $array = array('type' => 'success', 'message' => "Trainer (<span style='font-weight:bold;color:blue'>$trainer->name</span>) is <span style='font-weight:bold;color:red'>Deactive</span> now", 'title' => "Job Done");
                
            } else {
                // * Trainer Deactivation Reason Not Provided so Aborting
                
                return array('type' => 'error', 'message' => "Deactivation Reason can not be <span style='font-weight:bold;color:red'>NULL</span>", 'title' => "Aborted");
            }
            
        } else {
            // * Trainer is Inactive so Activating
        
            $trainer->status = 1;
            $trainer->save();
            $array = array('type' => 'success', 'message' => "Trainer ($trainer->name) is <span style='font-weight:bold;color:blue'>Active</span> now", 'title' => "Job Done");
        }
        
        if ($for == 'trainer') {
            $stat = ($trainer->status)?'Re-Activated':'Deactivated';
            AppHelper::instance()->writeNotification($trainer->partner->id,'partner','Trainer '.$stat,"Your Trainer ".$trainer->name."(ID: <span style='color:blue'>$trainer->trainer_id</span>) has been <span style='color:blue;'>".$stat."</span>.");
            foreach ($trainer->batches as $batch) {
                if ($batch->status && $batch->verified && (Carbon::parse($batch->batch_end.' 23:59') > Carbon::now())) {
                    AppHelper::instance()->writeNotification($batch->center->id,'center','Trainer '.$stat,"Trainer ".$trainer->name."(ID: <span style='color:blue'>$trainer->trainer_id</span>) has been <span style='color:blue;'>".$stat."</span>.");
                }
            }
            $dataMail->status = $trainer->status;
            event(new TPMailEvent($dataMail));
        }
        return $array;
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

    // * Trainer Accept Reject Function
    
    public function trainerAction(Request $request)
    {
        if ($req=$this->decryptThis($request->id)) {
            $data = explode(',',$req);
            $trainer = Trainer::findOrFail($data[0]);
            if (!$trainer->verify) {
                if (!$trainer->partner->status) {
                    alert()->error('Please <span style="color:blue;">Re-Activate</span> TP of This Trainer Before you Proceed', 'Aborting')->html()->autoclose(5000);
                    return redirect()->back();
                } else {
                    $dataMail = collect();
                    $dataMail->tag = 'tracceptreject';
                    $dataMail->status = $data[1];
                    if ($data[1]) {
                        DB::transaction(function() use($trainer){
                            $data=DB::table('trainers')
                            ->select(\DB::raw('SUBSTRING(trainer_id,3) as trainer_id'))
                            ->where("trainer_id", "LIKE", "TR%")->get();
                            
                            
                            $dataStatus=DB::table('trainer_statuses')
                            ->select(\DB::raw('SUBSTRING(trainer_id,3) as trainer_id'))
                            ->where('attached',0)
                            ->orderBy('id', 'desc')->get()->unique('trainer_id');
                            
                            
                            $year =( date('m') > 3) ? date('y').(date('y') + 1) : (date('y')-1).date('y');

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
                        
                        $dataMail->tr_id = $trainer->trainer_id;
                        AppHelper::instance()->writeNotification($trainer->partner->id,'partner','Trainer Accepted',"Your Trainer (ID: <span style='color:blue'>$trainer->trainer_id</span>) has been <span style='color:blue;'>Approved</span>.");
                        alert()->success("Trainer has been <span style='color:blue;font-weight:bold;'>Approved</span>", 'Job Done')->html()->autoclose(3000);
                    } else {
                        $trainer->trainer_jobroles()->delete();
                        $trainer->delete();
                        $dataMail->reason = $request->reason;
                        AppHelper::instance()->writeNotification($trainer->partner->id,'partner','Trainer Rejected',"Your Requested Trainer has been <span style='color:red;'>Rejected</span>.Kindly check your mail");
                        alert()->success("Trainer has been <span style='color:red;font-weight:bold'>Rejected</span>", "Job Done")->html()->autoclose(4000);
                    }
                    $dataMail->name = $trainer->name;
                    $dataMail->tp_name = $trainer->partner->spoc_name;
                    $dataMail->email = $trainer->partner->email;
                    
                    event(new TPMailEvent($dataMail));
                    return redirect(route('admin.tc.trainers'));
                }
            } else {
                alert()->error("Trainer has already been <span style='color:blue;font-weight:bold'>Approved</span>", "Done")->html()->autoclose(3000);
                return redirect(route('admin.tc.trainers'));
            }
        }
    }
    
    // * End Trainer Accept Reject Function
    
    // * Trainer Status Update (Both for Linked and DeLinked)

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
                            // * Delinking Process of a Trainer
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
                                
                                $dataMail = collect();
                                $dataMail->tag = 'trdelink';
                                $dataMail->name = $trainer->name;
                                $dataMail->tp_name = $trainer->partner->spoc_name;
                                $dataMail->tr_id = $trainer->trainer_id;
                                $dataMail->reason = $request->reason;
                                $dataMail->email = $trainer->partner->email;
                                $trainer->delete();
                                event(new TPMailEvent($dataMail));
                                AppHelper::instance()->writeNotification($trainer->partner->id,'partner','Trainer De Linked',"Your Trainer (ID: <span style='color:blue'>$trainer->trainer_id</span>) has been <span style='color:blue;'>DeLinked</span> from You.");
                                $array = array('type' => 'success', 'message' => "Trainer (<span style='font-weight:bold;color:blue'>$trainer->name</span>) is <span style='font-weight:bold;color:blue'>De Linked</span> Successfully", 'title' => "Job Done");
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
    
    // * End Trainer Status Update (Both for Linked and DeLinked)
    
    
    
    
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

        if ($request->has('mobile') && $request->has('email') && $request->has('id')) {
            $dataEmail = AppHelper::instance()->checkEmail($request->email);
            $dataMob = AppHelper::instance()->checkContact($request->mobile);
            $array = [];
            if ($dataEmail['status']) {
                $array['email'] = true;
            } else {
                if ($dataEmail['user'] == 'trainer') {
                    $trainer = TrainerStatus::find($dataEmail['userid']);
                    if ($trainer->prv_id == $request->id) {
                        $array['email'] = true;
                    } else {
                        $array['email'] = false;
                    }
                } else {
                    $array['email'] = false;
                }
            }
            
            if ($dataMob['status']) {
                $array['mobile'] = true;
            } else {
                if ($dataMob['user'] == 'trainer') {
                    $trainer = TrainerStatus::find($dataMob['userid']);
                    if ($trainer->prv_id == $request->id) {
                        $array['mobile'] = true;
                    } else {
                        $array['mobile'] = false;
                    }
                } else {
                    $array['mobile'] = false;
                }
            }
            
            if ($array['mobile'] && $array['email']) {
                return response()->json(['success' => true], 200);
            } elseif ($array['mobile'] && !$array['email']) {
                return response()->json(['success' => false, 'message' => 'This Email ID is Registered with Someone Else'], 200);
            } elseif (!$array['mobile'] && $array['email']) {
                return response()->json(['success' => false, 'message' => 'This Mobile No is Registered with Someone Else'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'This Email ID & Mobile No is Registered with Someone Else'], 200);
            }
        }
    }
}
