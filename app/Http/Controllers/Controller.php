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

    public function test()
    {
        // $g = 'Male';

        // if (strtoupper($g) == 'MALE') {
        //     return 'true';
        // } else {
        //     return 'false';
            
        // }
        

     
        // $str = "{\"Gender\": \"MALE\", \"State\": \"West Bengal\", \"Mobile Number\": \"xxxxxxx480\", \"Age Band\": \"20-30\"}";

        // $d =  json_decode($str, true);

        // return $d;
        
        $stan = time();
        // $doc_no = '725790178663';
        $doc_no = '123412341888';
        $transmission_datetime = time();

        $response = AppHelper::instance()->aadhaarVerify($stan, $doc_no, $transmission_datetime);

        $data = json_decode($response, true);
        dump($data);

        DB::table('aadhaar_requests')->insert(
            ['guard' => 'admin', 'userid' => 1, 'username' => 'Shouvk', 'stan' => $stan, 'doc_no' => $doc_no, 'status' => $data['response_status']['status'], 'created_at' => Carbon::now()]
        );

        
        // return $data['response_status']['status'];
    }
}
