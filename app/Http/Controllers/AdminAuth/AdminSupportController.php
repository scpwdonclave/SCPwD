<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Complain;
use App\ComplainFile;
use Auth;
use App\Helpers\AppHelper;
use Carbon\Carbon;




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

    public function stageDefine(Request $request){
        $complain=Complain::findOrFail($request->comp_id);
        $complain->stage=$request->stage;
        if($request->stage==='Processing'){
            $complain->process_at=Carbon::now()->format('Y-m-d');
        }else if ($request->stage==='Closed') {
            if($complain->process_at===null){
                $complain->process_at=Carbon::now()->format('Y-m-d'); 
                $complain->closed_at=Carbon::now()->format('Y-m-d'); 
            }else{
                $complain->closed_at=Carbon::now()->format('Y-m-d'); 

            }
        }
        $complain->save();

        alert()->success("Complain ID: <span style='color:blue;font-weight:bold'>".$complain->token_id." </span> has been changed to <span style='color:blue;font-weight:bold'>".$request->stage." </span> Stage", 'Job Done')->html()->autoclose(4000);
        return Redirect()->back();
    }
}