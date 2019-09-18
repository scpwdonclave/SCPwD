<?php

namespace App\Http\Controllers\PartnerAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Center;
use App\Trainer;
use Auth;
use DB;

class PartnerCenterController extends Controller
{

    public function __construct()
    {
        $this->middleware('partner');
    }

    protected function guard()
    {
        return Auth::guard('partner');
    }

    public function centers(){
        // $data = [
        //     'partner'  => Auth::guard('partner')->user(),
        //     'parliaments'   => DB::table('parliament')->get(),
        //     'states'   => DB::table('state_district')->get(),
        //     'centers'   => Center::where('tp_id', Auth::guard('partner')->user()->id)->get()
        // ];
        
        $partner = Auth::guard('partner')->user();
        $centers = Center::where('tp_id', $partner->id)->get();

        return view('partner.centers.centers')->with(compact('centers','partner'));
    }

    public function trainers(){
        $partner = Auth::guard('partner')->user();
        $trainers = Trainer::where('tp_id', $partner->id)->get();

        return view('partner.centers.trainers')->with(compact('trainers','partner'));
    }

    public function view_addcenter_form(){
        $data = [
            'partner'  => Auth::guard('partner')->user(),
            'parliaments'   => DB::table('parliament')->get(),
            'states'   => DB::table('state_district')->get(),
            'centers'   => Center::where('tp_id', Auth::guard('partner')->user()->id)->get()
        ];
        return view('partner.centers.addcenter')->with($data);
    }

    public function submit_addcenter_form(Request $request){
        dd($request);
    }


}
