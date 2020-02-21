<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentOrder;
use App\Batch;
use App\Reassessment;
use App\Helpers\AppHelper;

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
        $pay_order=PaymentOrder::where([['verified','=',0],['id','=',$id]])->firstOrFail();
        return view('admin.paymentorder.view-payorder')->with(compact('pay_order'));
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
        // $pay_order->paymentorder->delete();
        // $pay_order->delete();
        return redirect()->route('admin.paymentorder.pending-request');

    }
}
