<?php

namespace App\Http\Controllers\AgencyAuth;

use Auth;
use App\Notification;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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

    public function notifications()
    {
        $notifications = Notification::where([['rel_with','agency'],['rel_id',$this->guard()->user()->id]])->get();
        return view('common.notifications')->with(compact('notifications'));
    }

    public function clearNotifications(Request $request)
    {   
        $request->validate([
            'dismiss'=>'required',
        ]);

        $notifications = Notification::where([['rel_with','agency'],['rel_id',$this->guard()->user()->id],['read',0]])->get();
        
        foreach ($notifications as $notification) {
            $notification->read=1;
            $notification->read_by = $this->guard()->user()->name;
            $notification->save();
        }

        return response()->json(['success' => true],200);
    }

    public function clickNotification($id)
    {  
        if ($id=AppHelper::instance()->decryptThis($id)) {
            $notification = Notification::findOrFail($id);
            if ($notification->rel_with === 'agency' && $this->guard()->user()->id == $notification->rel_id) {
                if (!$notification->read) {
                    if (is_null($notification->url)) {
                        $route = redirect()->back();
                    } else {
                        $route = redirect($notification->url);
                    }
                    $notification->read_by = $this->guard()->user()->name;
                    $notification->read = 1;
                    $notification->save();
                    return $route;
                }
            }
        }
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
