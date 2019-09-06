<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hesto\MultiAuth\Traits\LogsoutGuard;

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
    public $redirectTo = '/partner/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('partner.guest', ['except' => 'logout']);
    }

    /* Logout Route */
    public function logoutToPath() {
        return '/partner';
    }
    /* End Logout Route */

    /* Overriding default username() */
    public function username()
    {
        return 'tp_id';
    }

    /* Overriding credentials() for checking account activation status */
    protected function credentials(Request $request)
    {        
        return ['tp_id' => $request->tp_id, 'password' => $request->password, 'status' => 1];
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('partner.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('partner');
    }
}
