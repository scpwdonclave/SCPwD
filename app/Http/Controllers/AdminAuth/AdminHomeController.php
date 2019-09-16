<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\JobRole;
use App\Expository;
use App\Sector;

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
        return view('admin.home');
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

}
