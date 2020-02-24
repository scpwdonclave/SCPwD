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
use Carbon\Carbon;
use App\PaymentOrderAgencyBatchMap;

class AdminPaymentOrderController extends Controller
{   
     public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']); 
    }

    public function pendingPayOrderRequest(){

        $pay_order=PaymentOrder::where('verified',0)->get();
        return view('admin.paymentorder.pay_order_pending')->with(compact('pay_order'));
    }
    public function viewPayOrder($id){
        $id= AppHelper::instance()->decryptThis($id);
       // PaymentOrder::where('postal', $postal)->firstOrFail();
        $pay_order=PaymentOrder::findOrFail($id);//where([['verified','=',0],['id','=',$id]])->firstOrFail();
        return view('admin.paymentorder.view-payorder')->with(compact('pay_order'));
    }

    public function closedPayOrderRequest(){
        $pay_order=PaymentOrder::where('verified',1)->get();
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
        $pay_order->delete();
        alert()->success("Payment Order has been <span style='color:red;font-weight:bold'>Rejected</span>", 'Job Done')->html()->autoclose(3000);

        return redirect()->route('admin.paymentorder.pending-request');
 
    }

    public function paymentOrderAccept(Request $request){
        $pay_order=PaymentOrder::findOrFail($request->po_id);
        $data=DB::table('payment_orders')
        ->select(\DB::raw('SUBSTRING(payment_order_id,3) as payment_order_id'))
        ->where("payment_order_id", "LIKE", "PO%")->get();
        $year =( date('m') > 3) ? date('y').(date('y') + 1) : (date('y')-1).date('y');

        if (count($data) > 0) {

            $priceprod = array();
                foreach ($data as $key=>$data) {
                    $priceprod[$key]=$data->payment_order_id;
                }
                $lastid= max($priceprod);
               
                $new_poid = (substr($lastid, 0, 4)== $year) ? 'PO'.($lastid + 1) : 'PO'.$year.'000001' ;
        } else {
            $new_poid = 'PO'.$year.'000001';
        }
        $pay_order->payment_order_id=$new_poid;
        $pay_order->verification_date=Carbon::parse($request->verification_date)->format('Y-m-d');
        $pay_order->payment_date=Carbon::parse($request->payment_date)->format('Y-m-d');
        $pay_order->verified=1;
        $pay_order->save();

        alert()->success("Payment Order ID: <span style='color:blue;font-weight:bold'>".$new_poid."</span>  has been <span style='color:blue;font-weight:bold'>Approved</span>", 'Job Done')->html()->autoclose(3000);

        return redirect()->route('admin.paymentorder.pending-request');


    }
}
