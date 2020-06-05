<?php

namespace App\Http\Controllers\AdminAuth;

use Auth;
use App\Complain;
use Carbon\Carbon;
use App\ComplainFile;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Events\AdminMailEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;




class AdminSupportController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']); 
    }

    public function pendingRequest(){
        $switch='pending';
        $complain=Complain::where('stage','!=','Closed')->get();
        return view('admin.support.pending-complain')->with(compact('complain','switch'));
     
    }
    public function closedRequest(){
        $switch='closed';
        $complain=Complain::where('stage','=','Closed')->get();
        return view('admin.support.pending-complain')->with(compact('complain','switch'));
     
    }

    public function viewComplain($id){
        $id= AppHelper::instance()->decryptThis($id);
        $complain=Complain::findOrFail($id);

        return view('common.view-complain-details')->with(compact('complain'));
    }
    public function assignRequestToOnclave($id){
        $id= AppHelper::instance()->decryptThis($id);
        $complain=Complain::findOrFail($id);
        $complain->assign_onclave=1;

        event(new AdminMailEvent($complain));
        
        $complain->save();
        alert()->success("Complain ID: <span style='color:blue;font-weight:bold'>".$complain->token_id." </span><br> has been Assigned to <span style='color:blue;font-weight:bold'>Onclave Systems Pvt Ltd. </span>", 'Job Done')->html()->autoclose(4000);
        return Redirect()->back();
    }

    public function stageProcess(Request $request){

        if ($data = AppHelper::instance()->decryptThis($request->data)) {
            $complain=Complain::findOrFail($data);
            $complain->stage='Processing';
            $complain->process_at=Carbon::now();
            $complain->save();
            AppHelper::instance()->writeNotification($complain->rel_id,$complain->rel_with,'Support Status Updated',"Your Support Request (ID: <span style='color:blue;'>$complain->token_id</span>) is now under <span style='color:blue;'>Processing</span>.", route($complain->rel_with.'.support.complain-view', Crypt::encrypt($data)));
            alert()->success("Complain (ID: <span style='color:blue;font-weight:bold'>".$complain->token_id." </span>) Changed <br>its stage as <span style='color:blue;font-weight:bold'>Processing</span>", 'Job Done')->html()->autoclose(5000);
            return redirect()->back();
        }
    }

    public function stageClose(Request $request)
    {
        $request->validate([
            'cid' => 'required',
            'comment' => 'required',
            'attachment' => 'nullable|file',
        ]);
        
        if ($data = AppHelper::instance()->decryptThis($request->cid)) {
            $complain=Complain::findOrFail($data);
            if ($complain->stage==='Initiated') {
                $complain->process_at=Carbon::now(); 
            }
            $complain->closure_comment = $request->comment;
            if ($request->has('attachment')) {
                $complain->attachment = Storage::disk('myDisk')->put('/complainfile', $request->attachment);
            }
            $complain->stage='Closed';
            $complain->closed_at=Carbon::now();
            $complain->save();
            AppHelper::instance()->writeNotification($complain->rel_id,$complain->rel_with,'Support Status Updated',"Your Support Request (ID: <span style='color:blue;'>$complain->token_id</span>) is now marked as <span style='color:red;'>Closed</span>.", route($complain->rel_with.'.support.complain-view', Crypt::encrypt($data)));
            alert()->success("Complain (ID: <span style='color:blue;font-weight:bold'>".$complain->token_id." </span>) Changed <br>its stage as <span style='color:blue;font-weight:bold'>Closed</span>", 'Job Done')->html()->autoclose(5000);
            return redirect()->back();
        }
    }
}
