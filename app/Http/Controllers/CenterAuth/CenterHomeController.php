<?php

namespace App\Http\Controllers\CenterAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class CenterHomeController extends Controller
{
    public function index() {
        return view('center.home')->with('center',Auth::guard('center')->user());
    }
}
