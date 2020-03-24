<?php

namespace App\Http\Controllers\CenterAuth;
 
use App\Center;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    public $redirectTo = '/center/dashboard';


    public function __construct()
    {
        $this->middleware('center.guest', ['except' => 'logout']);
    }

    protected function redirectTo()
    {
        return Session::get('backUrl') ? Session::get('backUrl') :   $this->redirectTo;
    }


    protected function guard()
    {
        return Auth::guard('center');
    }


    // * Logout Route
    
    public function logoutToPath() {
        return '/center';
    }

    // * End Logout Route


    // * Overriding default username()
    
    public function username()
    {
        return 'tc_id';
    }

    // * End Overriding default username()


    // * Overriding Failed Login Response
    
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans(($request->partner_status)?'auth.failed':'auth.partner_inactive')],
            ]);

    }

    // * End Overriding Failed Login Response

    
    // * Overriding credentials() for checking account activation status
    
    protected function credentials(Request $request)
    {        
        return ['tc_id' => $request->tc_id, 'password' => $request->password, 'status' => 1];
    }

    // * End Overriding credentials() for checking account activation status

    
    // * Overridding login() for checking Training Partner Status
    
    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            if ($request->partner_status) {
                return $this->sendLoginResponse($request);
            }
        }
        
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    // * End Overridding login() for checking Training Partner Status


    // * Overriding for Fetching Training Partner Status
    
    protected function attemptLogin(Request $request)
    {
        $center = Center::where('tc_id',$request->tc_id)->first();
        if ($center) {
            if ($center->partner->status) {
                $request->partner_status = 1;
                return $this->guard()->attempt(
                    $this->credentials($request), $request->filled('remember')
                );
            } else {
                $request->partner_status = 0;
                return $request;
            }
        } else {
            $request->partner_status = 1;
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
        
    }

    // * End Overriding for Fetching Training Partner Status

    public function showLoginForm()
    {
        return view('center.auth.login');
    }

}
