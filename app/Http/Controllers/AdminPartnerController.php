<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminPartnerController extends Controller
{

    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function partners(){
        return view('admin.partners.partners');
    }
}
