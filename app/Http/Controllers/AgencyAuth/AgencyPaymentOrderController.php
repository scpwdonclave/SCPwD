<?php

namespace App\Http\Controllers\AgencyAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AgencyBatch;
use App\PaymentOrder;
use App\PaymentOrderAgencyBatchMap;
use App\Center;
use App\Batch;
use App\Reassessment;
use App\Helpers\AppHelper;
use Auth;
use DB;
use Carbon\Carbon;



class AgencyPaymentOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['agency','prevent-back-history']); 
    }

    protected function guard()
    {
        return Auth::guard('agency');
    }

    public function tcWiseOrder(){
        $center=collect();
       $pay_ordr= DB::table('payment_order_agency_batch_maps')->select('aa_batch_id')->get();
       $data=[];
       foreach ($pay_ordr as $pay_ordr) {
         array_push($data,$pay_ordr->aa_batch_id);
         }
        $agencyBatch=AgencyBatch::where([['aa_id','=',$this->guard()->user()->id],['aa_verified','=',1]])
        ->whereNotIn('id',$data)->get();
        
        foreach ($agencyBatch as $key => $value) {
           if($value->batch->assessment < Carbon::now()->format('Y-m-d')){
               $center->push($value->batch->center);
           }
        }
        $center=$center->unique('tc_id');
       
        return view('agency.pay-order-center-wise')->with(compact('center'));
    } 

    public function viewTcWiseOrder($id){
        $id= AppHelper::instance()->decryptThis($id);
        $center=Center::findOrFail($id);
        $aa_batch= collect();
        $pay_ordr= DB::table('payment_order_agency_batch_maps')->select('aa_batch_id')->get();
        $data=[];
        foreach ($pay_ordr as $pay_ordr) {
          array_push($data,$pay_ordr->aa_batch_id);
          }
          $agencyBatch=AgencyBatch::where([['aa_id','=',$this->guard()->user()->id],['aa_verified','=',1]])
          ->whereNotIn('id',$data)->get();
          if($agencyBatch->isEmpty()){
              return abort(404);
          }
        foreach ($agencyBatch as $key => $value) {
            if($value->reass_id===null){

                if(($value->batch->assessment < Carbon::now()->format('Y-m-d'))  && $value->batch->tc_id===$id){
                   
                    $aa_batch->push($value);
    
                }
            }else if($value->reass_id != null){
                if(($value->reassessment->assessment < Carbon::now()->format('Y-m-d'))  && $value->reassessment->tc_id===$id){
                   
                    $aa_batch->push($value);
    
                }
            } 
            
         }

         if (count($aa_batch)<1) {
             return abort(404);
         }

         //dd($aa_batch);
        return view('agency.view-payorder-tc')->with(compact('center','aa_batch'));

    }

    public function submitPayOrder(Request $request){
        
        $agencyBatch=AgencyBatch::where([['aa_id','=',$this->guard()->user()->id],['aa_verified','=',1]])->get();

        $p_order=new PaymentOrder;
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
        $p_order->payment_order_id=$new_poid;
        $p_order->ref_no=$request->ref_no;
        $p_order->aa_id=$this->guard()->user()->id;
        $p_order->po_date=Carbon::now()->format('Y-m-d');
        $p_order->save();
        foreach ($agencyBatch as $key => $value) {

            $payment_order=new PaymentOrderAgencyBatchMap;
            if($value->reass_id===null){
                if($value->batch->assessment < Carbon::now()->format('Y-m-d')  && ($value->batch->tc_id == $request->center_id)){
                   
                    $payment_order->po_id=$p_order->id;
                    $payment_order->aa_batch_id=$value->id;
                    $payment_order->save();
                    
                }
            }else if($value->reass_id != null){

                if(($value->reassessment->assessment < Carbon::now()->format('Y-m-d'))  && $value->reassessment->tc_id == $request->center_id){
                    $payment_order->po_id=$p_order->id;
                    $payment_order->aa_batch_id=$value->id;
                    $payment_order->save();

    
                }
            } 
            
         }
         alert()->success("Payment Order has Been Submitted for Review, Once <span style='color:blue'>Approved</span> or <span style='color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(5000);     
        return redirect()->route('agency.payment-order.tc-wise');

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

    public function batchWiseOrder(){
        $aa_batch= collect();
        $pay_ordr= DB::table('payment_order_agency_batch_maps')->select('aa_batch_id')->get();
        $data=[];
        foreach ($pay_ordr as $pay_ordr) {
          array_push($data,$pay_ordr->aa_batch_id);
          }
          $agencyBatch=AgencyBatch::where([['aa_id','=',$this->guard()->user()->id],['aa_verified','=',1]])
          ->whereNotIn('id',$data)->get();
       
        foreach ($agencyBatch as $key => $value) {
            if($value->reass_id===null){

                if($value->batch->assessment < Carbon::now()->format('Y-m-d')){
                   
                    $aa_batch->push($value);
    
                }
            }else if($value->reass_id != null){
                if($value->reassessment->assessment < Carbon::now()->format('Y-m-d') ){
                   
                    $aa_batch->push($value);
    
                } 
            } 
            
         }
         //dd($aa_batch->count());
        return view('agency.pay-order-batch-wise')->with(compact('aa_batch'));

    }

    public function submitPayOrderBatch(Request $request){
        if(is_null($request->chkbox)){
            alert()->error("Please Check minimum One <span style='color:blue'>Batch</span>", 'Error!')->html()->autoclose(5000);     
        return redirect()->back(); 
        }
        $p_order=new PaymentOrder;
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

        $p_order->payment_order_id=$new_poid;
        $p_order->ref_no=$request->ref_no;
        $p_order->aa_id=$this->guard()->user()->id;
        $p_order->po_date=Carbon::now()->format('Y-m-d');
        $p_order->save();
        foreach ($request->chkbox as $key => $value) {
            $payment_order=new PaymentOrderAgencyBatchMap;
            $payment_order->po_id=$p_order->id;
            $payment_order->aa_batch_id=$value;
            $payment_order->save();
           
        }
        alert()->success("Payment Order has Been Submitted for Review, Once <span style='color:blue'>Approved</span> or <span style='color:red'>Rejected</span> you will get Notified on your Email", 'Job Done')->html()->autoclose(5000);     
        return redirect()->back();

    }

    public function myPaymentOrder(){
        $pay_order=PaymentOrder::where('aa_id',$this->guard()->user()->id)->get();
        return view('agency.my-pay-order')->with(compact('pay_order'));

    }

    public function viewMyPaymentOrder($id){
       
        $id= AppHelper::instance()->decryptThis($id);
        // PaymentOrder::where('postal', $postal)->firstOrFail();
         $pay_order=PaymentOrder::where([['aa_id','=',$this->guard()->user()->id],['id','=',$id]])->firstOrFail();
         return view('agency.view-my-payorder')->with(compact('pay_order'));
    }

}
