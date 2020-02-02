<?php

namespace App\Http\Controllers\AdminAuth;

use App\Reassessment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminReAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function allReAssessment()
    {
        return 'Coming Soon';
    }

    public function pendingReAssessment()
    {
        return 'Coming Soon';
    }
    public function viewReAssessment(Request $request)
    {
        return 'Coming Soon';
    }
    public function reassessmentAccept(Request $request)
    {
        return 'Coming Soon';
    }
    public function reassessmentReject(Request $request)
    {
        return 'Coming Soon';
    }
    public function requestsReAssessment(Request $request)
    {
        $reassessments = Reassessment::all();
        return view('admin.reassessment.requests')->with(compact('reassessments'));
    }
    public function viewRequestReAssessment(Request $request)
    {
        dd($request);
    }
    
}
