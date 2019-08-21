<?php

namespace App\Http\Controllers\Partner\Auth;

use App\Partner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Mail\TPVerificationMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new admins as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/partner';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('partner.guest:partner');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'spoc_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:partners',
            'mobile' => 'required|regex:/[0-9]{10}/|unique:partners',
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        
        Session::flash('message', 'Account Created, Please Check your Mail'); 
        Session::flash('alert-class', 'alert-success');

        return redirect()->back();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Partner
     */
    protected function create(array $data)
    {
        $data['password'] = str_random(8);
        return Partner::create([
            'name' => $data['name'],
            'spoc_name' => $data['spoc_name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            Mail::to($data['email'])->send(new TPVerificationMail($data))
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('partner.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('partner');
    }

}
