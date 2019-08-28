<?php

namespace App\Http\Controllers\Partner;

use App\Http\Requests\TPFormValidation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Partner;
use Auth;


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
        return (Auth::guard('partner')->user()->complete_profile) ? view('partner.home')->with('partner',Auth::guard('partner')->user()) : redirect(route('partner.comp-register'));
    }
    
    /* View The Complete Registrattion Form */
    public function showCompleteRegistrationForm(){
        return (Auth::guard('partner')->user()->complete_profile) ? redirect(route('partner.dashboard')) : view('partner.completeregistration')->with('partner',Auth::guard('partner')->user());
    }

    /* Submit Complete Registration Form Data */
    public function submitCompleteRegistrationForm(Request $request){
        dd($request);
        //    return 'Form Validated';
    }
}