<?php

namespace App\Http\Controllers\AdminAuth;

use PDF;
use App\TotBatch;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\TotBatchAssessmentTrainerMap;

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
            if ($id[1]) {
                $tot = TotBatch::findOrFail($id[0]);
                $pdf=PDF::loadView('admin.tot-toa.certificate', compact('tot'))->setPaper('a4','landscape'); 
                return $pdf->stream($tot->id.'.pdf');
                return 'Working on This';
            } else {
                $trainer = TotBatchAssessmentTrainerMap::findOrFail($id[0]);
                $pdf=PDF::loadView('admin.tot-toa.certificate', compact('trainer'))->setPaper('a4','landscape'); 
                return $pdf->stream($trainer->id.'.pdf');
            }
        }
    }
}
