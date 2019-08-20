<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

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

}