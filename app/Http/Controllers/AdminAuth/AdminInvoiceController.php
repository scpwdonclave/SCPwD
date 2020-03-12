<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\AppHelper;
use App\Scheme;
use App\Batch;
use App\Partner;
use App\Center;
use App\PartnerJobrole;
use App\Invoice;
use App\InvoiceCandidate;
use App\InvoiceJobRole;
use Carbon\Carbon;
use DB;

use Crypt;



class AdminInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']);
    }

    public function pendingInvoice(){
       $scheme=Scheme::all();
        
       return view('admin.invoice.create-invoice')->with(compact('scheme'));
    }

    public function fetchPartner(Request $request){

       $partnersJob=PartnerJobrole::where('scheme_id',$request->scheme)->get()->unique('tp_id');

      foreach ($partnersJob as $partnerJob) {
        $partnerJob->tpid = $partnerJob->partner->tp_id;
      }
        return response()->json(['partnerJob' => $partnersJob],200); 
    }

    public function fetchCenter(Request $request){
      $centers=Center::where('tp_id',$request->partner)->get();
      return response()->json(['centers' => $centers],200); 

    }

    public function assessmentInvoice(Request $request){
      $partnerJob=PartnerJobrole::where([['scheme_id','=',$request->scheme],['tp_id','=',$request->partner]])->get();
      $partner=Partner::findOrFail($request->partner);
      $scheme=Scheme::all();
      $scheme_sel=Scheme::findOrFail($request->scheme);
      $cmplt_inv_cndt=InvoiceCandidate::select('candidate_id')->where('re_assessment',0)->get();
      $cmp_cn=array();
      foreach ($cmplt_inv_cndt as  $value) {
        array_push($cmp_cn,$value->candidate_id);
      }

     
      $stack = array();
      $total_candidate=0;
      foreach ($partnerJob as $key => $value) {
        $can_cnt=0;
        
        $batch=Batch::where('tp_job_id',$value->id)->get();
        foreach ($batch as $i => $batch) {
         // $batchassessment->push($batch);
          if(!is_null($batch->batchassessment) && $batch->batchassessment->sup_admin_verified===1){
            if($scheme_sel->invoice_on===1){
              foreach ($batch->batchassessment->candidateMarks as  $cn_mark) {
               if(!in_array($cn_mark->id, $cmp_cn)){
                $can_cnt +=1;
               }
              }
              //$can_cnt += $batch->batchassessment->candidateMarks->count();

            }else{

              foreach ($batch->batchassessment->candidateMarks->where('attendence','=','present') as  $cn_mark) {
                if(!in_array($cn_mark->id, $cmp_cn)){
                 $can_cnt +=1;
                }
               }
              //$can_cnt += $batch->batchassessment->candidateMarks->where('attendence','=','present')->count();

            }
          }
          
        }
        if($can_cnt>0){
          $stack[$value->jobrole->job_role]=[$value->jobrole->sector->sector,$value->jobrole->qp_code,$can_cnt];
          $total_candidate +=$can_cnt;
        }
      }
     
      return view('admin.invoice.create-invoice')->with(compact('stack','scheme','scheme_sel','total_candidate','partner'));
     


    }

    public function submitInvoice(Request $request){
     
      $partnerJob=PartnerJobrole::where([['scheme_id','=',$request->scheme],['tp_id','=',$request->partner]])->get();
     
      $scheme_sel=Scheme::findOrFail($request->scheme);
      $cmplt_inv_cndt=InvoiceCandidate::select('candidate_id')->where('re_assessment',0)->get();
      $cmp_cn=array();
      foreach ($cmplt_inv_cndt as  $value) {
        array_push($cmp_cn,$value->candidate_id);
      }
     
      // $stack = array();
      // $total_candidate=0;
      $invoice= new Invoice;
      $data=DB::table('invoices')
      ->select(\DB::raw('SUBSTRING(invoice_id,3) as invoice_id'))
      ->where("invoice_id", "LIKE", "IN%")->get();
      $year =( date('m') > 3) ? date('y').(date('y') + 1) : (date('y')-1).date('y');

      if (count($data) > 0) {

          $priceprod = array();
              foreach ($data as $key=>$data) {
                  $priceprod[$key]=$data->invoice_id;
              }
              $lastid= max($priceprod);
             
              $new_inid = (substr($lastid, 0, 4)== $year) ? 'IN'.($lastid + 1) : 'IN'.$year.'000001' ;
      } else {
          $new_inid = 'IN'.$year.'000001';
      }

      $invoice->invoice_id=$new_inid;
      $invoice->tp_id=$request->partner;
      $invoice->scheme_id=$request->scheme;
      $invoice->ref_no=$request->ref_no;
      $invoice->other_ref_no=$request->other_ref_no;
      $invoice->invoice_date=Carbon::now()->format('Y-m-d');
     
      $invoice->save();


      foreach ($partnerJob as $key => $value) {
        $can_cnt=0;
        
        $batch=Batch::where('tp_job_id',$value->id)->get();
        foreach ($batch as $i => $batch) {
         // $batchassessment->push($batch);
          if(!is_null($batch->batchassessment) && $batch->batchassessment->sup_admin_verified===1){
            if($scheme_sel->invoice_on===1){
              //$can_cnt += $batch->batchassessment->candidateMarks->count();
              foreach ($batch->batchassessment->candidateMarks as $k => $cn_mark) {
                if(!in_array($cn_mark->id, $cmp_cn)){
                $invoice_candidate=new InvoiceCandidate;
                $invoice_candidate->inv_id=$invoice->id;
                $invoice_candidate->candidate_id=$cn_mark->id;
                $invoice_candidate->save();
                $can_cnt +=1;
                }
              }

            }else{
             // $can_cnt += $batch->batchassessment->candidateMarks->where('attendence','=','present')->count();
              foreach ($batch->batchassessment->candidateMarks->where('attendence','=','present') as  $cn_mark) {
                if(!in_array($cn_mark->id, $cmp_cn)){
                
                $invoice_candidate=new InvoiceCandidate;
                $invoice_candidate->inv_id=$invoice->id;
                $invoice_candidate->candidate_id=$cn_mark->id;
                $invoice_candidate->save();
                $can_cnt +=1;
                  
                }
                
               }
            }
          }
          
        }
        if($can_cnt>0){
          $invoice_job=new InvoiceJobRole;
          $invoice_job->inv_id=$invoice->id;
          $invoice_job->jobrole_id=$value->jobrole->id;
          $invoice_job->candidate_no=$can_cnt;
          $invoice_job->save();


          // $stack[$value->jobrole->job_role]=[$value->jobrole->sector->sector,$value->jobrole->qp_code,$can_cnt];
          // $total_candidate +=$can_cnt;
        }
      }

     
      
      // alert()->success("Invoice No : <span style='color:blue'>".$new_inid."</span> has Been Generated", 'Job Done')->html()->persistent("Ok");     
      $url = 'admin/invoice/print/'.Crypt::encrypt($invoice->id);
      alert()->success('<a class="btn btn-primary" href="/'.$url.'">Show Invoice</a>','Invoice: '.$new_inid)->html()->autoclose(false)->closeOnClickOutside(false);     
      return redirect()->route('admin.invoice.pending-invoice');
     

    }

    public function allInvoice(){
      $all_invoice=Invoice::all(); 
      return view('admin.invoice.all-invoice')->with(compact('all_invoice'));

    }

    public function pendingReassessmentInvoice(){

      $scheme=Scheme::all();
        
      return view('admin.invoice.create-reassessment-invoice')->with(compact('scheme'));
    }

    public function reassessmentInvoice(Request $request){
      $partnerJob=PartnerJobrole::where([['scheme_id','=',$request->scheme],['tp_id','=',$request->partner]])->get();
      $partner=Partner::findOrFail($request->partner);
      $center=Center::findOrFail($request->center);
      $scheme=Scheme::all();
      $scheme_sel=Scheme::findOrFail($request->scheme);
      $cmplt_inv_cndt=InvoiceCandidate::select('candidate_id')->where('re_assessment',1)->get();
      $cmp_cn=array();
      foreach ($cmplt_inv_cndt as  $value) {
        array_push($cmp_cn,$value->candidate_id);
      }

     
      $stack = array();
      $total_candidate=0;
      foreach ($partnerJob as $key => $value) {
        $can_cnt=0;
        
        $batch=Batch::where([['tp_job_id','=',$value->id],['tc_id','=',$request->center]])->get();
        foreach ($batch as $i => $batch) {
        
        
          if(!is_null($batch->batchreassessmentlatest) && $batch->batchreassessmentlatest->sup_admin_verified===1){
            if($scheme_sel->invoice_on===1){
              foreach ($batch->batchreassessmentlatest->candidateMarks as  $cn_mark) {
               if(!in_array($cn_mark->id, $cmp_cn)){
                $can_cnt +=1;
               }
              }
              

            }else{

              foreach ($batch->batchreassessmentlatest->candidateMarks->where('attendence','=','present') as  $cn_mark) {
                if(!in_array($cn_mark->id, $cmp_cn)){
                 $can_cnt +=1;
                }
               }
              

            }
          }
        
          
        }
        if($can_cnt>0){
          $stack[$value->jobrole->job_role]=[$value->jobrole->sector->sector,$value->jobrole->qp_code,$can_cnt];
          $total_candidate +=$can_cnt;
        }
      }
     //dd($stack);
      return view('admin.invoice.create-reassessment-invoice')->with(compact('stack','scheme','scheme_sel','total_candidate','partner','center'));
     


    }

    public function submitReassessmentInvoice(Request $request){
      $partnerJob=PartnerJobrole::where([['scheme_id','=',$request->scheme],['tp_id','=',$request->partner]])->get();
      
      
      $scheme_sel=Scheme::findOrFail($request->scheme);
      $cmplt_inv_cndt=InvoiceCandidate::select('candidate_id')->where('re_assessment',1)->get();
      $cmp_cn=array();
      foreach ($cmplt_inv_cndt as  $value) {
        array_push($cmp_cn,$value->candidate_id);
      }

     
      // $stack = array();
      // $total_candidate=0;
      $invoice= new Invoice;
      $data=DB::table('invoices')
      ->select(\DB::raw('SUBSTRING(invoice_id,3) as invoice_id'))
      ->where("invoice_id", "LIKE", "IN%")->get();
      $year =( date('m') > 3) ? date('y').(date('y') + 1) : (date('y')-1).date('y');

      if (count($data) > 0) {

          $priceprod = array();
              foreach ($data as $key=>$data) {
                  $priceprod[$key]=$data->invoice_id;
              }
              $lastid= max($priceprod);
             
              $new_inid = (substr($lastid, 0, 4)== $year) ? 'IN'.($lastid + 1) : 'IN'.$year.'000001' ;
      } else {
          $new_inid = 'IN'.$year.'000001';
      }

      $invoice->invoice_id=$new_inid;
      $invoice->tp_id=$request->partner;
      $invoice->tc_id=$request->center;
      $invoice->scheme_id=$request->scheme;
      $invoice->ref_no=$request->ref_no;
      $invoice->other_ref_no=$request->other_ref_no;
      $invoice->invoice_date=Carbon::now()->format('Y-m-d');
      $invoice->re_assessment=1;
      $invoice->save();

      foreach ($partnerJob as $key => $value) {
        $can_cnt=0;
        
        $batch=Batch::where([['tp_job_id','=',$value->id],['tc_id','=',$request->center]])->get();
        foreach ($batch as $i => $batch) {
        
        
          if(!is_null($batch->batchreassessmentlatest) && $batch->batchreassessmentlatest->sup_admin_verified===1){
            if($scheme_sel->invoice_on===1){
              foreach ($batch->batchreassessmentlatest->candidateMarks as  $cn_mark) {
               if(!in_array($cn_mark->id, $cmp_cn)){
                 $invoice_candidate=new InvoiceCandidate;
                $invoice_candidate->inv_id=$invoice->id;
                $invoice_candidate->candidate_id=$cn_mark->id;
                $invoice_candidate->re_assessment=1;
                $invoice_candidate->save();
                $can_cnt +=1;
               }
              }
              

            }else{

              foreach ($batch->batchreassessmentlatest->candidateMarks->where('attendence','=','present') as  $cn_mark) {
                if(!in_array($cn_mark->id, $cmp_cn)){
                  $invoice_candidate=new InvoiceCandidate;
                  $invoice_candidate->inv_id=$invoice->id;
                  $invoice_candidate->candidate_id=$cn_mark->id;
                  $invoice_candidate->re_assessment=1;
                  $invoice_candidate->save();
                  $can_cnt +=1;
                }
               }
              

            }
          }
        
          
        }
        if($can_cnt>0){
          $invoice_job=new InvoiceJobRole;
          $invoice_job->inv_id=$invoice->id;
          $invoice_job->jobrole_id=$value->jobrole->id;
          $invoice_job->candidate_no=$can_cnt;
          $invoice_job->save();
        }
      }
     
      $url = 'admin/invoice/print/'.Crypt::encrypt($invoice->id);
      alert()->success('<a class="btn btn-primary" href="/'.$url.'">Show Invoice</a>', 'Invoice: '.$new_inid)->html()->autoclose(false)->closeOnClickOutside(false);     
      return redirect()->route('admin.invoice.reassessment-invoice');
     
    }

   
}
