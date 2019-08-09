@extends('layout.master')
@section('title', 'FAQs')
@section('parentPageTitle', 'Pages')
@section('content')
<div class="container-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong>Frequently</strong> Asked Questions <small>Extend the default collapse behavior to create an accordion with the panel component.</small> </h2>
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right float-right">
                            <li><a href="javascript:void(0);">Edit</a></li>
                            <li><a href="javascript:void(0);">Delete</a></li>
                            <li><a href="javascript:void(0);">Report</a></li>
                        </ul>
                    </li>
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-12 col-lg-12">
                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne_1">
                                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" aria-expanded="true" aria-controls="collapseOne_1">1. How can i delete my complaint/comment?</a> </h4>
                                </div>
                                <div id="collapseOne_1" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne_1">
                                    <div class="panel-body">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingTwo_1">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseTwo_1" aria-expanded="false"
                                            aria-controls="collapseTwo_1">2. I have posted a complaint/comment, but it doesn’t appear on the website. Why? When my complaint will be posted?</a> </h4>
                                </div>
                                <div id="collapseTwo_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_1">
                                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingThree_1">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseThree_1" aria-expanded="false"
                                            aria-controls="collapseThree_1">3. How can I edit a complaint I posted?</a> </h4>
                                </div>
                                <div id="collapseThree_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_1">
                                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="heading4">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseThree_4" aria-expanded="false"
                                            aria-controls="collapseThree_4">4. How can i find out personal information of another user?</a> </h4>
                                </div>
                                <div id="collapseThree_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="heading5">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseThree_5" aria-expanded="false"
                                            aria-controls="collapseThree_5">5. How can i contact another user?</a> </h4>
                                </div>
                                <div id="collapseThree_5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="heading6">
                                    <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseThree_6" aria-expanded="false"
                                            aria-controls="collapseThree_6">6. How much wood would a woodchuck chuck?</a> </h4>
                                </div>
                                <div id="collapseThree_6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                                    <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop