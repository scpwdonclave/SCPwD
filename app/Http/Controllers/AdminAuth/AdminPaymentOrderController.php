<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentOrder;
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
}
