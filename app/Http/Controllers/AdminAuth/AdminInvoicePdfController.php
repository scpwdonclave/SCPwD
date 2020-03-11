<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\AppHelper;
use App\Invoice;
use App\InvoiceCandidate;
use App\InvoiceJobRole;
use PDF;
use NumberToWords\NumberToWords;


class AdminInvoicePdfController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function printInvoice($id){
        $id=AppHelper::instance()->decryptThis($id);
        $invoice=Invoice::findOrFail($id);
        $total_candidate=0;
        foreach ($invoice->invoice_job as  $value) {
           $total_candidate +=$value->candidate_no;
        }
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
       $amount_word= $numberTransformer->toWords($total_candidate*1000);

         $pdf=PDF::loadView('admin.invoice.invoice-pdf' , compact('invoice','amount_word','total_candidate'))->setPaper('a4');
        return $pdf->stream('77778'.'.pdf');
  
      }

}
