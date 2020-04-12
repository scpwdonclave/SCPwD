<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TotToaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin','prevent-back-history']);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function trainers()
    {
        return view('admin.tot-toa.trainers');
    }
    
    public function addTrainerCert()
    {
        return view('admin.tot-toa.add-tot-cert');
    }

    public function assessors()
    {
        return view('admin.tot-toa.assessors');
    }

    public function addAssessorCert()
    {
        return view('admin.tot-toa.add-toa-cert');
    }
}
