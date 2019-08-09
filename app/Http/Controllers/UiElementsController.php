<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class UiElementsController extends BaseController
{
    function uiKit(){
    	return view('ui-elements.ui-kit');
    }

    function alerts(){
        return view('ui-elements.alerts');
    }

    function collapse(){
    	return view('ui-elements.collapse');
    }

    function colors(){
        return view('ui-elements.colors');
    }

    function dialogs(){
        return view('ui-elements.dialogs');
    }
    
    function icons(){
    	return view('ui-elements.icons');
    }

    function listGroup(){
        return view('ui-elements.list-group');
    }

    function mediaObject(){
        return view('ui-elements.media-object');
    }

    function modals(){
        return view('ui-elements.modals');
    }

    function notifications(){
    	return view('ui-elements.notifications');
    }

    function progressBars(){
        return view('ui-elements.progress-bars');
    }

    function rangeSliders(){
        return view('ui-elements.range-sliders');
    }

    function nestable(){
        return view('ui-elements.nestable');
    }
    
    function tabs(){
    	return view('ui-elements.tabs');
    }

    function waves(){
        return view('ui-elements.waves');
    }
}
