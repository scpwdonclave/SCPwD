<?php

namespace App\Http\Controllers\AdminAuth;

use PDF;
use App\TotBatch;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\TotBatchAssessmentTrainerMap;
use App\ToaBatchAssessmentAssessorMap;

class TotToaCertController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function printCertificate(Request $request)
    {
        if ($data=AppHelper::instance()->decryptThis($request->data)) {
            $id = explode(',',$data);
            $tag = $id[2];
            if ($tag) {
                // * Certificate For Trainer
                if ($id[1]) {
                    // ! Incomplete Section [Batch Download];
                    return 'Working on This';
                    
                    $tot = TotBatch::findOrFail($id[0]);
                    $pdf=PDF::loadView('admin.tot-toa.certificate', compact('tot'))->setPaper('a4','landscape'); 
                    return $pdf->stream($tot->id.'.pdf');
                } else {
                    $data = TotBatchAssessmentTrainerMap::findOrFail($id[0]);
                    
                    $pdf=PDF::loadView('admin.tot-toa.certificate', compact('data','tag'))->setPaper('a4','landscape'); 
                    return $pdf->stream($data->id.'.pdf');
                }
            } else {
                // * Certificate For Assessor
                if ($id[1]) {
                    // ! Incomplete Section [Batch Download];
                    return 'Working on This';
                    
                    // $tot = TotBatch::findOrFail($id[0]);
                    // $pdf=PDF::loadView('admin.tot-toa.certificate', compact('tot'))->setPaper('a4','landscape'); 
                    // return $pdf->stream($tot->id.'.pdf');
                } else {
                    $data = ToaBatchAssessmentAssessorMap::findOrFail($id[0]);
                    $pdf=PDF::loadView('admin.tot-toa.certificate', compact('data','tag'))->setPaper('a4','landscape'); 
                    return $pdf->stream($data->id.'.pdf');
                }
            }
        }
    }
}
