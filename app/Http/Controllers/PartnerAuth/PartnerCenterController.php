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
        if ($request->has('checkredundancy')) {
            if (Center::where($request->section,$request->checkredundancy)->first()) {
                return response()->json(['success' => false], 200);
            } else {
                return response()->json(['success' => true], 200);
            }
        } else {
            dd($request);
            $data=DB::table('centers')
            ->select(\DB::raw('SUBSTRING(tc_id,3) as tc_id'))
            ->where("tc_id", "LIKE", "TC%")->get();
            $year = date('Y');
            if (count($data) > 0) {
                $priceprod = array();
                    foreach ($data as $key=>$data) {
                        $priceprod[$key]=$data->tc_id;
                    }
                    $lastid= max($priceprod);
                
                    $new_tcid = (substr($lastid, 0, 4)== $year) ? 'TC'.($lastid + 1) : 'TC'.$year.'000001';
                //dd($new_TCid);
            } else {
                $new_tcid = 'TC'.$year.'000001';
            }
        

            $center = new Center;
            $center->tp_id = Auth::guard('partner')->user()->id;
            $center->tc_id = $new_tcid;
            $center->spoc_name = $request->spoc_name;
            $center->email = $requesemailame;
            $center->mobile = $request->mobile;
            $center->center_name = $request->center_name;
            $center->center_address = $request->center_address;
            $center->landmark = $request->landmark;
            $center->state_district = $request->state_district;
            $center->city = $request->city;
            $center->block = $request->block;
            $center->parliament = $request->parliament;
            $center->pin = $request->pin;
            $center->addr_proof = $request->addr_proof;
            $center->addr_doc = $request->addr_doc;
            $center->center_front_view = $request->center_front_view;
            $center->center_back_view = $request->center_back_view;
            $center->center_right_view = $request->center_right_view;
            $center->center_left_view = $request->center_left_view;
            $center->biometric = $request->bio_room;
            $center->drinking = $request->drink_room;
            $center->safety = $request->safety_room;



        }

    }
}