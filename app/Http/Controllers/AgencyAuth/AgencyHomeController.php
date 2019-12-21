<?php

namespace App\Http\Controllers\AgencyAuth;


// use App\Http\Requests\CandidateFormValidation;
// use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use App\CenterJobRole;
use App\Notification;

// use App\Candidate;
use Auth;
// use DB;

class AgencyHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['agency','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('agency');
    }

    public function index() {
        return view('agency.home')->with('agency',Auth::guard('agency')->user());
    }

    public function profile(){
        $agency = Auth::guard('agency')->user();
        return view('common.profile')->with(compact('agency'));
    }

    public function profile_update(Request $request){
        $request->validate([
            'password' => 'required',
        ]);

        
            $agency = $this->guard()->user();
            $agency->password = Hash::make($request->password);
            $agency->save();

            alert()->success("Your <span style='font-weight:bold;color:blue'>Password</span> has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(4000);
            return redirect()->back();
        
    }
}
