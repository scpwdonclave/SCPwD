<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function centers(){
        return view('admin.centers.centers');
    }
}
