<?php

namespace App\Http\Controllers\AssessorAuth;

use App\Assessor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/assessor/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('assessor.guest', ['except' => 'logout']);
    }

    /* Logout Route */
    public function logoutToPath() {
        return '/assessor';
    }
    /* End Logout Route */
    
    /* Overriding default username() */
    public function username()
    {
        return 'as_id';
    }

    // * Overriding Failed Login Response

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans(($request->agency_status)?'auth.failed':'auth.agency_inactive')],
            ]);

    }

    // * End Overriding Failed Login Response

    /* Overriding credentials() for checking account activation status */
    protected function credentials(Request $request)
    {        
        return ['as_id' => $request->as_id, 'password' => $request->password, 'status' => 1]; 
    }

    // * Overridding login() for checking Assessment Agency Status

    public function login(Request $request)
    {
        $this->validateLogin($request);
        
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request)) {
            if ($request->agency_status) {
                return $this->sendLoginResponse($request);
            }
        }
        
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    // * End Overridding login() for checking Assessment Agency Status

    // * Overriding for Fetching Training Partner Status
    
    protected function attemptLogin(Request $request)
    {
        $assessor = Assessor::where('as_id',$request->as_id)->first();
        if ($assessor) {
            if ($assessor->agency->status) {
                $request->agency_status = 1;
                return $this->guard()->attempt(
                    $this->credentials($request), $request->filled('remember')
                );
            } else {
                $request->agency_status = 0;
                return $request;
            }
        } else {
            $request->agency_status = 1;
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
        
    }

    // * End Overriding for Fetching Training Partner Status
    public function showLoginForm()
    {
        return view('assessor.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('assessor');
    }
}
