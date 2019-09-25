<?php

namespace App\Http\Controllers\CenterAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CenterJobRole;
use Auth;

class CenterHomeController extends Controller
{
    public function index() {
        return view('center.home')->with('center',Auth::guard('center')->user());
    }

    public function profile(){
        $center = Auth::guard('center')->user();
        return view('common.profile')->with(compact('center'));
    }

    public function jobroles(){
        $data = [
            'center' => Auth::guard('center')->user(),
            'jobroles' => CenterJobRole::where('tc_id',Auth::guard('center')->user()->id)->get()
        ];
        return view('common.jobroles')->with($data);
    }
}
