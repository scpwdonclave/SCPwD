<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scheme;
use App\Batch;
use App\PartnerJobrole;

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

    public function assessmentInvoice(Request $request){
      $partnerJob=PartnerJobrole::where([['scheme_id','=',$request->scheme],['tp_id','=',$request->partner]])->get();
      $batchassessment=collect();
      foreach ($partnerJob as $key => $value) {
        
        $batch=Batch::where('tp_job_id',$value->id)->get();
        foreach ($batch as $i => $batch) {
          //$batchassessment->push($batch->batchassessment);
          
          foreach ($batch->batchassessment as $k => $bt_assessment) {
            
          }
        }
      }
     // dd($batchassessment);

    }
}
