<?php

namespace App\Http\Controllers\AssessorAuth;

use Auth;
use App\Notification;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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

    public function notifications()
    {
        $notifications = Notification::where([['rel_with','assessor'],['rel_id',$this->guard()->user()->id]])->get();
        return view('common.notifications')->with(compact('notifications'));
    }

    public function clearNotifications(Request $request)
    {   
        $request->validate([
            'dismiss'=>'required',
        ]);

        $notifications = Notification::where([['rel_with','assessor'],['rel_id',$this->guard()->user()->id],['read',0]])->get();
        
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
            if ($notification->rel_with === 'assessor' && $this->guard()->user()->id == $notification->rel_id) {
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
