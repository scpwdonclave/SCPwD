<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Center;

class AdminCenterController extends Controller 
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function centers(){

        $data=Center::all();
        return view('admin.centers.centers')->with(compact('data'));
    }
}
