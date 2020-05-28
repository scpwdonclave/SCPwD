<?php

namespace App\Http\Controllers;

use App\CenterCandidateMap;
use Illuminate\Http\Request;
use App\TotBatchAssessmentTrainerMap;
use App\ToaBatchAssessmentAssessorMap;


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

    public function qrDataTotToa($id)
    {
        if (substr($id, -1)) {
            $batchMapData=TotBatchAssessmentTrainerMap::where('digital_key',$id)->first();
            $tag = 'tot';
            if ($batchMapData) {
                if (!is_null($batchMapData->grade)) {
                    return view('admin.tot-toa.certificate-digital')->with(compact('batchMapData','tag'));
                }    
            }
        } else {
            $batchMapData=ToaBatchAssessmentAssessorMap::where('digital_key',$id)->first();
            $tag = 'toa';
            if ($batchMapData) {
                if (!is_null($batchMapData->grade)) {
                    return view('admin.tot-toa.certificate-digital')->with(compact('batchMapData','tag'));
                }    
            }
        }
        return abort(404);
    }
   
}
