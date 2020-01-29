<?php

namespace App\Http\Controllers\AgencyAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notification;
use Auth;

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
        
            $agency = $this->guard()->user();
            $request->validate([
                'password' => 'required',
            ]);
            $agency->password =  Hash::make($request->password);
            $agency->save();
            
            alert()->success("Your <span style='color:blue'>Password</span> has been <span style='color:blue'>Modified</span>",'Awesome')->html()->autoclose('4000');
            return redirect()->back();
    }
}
