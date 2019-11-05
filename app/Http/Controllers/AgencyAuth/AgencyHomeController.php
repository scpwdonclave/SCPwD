<?php

namespace App\Http\Controllers\AgencyAuth;


// use App\Http\Requests\CandidateFormValidation;
// use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
// use App\CenterJobRole;
use App\Notification;
// use App\Candidate;
use Auth;
// use DB;

class AgencyHomeController extends Controller
{
    public function index() {
        return view('agency.home')->with('agency',Auth::guard('agency')->user());
    }

    public function profile(){
        $agency = Auth::guard('agency')->user();
        return view('common.profile')->with(compact('agency'));
    }

    public function profile_update(Request $request){
        dd($request);
    }
}
