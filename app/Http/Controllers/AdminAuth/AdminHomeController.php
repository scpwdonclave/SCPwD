<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JobRole;
use App\Partner;
use App\Center;
use App\Candidate;
use App\Expository;
use App\Sector;
use App\Scheme;
use App\Holiday;

class AdminHomeController extends Controller
{
    
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function dashboard(){

        $test=[
            'period'=> '2011',
            'Project1'=> 0,
            'Project2'=> 0,
            'Project3'=> 115
        
        
    ];
    $test=json_encode($test);
    $rr=array();
    $rr[0]=$test;
    
        $data = [ 
            'partners' => Partner::all(),
            'centers' => Center::all(),
            'candidates' => Candidate::all(),
        ];

        return view('admin.home')->with($data)->with($rr);
    }
    
    public function job_roles(){

        $sectors = Sector::all();
        $expositories = Expository::all();
        $jobroles = JobRole::all();
        return view('admin.dashboard.jobroles')->with(compact('sectors','expositories','jobroles'));
    }
    
    public function job_roles_action(Request $request){
        if ($request->has('sector')) {
            return $this->dispatchNow(new \App\Jobs\AddSector($request));
        } else if ($request->has('sector_id')) {
            return $this->dispatchNow(new \App\Jobs\AddJobRole($request));
        } else if ($request->has('expository')) {
            return $this->dispatchNow(new \App\Jobs\AddExpository($request));
        } else if ($request->has('section')) {
            switch ($request->section) {
                case 'Sector':
                    return $this->dispatchNow(new \App\Jobs\RemoveSector($request));
                break;
                case 'Expository':
                    return $this->dispatchNow(new \App\Jobs\RemoveExpository($request));
                break;
                case 'JobRole':
                    return $this->dispatchNow(new \App\Jobs\RemoveJobRole($request));
                break;    
                default:
                    return abort(404);
                    break;
            }
        }
        return abort(404);
    }


    public function scheme(){
        $schemes = Scheme::all();
        return view('admin.dashboard.scheme')->with(compact('schemes'));
    }

    public function scheme_action(Request $request){
        if ($request->has('scheme')) {
            return $this->dispatchNow(new \App\Jobs\AddScheme($request));
        } else if ($request->has('name')) {
            return $this->dispatchNow(new \App\Jobs\UpdateScheme($request));
        }
    }

    public function holiday(){
        $holidays = Holiday::all();
        return view('admin.dashboard.holiday')->with(compact('holidays'));
    }
    public function holidayInsert(Request $request){
        
        $holiday = new Holiday;
        $holiday->holiday_name=$request->holiday_name;
        $holiday->holiday_date=$request->holiday_date;
        $holiday->save();
        alert()->success("Holiday Added <span style='color:blue;'>Successfully</span>", "Done")->html()->autoclose(4000);
        return Redirect()->back();
        
    }

    public function holidayDelete(Request $request){
        $data=Holiday::findOrFail($request->id);
        $data->delete();
        return response()->json(['status' => 'done'],200);

    }

}
