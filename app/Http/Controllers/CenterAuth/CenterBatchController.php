<?php

namespace App\Http\Controllers\CenterAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('common.batches');
    }
}
