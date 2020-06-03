<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;
use App\Events\NewPartnerHasRegisteredEvent;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        return view('common.index');
    }

}
