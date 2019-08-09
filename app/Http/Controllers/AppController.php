<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class AppController extends BaseController
{
    function mailInbox(){
    	return view('app.mail-inbox');
    }

    function mailSingle(){
    	return view('app.mail-single');
    }

    function mailCompose(){
    	return view('app.mail-compose');
    }

    function chat(){
    	return view('app.chat');
    }

    function calendar(){
    	return view('app.calendar');
    }

    function contactList(){
    	return view('app.contact-list');
    }

    function blog(){
    	return view('app.blog');
    }

    function taskboard(){
    	return view('app.taskboard');
    }
}
