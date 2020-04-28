<?php

namespace App\Http\Controllers\AdminAuth;

use App\Expository;
use App\AssessmentTrainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function totBatches()
    {
        $data = [
            'tag' => 'tot',
            'records' => collect() 
        ];
        return view('admin.tot-toa.batches')->with($data);
    }

    public function toaBatches()
    {
        $data = [
            'tag' => 'toa',
            'records' => collect()
        ];
        return view('admin.tot-toa.batches')->with($data);
    }

    public function trainers()
    {
        $tots = AssessmentTrainer::all();
        return view('admin.tot-toa.trainers')->with(compact('tots'));
    }

    public function viewTrainer(Request $request)
    {
        if ($id=AppHelper::instance()->decryptThis($request->id)) {
            $tot = AssessmentTrainer::findOrFail($id);
            return view('admin.tot-toa.view-trainer')->with(compact('tot'));
        }
    }
    
    public function addTrainerCert()
    {
        $data = [
            'states' => DB::table('state_district')->get(),
            'disabilities' => Expository::all(),
        ];
        return view('admin.tot-toa.add-tot-cert')->with($data);
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
