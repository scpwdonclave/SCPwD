<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Batch;
use Auth;

class PartnerBatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('partner');
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function batches(){

        $data = [
            'partner' => $this->guard()->user(),
            'data' => Batch::where([['verified','=',1],['tp_id','=',$this->guard()->user()]])->get()
        ];
        // $partner = Auth::guard('partner')->user();
        return view('common.batches')->with($data);
    }

    public function addbatch(){

        return view('partner.batches.addbatch');
    }
}
