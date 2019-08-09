<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class PagesController extends BaseController
{
    function blankPage(){
    	return view('pages.blank-page');
    }

    function profile(){
    	return view('pages.profile');
    }

    function imageGallery(){
    	return view('pages.image-gallery');
    }
    
    function timeline(){
    	return view('pages.timeline');
    }

    function pricing(){
        return view('pages.pricing');
    }

    function invoices(){
        return view('pages.invoices');
    }

    function searchResults(){
        return view('pages.search-results');
    }

    function faq(){
        return view('pages.faq');
    }
}
