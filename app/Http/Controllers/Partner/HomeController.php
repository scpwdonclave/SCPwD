<?php

namespace App\Http\Controllers\Partner;

use App\Http\Requests\TPFormValidation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    protected $redirectTo = '/partner/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('partner.auth:partner');
    }

    /**
     * Show the Partner dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('partner.home');
    }

    /* View The Complete Registrattion Form */
    public function showCompleteRegistrationForm(){
        return view('partner.completeregistration');
    }

    /* Submit Complete Registration Form Data */
    public function submitCompleteRegistrationForm(Request $request){
        dd($request);
        //    return 'Form Validated';
    }
}