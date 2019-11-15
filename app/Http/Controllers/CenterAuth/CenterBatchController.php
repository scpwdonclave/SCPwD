<?php

namespace App\Http\Controllers\CenterAuth;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Batch;
use Crypt;
use Auth;

class CenterBatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('center');
    }

    protected function guard()
    {
        return Auth::guard('center');
    }

    protected function decryptThis($id){
        try {
            return Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    public function batches(){
        $data = [
            'data' => Batch::where('tc_id',$this->guard()->user()->id)->get()
        ];
        return view('common.batches')->with($data);
    }

    public function viewBatch($id){
        if ($id=$this->decryptThis($id)) {
            $batchData=Batch::findOrFail($id);
            if ($batchData->center->id==$this->guard()->user()->id) {
                return view('common.view-batch')->with(compact('batchData'));
            }
        }
    }
}
