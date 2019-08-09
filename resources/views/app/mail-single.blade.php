@extends('layout.master')
@section('title', 'Mail Single')
@section('parentPageTitle', 'App')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/inbox.css')}}"/>
@stop
@section('content')
<div class="container-fluid inbox">
<div class="row clearfix">
        <div class="col-lg-12">
            <div class="card action_bar bg-dark">
                <div class="body">
                    <div class="row clearfix">                            
                        <div class="col-lg-6 col-md-7 col-9">
                            <div class="input-group search">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-addon">
                                    <i class="zmdi zmdi-search"></i>
                                </span>
                            </div>
                        </div>                            
                        <div class="col-lg-6 col-md-5 col-3 text-right">
                            <div class="btn-group hidden-sm-down">
                                <button type="button" class="btn btn-neutral dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More<span class="caret"></span> </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Unread</a></li>
                                    <li><a href="javascript:void(0);">Unimportant</a></li>
                                    <li><a href="javascript:void(0);">Add star</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="javascript:void(0);">Mute</a></li>
                                </ul>
                            </div>
                            <div class="btn-group hidden-md-down hidden-sm-down">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-neutral dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-label"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a href="javascript:void(0);">Family</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Work</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Google</a>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);">Create a Label</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="btn-group hidden-md-down hidden-sm-down">
                                <button type="button" class="btn btn-neutral dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-folder"></i> <span class="caret"></span> </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="javascript:void(0);">Important</a></li>
                                    <li><a href="javascript:void(0);">Social</a></li>
                                    <li><a href="javascript:void(0);">Bank Statements</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="javascript:void(0);">Create a folder</a></li>
                                </ul>
                            </div>                                
                            <button type="button" class="btn btn-neutral hidden-sm-down">
                                <i class="zmdi zmdi-plus-circle"></i>
                            </button>
                            <button type="button" class="btn btn-neutral hidden-sm-down">
                                <i class="zmdi zmdi-archive"></i>
                            </button>
                            <button type="button" class="btn btn-neutral btn-danger">
                                <i class="zmdi zmdi-delete"></i>
                            </button>
                        </div>                            
                    </div>
                </div>
            </div>
        </div>           
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="margin-0">Your updated item SQUARE</h4>
                            <span class="text-muted">Mar 9 (4 days ago)</span>
                            <hr>
                            <div class="media">
                                <div class="float-left">
                                    <div class="m-r-20"> <img class="rounded" src="../assets/images/xs/avatar7.jpg" width="60" alt=""> </div>
                                </div>
                                <div class="media-body">
                                    <p class="m-b-0">
                                        <strong class="text-muted m-r-5">From:</strong>
                                        <a href="javascript:void(0);" class="text-default">info@example.com</a>
                                    </p>
                                    <p class="m-b-0">
                                        <strong class="text-muted m-r-10">To:</strong>Me
                                    </p>
                                    <p class="m-b-0">
                                        <strong class="text-muted m-r-10">CC:</strong><a href="javascript:void(0);">info@example.com</a>, <a href="javascript:void(0);">abc@example.com</a>
                                    </p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <p>printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrnturies, but also the leap into electronic typesetting, remaining essentially unchanged.</p>                                
                        </div>
                        <div class="col-md-12">
                            <span><img src="../assets/images/image2.jpg" class="img-thumbnail m-t-10" width="250" alt=""></span>
                            <span><img src="../assets/images/image3.jpg" class="img-thumbnail m-t-10" width="250" alt=""></span>
                        </div>                   
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <strong>Click here to</strong> <a href="{{route('app.mail-compose')}}">Reply</a> or <a href="{{route('app.mail-compose')}}">Forward</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop