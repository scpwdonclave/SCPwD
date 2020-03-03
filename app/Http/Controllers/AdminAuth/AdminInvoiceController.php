<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Scheme;
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
        // $scheme = Scheme::findOrFail($request->scheme);
        // return response()->json(['partner' => $scheme->partners],200); 
        


      $partnersJob=PartnerJobrole::where('scheme_id',$request->scheme)->get();

      foreach ($partnersJob as $partnerJob) {
        $partnerJob->tpid = $partnerJob->partner->tp_id;
      }
        return response()->json(['partnerJob' => $partnersJob],200); 
    }
}
