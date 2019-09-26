<?php

namespace App\Http\Controllers\CenterAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
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

    public function profile_update(Request $request){
        $request->validate([
            'password' => 'required',
        ]);

        if (Gate::allows('center-profile-active-verified', Auth::shouldUse('center'))) {
            $center = Auth::guard('center')->user();
            $center->password = Hash::make($request->password);
            $center->save();

            alert()->success("Your <span style='font-weight:bold;color:blue'>Password</span> has been <span style='font-weight:bold;color:blue'>Updated</span>", 'Job Done')->html()->autoclose(4000);
            return redirect()->back();
        } else {
            
        }
        

    }

    public function jobroles(){
        $data = [
            'center' => Auth::guard('center')->user(),
            'jobroles' => CenterJobRole::where('tc_id',Auth::guard('center')->user()->id)->get()
        ];
        return view('common.jobroles')->with($data);
    }
}
