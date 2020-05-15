<?php

namespace App\Http\Controllers;

use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\TotBatchAssessmentTrainerMap;


class QrController extends Controller
{
    public function qrData($id){
        
        $centerCandidate=CenterCandidateMap::where('digital_key',$id)->first();
        if ($centerCandidate) {
            if (!is_null($centerCandidate->certi_no)) {
                return view('common.certificate-digital')->with(compact('centerCandidate'));
            }    
        }
        return abort(404);

    }

    public function qrDataTot($id)
    {
        $tot=TotBatchAssessmentTrainerMap::where('digital_key',$id)->first();
        if ($tot) {
            if (!is_null($tot->grade)) {
                return view('admin.tot-toa.certificate-digital')->with(compact('tot'));
            }    
        }
    }
   
}
