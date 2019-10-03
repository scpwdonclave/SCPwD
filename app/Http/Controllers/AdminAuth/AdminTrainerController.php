<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trainer;
use App\TrainerStatus;
use App\TrainerJobRole;
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
        $dlinkData=DB::table('Trainer_statuses')->where('attached',0)->orderBy('id', 'desc')->get()->unique('trainer_id');
        return view('admin.trainers.trainers')->with(compact('data','dlinkData')); 

    }
    public function pendingTrainers(){
        $data=Trainer::where('verified',0)->get();
        return view('admin.trainers.pending-trainers')->with(compact('data')); 

    }

    public function trainerView($id){

        $trainerData=Trainer::findOrFail($id);
        $trainerdoc=TrainerJobRole::where('tr_id',$id)->get();
        return view('admin.trainers.view-trainer')->with(compact('trainerData','trainerdoc'));
        
    }
    public function dlinkTrainerView($id){

        $trainerData=TrainerStatus::findOrFail($id);
        $trainerdoc=TrainerJobRole::where('tr_id',$trainerData->prv_id)->get();
        return view('admin.trainers.view-trainer')->with(compact('trainerData','trainerdoc'));
        
    }
    public function trainerAccept($id){
        $trainer_id = Crypt::decrypt($id); 
        $trainer=Trainer::findOrFail($trainer_id);

        $data=DB::table('trainers')
        ->select(\DB::raw('SUBSTRING(trainer_id,3) as trainer_id'))
        ->where("trainer_id", "LIKE", "TR%")->get();
      
        $year = date('Y');
        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->trainer_id;
                }
                $lastid= max($priceprod);
               
                $new_trid = (substr($lastid, 0, 4)== $year) ? 'TR'.($lastid + 1) : 'TR'.$year.'000001' ;
           
        } else {
            $new_trid = 'TR'.$year.'000001';
        }

        $trainer->trainer_id=$new_trid;
        $trainer->status=1;
        $trainer->ind_status=1;
        $trainer->verified=1;
        $trainer->save();

        $neutral=new TrainerStatus;
        $neutral->prv_id=$trainer->id;
        $neutral->trainer_id=$trainer->trainer_id;
        $neutral->tp_id=$trainer->tp_id;
        $neutral->name=$trainer->name;
        $neutral->doc_number=$trainer->doc_number;
        $neutral->doc_type=$trainer->doc_type;
        $neutral->doc_file=$trainer->doc_file;
        $neutral->mobile=$trainer->mobile;
        $neutral->email=$trainer->email;
       
        $neutral->scpwd_doc=$trainer->scpwd_doc;
        $neutral->scpwd_issued=$trainer->scpwd_issued;
        $neutral->scpwd_valid=$trainer->scpwd_valid;
        $neutral->resume=$trainer->resume;
        $neutral->other_doc=$trainer->other_doc;
        $neutral->status=1;
        $neutral->attached=1;
        $neutral->save();

        alert()->success('Trainer has been Approved', 'Job Done')->autoclose(3000);
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
        $trainerStatus->attached=0;        
        $trainerStatus->dlink_reason=$request->reason;   
        $trainerStatus->save();  
        $trainer->delete();   
        return response()->json(['status' => 'done'],200);
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
        $notification->title = 'Trainer Deactive';
        $notification->message = "One of Your Trainer has been <span style='color:blue;'>Deactivated</span>.";
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
        $tr_id = Crypt::decrypt($id);
        $trainer=Trainer::findOrFail($tr_id);
        $trainer->status=1;
        $trainer->save();

        /* Notification For Partner */
        $notification = new Notification;
        $notification->rel_id = $trainer->tp_id;
        $notification->rel_with = 'partner';
        $notification->title = 'Trainer Active';
        $notification->message = "One of Your Trainer has been <span style='color:blue;'>Activated</span>.";
        $notification->save();
        /* End Notification For Partner */

        alert()->success('Trainer has been Activated', 'Job Done')->autoclose(3000);
        return Redirect()->back();

    }
    public function dlinkTrainerActive($id){
        $tr_id = Crypt::decrypt($id);
        $trainer=TrainerStatus::findOrFail($tr_id);
        $trainer->status=1;
        $trainer->save();
        
        alert()->success('Trainer has been Activated', 'Job Done')->autoclose(3000);
        return Redirect()->back();

    }
}
