<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class ChartsController extends BaseController
{
    function morris(){
    	return view('charts.morris');
    }

    function flot(){
    	return view('charts.flot');
    }

    function chartjs(){
        return view('charts.chartjs');
    }

    function jqueryKnob(){
    	return view('charts.jquery-knob');
    }
    
    function sparkline(){
    	return view('charts.sparkline');
    }

    function c3(){
        return view('charts.c3');
    }

    function echart(){
        return view('charts.echart');
    }
}
