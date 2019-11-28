<?php

namespace App\Http\Controllers;

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

    public function mail()
    {
        $data = [
            'initial' => 'Let\'s Get Started.',
            'name' => 'Shouvik Mohanta',
            'message' => '<p>Welcome to Skill Council for Persons with Disability (SCPwD). Please log in to the portal using the following credentials:</p><br><p>Login ID: <strong><span style="color:#0000CD;">TC2019000001</span></strong></p><p >Password: <strong><span style="color:#0000FF;">WljDNWYN</span></strong></p><p><strong><span style="color:#0000FF;"></span></strong></p><br><p>You can only use these <strong><i>above credentials</i></strong> to login, From now onwords your email id will <strong><i>not be accepted</i></strong> as a <strong><i>valid credentials</i></strong> for Login .</p>',
            'confirmBtnText' => 'Get Started',
            'confirmBtnLink' => route('admin.login'),
        ];
        return view('emails.email')->with($data);
    }
}
