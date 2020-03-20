<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentOrder;
use App\Batch;
use App\Reason;
use App\Reassessment;
use App\Helpers\AppHelper;
use DB;
use Crypt;
use Carbon\Carbon;
use App\PaymentOrderAgencyBatchMap;

class AdminPaymentOrderController extends Controller
{   
     public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']); 
    }

    public function pendingPayOrderRequest(){
        // $shellexec = exec('getmac');//shell_exec('getmac');
        // dd($shellexec);
        $pay_order=PaymentOrder::where('payment_done',0)->get();
        return view('admin.paymentorder.pay_order_pending')->with(compact('pay_order'));
    }
    public function viewPayOrder($id){
        $id= AppHelper::instance()->decryptThis($id);
       // PaymentOrder::where('postal', $postal)->firstOrFail();
        $pay_order=PaymentOrder::findOrFail($id);//where([['verified','=',0],['id','=',$id]])->firstOrFail();
        return view('admin.paymentorder.view-payorder')->with(compact('pay_order'));
    }

    public function closedPayOrderRequest(){
        $pay_order=PaymentOrder::where('payment_done',1)->get();
        return view('admin.paymentorder.pay_order_closed')->with(compact('pay_order'));
    }

    public function viewBatch($id){
        if ($id= AppHelper::instance()->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            return view('common.view-assessment-batch')->with(compact('batchData'));
        }
    } 

    public function viewBatchReassessment($id){
        $id= AppHelper::instance()->decryptThis($id);
        $reassessment=Reassessment::findOrFail($id);
       
        return view('common.view-reassessment-batch')->with(compact('reassessment'));

    }

    public function paymentOrderReject($id,$reason){
        $id= AppHelper::instance()->decryptThis($id);
        $pay_order=PaymentOrder::where([['verified','=',0],['id','=',$id]])->firstOrFail();
        AppHelper::instance()->writeNotification($pay_order->agency->id,'agency', 'Payment Order Rejected',"Your Requested Payment Order has been <span style='color:red;'>Rejected</span>.",NULL);
        
        $pay_order->delete();

        alert()->success("Payment Order has been <span style='color:red;font-weight:bold'>Rejected</span>", 'Job Done')->html()->autoclose(3000);

        return redirect()->route('admin.paymentorder.pending-request');
 
    }

    public function paymentOrderAccept(Request $request){
        $pay_order=PaymentOrder::findOrFail($request->po_id);
        if($request->has('verify')){
            $pay_order->verification_date=Carbon::parse($request->verification_date)->format('Y-m-d');
            $pay_order->verified=1;
            $arr1=[];
            $arr2=[];
            foreach ($pay_order->paymentorder as $key => $value) {
                array_push($arr1,$value->aa_batch_id);
            }
            foreach ($request->chkbox as $key => $item) {
                array_push($arr2,$item);
            }

            $result = array_diff($arr1, $arr2);
            PaymentOrderAgencyBatchMap::whereIn('aa_batch_id', $result)->delete();

            AppHelper::instance()->writeNotification($pay_order->agency->id,'agency', 'Payment Order Verified',"Your Requested Payment Order (ID <span style='color:blue;'>$pay_order->payment_order_id</span>) has <span style='color:blue;'>Verified</span>.",route('agency.payorder.mypayorder',Crypt::encrypt($pay_order->id)));
            alert()->success("Payment Order (ID: <span style='color:blue;font-weight:bold'>".$pay_order->payment_order_id."</span>) has been <span style='color:blue;font-weight:bold'>Verified</span>", 'Job Done')->html()->autoclose(3000);
            
        }
        if($request->has('paymentMade')){
            
            $pay_order->payment_date=Carbon::parse($request->payment_date)->format('Y-m-d');
            $pay_order->payment_done=1;
            AppHelper::instance()->writeNotification($pay_order->agency->id,'agency', 'Payment Order Completed',"Your Payment Order (ID <span style='color:blue;'>$pay_order->payment_order_id</span>) has <span style='color:blue;'>Completed</span>.",route('agency.payorder.mypayorder',Crypt::encrypt($pay_order->id)));
            alert()->success("Payment Order (ID: <span style='color:blue;font-weight:bold'>".$pay_order->payment_order_id."</span>) is <span style='color:blue;font-weight:bold'>Completed</span>", 'Job Done')->html()->autoclose(3000);
            
        }
        
        
        $pay_order->save();
        
        

        return redirect()->route('admin.paymentorder.pending-request');


    }
}
