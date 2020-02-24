<?php

namespace App\Http\Controllers;

use App\CenterCandidateMap;
use Illuminate\Http\Request;


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
   
}
