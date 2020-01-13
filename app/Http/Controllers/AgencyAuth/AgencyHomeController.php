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
        if ($agency->name == $request->name && $agency->email == $request->email && $agency->mobile == $request->mobile && is_null($request->password)) {
            alert()->info("You Have not changed any value", 'Abort')->autoclose(3000);
            return redirect()->back();
        } else {
            $request->validate([
                'name' => 'required', 
                'password' => 'nullable',
                'email' => [
                    'required',
                    'email',
                    'unique:admins,email',
                    'unique:partners,email',
                    'unique:centers,email',
                    'unique:trainer_statuses,email',
                    'unique:agencies,email,'.$this->guard()->user()->id,
                    'unique:assessors,email',
                    'unique:candidates,email',
                ],
                'mobile' => [
                    'required',
                    'numeric',
                    'min:10',
                    'unique:partners,spoc_mobile',
                    'unique:centers,mobile',
                    'unique:trainer_statuses,mobile',
                    'unique:agencies,mobile,'.$this->guard()->user()->id,
                    'unique:assessors,mobile',
                    'unique:candidates,contact',
                ],
            ]);
            if (!is_null($request->password)) {
                $agency->password =  Hash::make($request->password);
            }
            $agency->name = $request->name;
            $agency->email = $request->email;
            $agency->mobile = $request->mobile;
            $agency->save();
            
            alert()->success("Your <span style='color:blue'>Profile</span> has been <span style='color:blue'>Updated</span>",'Awesome')->html()->autoclose('4000');
            return redirect()->back();
        }
    }
}
