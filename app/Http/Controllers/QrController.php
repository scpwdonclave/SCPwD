<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CandidateMark;


class QrController extends Controller
{
    public function qrData($id){
        
        $candidateMark=CandidateMark::findOrFail($id);
        if($candidateMark->passed && $candidateMark->batchAssessment->supadmin_cert_rel){

            return view('common.certificate-digital')->with(compact('candidateMark'));
        }else{
            abort(404);
        }


    }
   
}
