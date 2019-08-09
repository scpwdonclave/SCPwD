<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{
    function dashboard(){
    	return view('dashboard.dashboard');
    }

    function dashboard2(){
    	return view('dashboard.dashboard2');
    }

    function dashboard3(){
    	return view('dashboard.dashboard3');
    }
}