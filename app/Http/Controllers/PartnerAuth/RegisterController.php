<?php

namespace App\Http\Controllers\PartnerAuth;

use App\Partner;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\TPVerificationMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Mail;
use App\Notification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/partner/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('partner.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'spoc_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:partners',
            'spoc_mobile' => 'required|regex:/[0-9]{10}/|unique:partners',
            'incorp_doc' => 'required|mimes:jpeg,jpg,png,pdf'
        ]);
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        /* Updating Notification */
        /* For Partner */
        $notification = new Notification;
        $notification->rel_id = $user->id;
        $notification->rel_with = 'partner';
        $notification->title = 'Activate your Account';
        $notification->message = 'Kindly Complete your Full Registration to gain Full Access.';
        $notification->save();
        /* End Updating Notification */
        
        Session::flash('message', 'Account Created, Please Check your Mail'); 
        Session::flash('alert-class', 'alert-success');

        return redirect()->back();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Partner
     */
    protected function create(array $data)
    {
        $data['password'] = str_random(8);

        $path = Storage::disk('myDisk')->put('/partners', $data['incorp_doc']);
        return Partner::create([
            'spoc_name' => $data['spoc_name'],
            'tp_id' => $data['email'],
            'email' => $data['email'],
            'spoc_mobile' => $data['spoc_mobile'],
            'incorp_doc' => $path,
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
