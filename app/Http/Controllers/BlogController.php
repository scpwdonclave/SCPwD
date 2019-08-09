<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class BlogController extends BaseController
{
    function dashboard(){
    	return view('blog.dashboard');
    }

    function blogPost(){
    	return view('blog.blog-post');
    }

    function blogList(){
    	return view('blog.blog-list');
    }

    function blogGrid(){
    	return view('blog.blog-grid');
    }

    function blogDetail(){
    	return view('blog.blog-detail');
    }
}