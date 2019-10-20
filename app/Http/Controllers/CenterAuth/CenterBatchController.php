<?php

namespace App\Http\Controllers\CenterAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batch;
use Auth;
use Crypt;

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

    public function batches(){
        $data = [
            'data' => Batch::where('tc_id',$this->guard()->user()->id)->get()
        ];
        return view('common.batches')->with($data);
    }

    public function viewBatch($id){
        $id = Crypt::decrypt($id);
        $batchData=Batch::findOrFail($id);
        if ($batchData->center->id==$this->guard()->user()->id) {
            return view('common.view-batch')->with(compact('batchData'));
        } else {
            return abort(401);
        }
    }
}
