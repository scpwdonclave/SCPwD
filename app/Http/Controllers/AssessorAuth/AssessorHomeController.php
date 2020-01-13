<?php

namespace App\Http\Controllers\AssessorAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Notification;
use Auth;

class AssessorHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['assessor','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('assessor');
    }

    public function index() {
        return view('assessor.home')->with('assessor',Auth::guard('assessor')->user());
    }

    public function profile(){
        $assessor = Auth::guard('assessor')->user();
        return view('common.profile')->with(compact('assessor'));
    }

    public function profile_update(Request $request){
        $request->validate([
            'password' => 'required',
        ]);

        $assessor = $this->guard()->user();
        $assessor->password = Hash::make($request->password);
        $assessor->save();

        alert()->success("Your <span style='font-weight:bold;color:blue'>Password</span> has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(4000);
        return redirect()->back();
    }
}
