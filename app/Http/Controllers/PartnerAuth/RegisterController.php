<?php

namespace App\Http\Controllers\PartnerAuth;

use Mail;
use Validator;
use App\Partner;
use App\Mail\TPMail;
use App\Notification;
use App\Helpers\AppHelper;
use App\Events\TPMailEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Events\NewPartnerHasRegisteredEvent;
use Illuminate\Foundation\Auth\RegistersUsers;

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
            'g-recaptcha-response' => 'required|captcha',
            'spoc_name' => 'required|max:255',
            'incorp_doc' => 'required|mimes:jpeg,jpg,png,pdf',
            'email' => [
                'required',
                'email',
                'unique:admins,email',
                'unique:partners,email',
                'unique:centers,email',
                'unique:trainer_statuses,email',
                'unique:agencies,email',
                'unique:assessors,email',
                'unique:candidates,email',
            ],
            'spoc_mobile' => [
                'required',
                'numeric',
                'min:10',
                'unique:partners,spoc_mobile',
                'unique:centers,mobile',
                'unique:trainer_statuses,mobile',
                'unique:agencies,mobile',
                'unique:assessors,mobile',
                'unique:candidates,contact',
            ],
        ]);
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        AppHelper::instance()->writeNotification($user->id,'partner','Activate your Account',"Kindly Complete your Full Registration to gain Full Access.");        
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
        $dataMail = collect();
        $dataMail->password = $data['password'] = str_random(8);
        $dataMail->spoc_name = $data['spoc_name'];
        $dataMail->email = $data['email'];
        $dataMail->tag = 'tpverifiation'; // * Mailling Tag

        $path = Storage::disk('myDisk')->put('/partners', $data['incorp_doc']);
        return Partner::create([
            'spoc_name' => $data['spoc_name'],
            'tp_id' => $data['email'],
            'email' => $data['email'],
            'spoc_mobile' => $data['spoc_mobile'],
            'incorp_doc' => $path,
            'password' => Hash::make($data['password']),
            event(new TPMailEvent($dataMail))
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
