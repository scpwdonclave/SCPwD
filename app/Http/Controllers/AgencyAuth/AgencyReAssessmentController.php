<?php

namespace App\Http\Controllers\AgencyAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgencyReAssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['agency','prevent-back-history']); 
    }

    protected function guard()
    {
        return Auth::guard('agency');
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
}
