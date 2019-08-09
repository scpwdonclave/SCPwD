@extends('layout.master')
@section('title', 'taskboard')
@section('parentPageTitle', 'App')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/nestable/jquery-nestable.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"/>
@stop
@section('content')
<div class="container-fluid taskboard">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6">
            <div class="card new_task">
                <div class="header">
                    <h2>New</h2>
                    <ul class="header-dropdown">
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#addcontact"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="body taskboard">
                    <div class="dd" data-plugin="nestable">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <small>#L1008</small>
                                    <h6>Job title</h6>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <small>#L2008</small>
                                    <h6>Angular 5</h6>
                                    <p>sQuare admin Dashboard in Vue</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>Bug</h6>
                                    <p>Github new code update</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>eMail</h6>
                                    <p>Send a email to CEO for new project</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card open_task">
                <div class="header">
                    <h2>Open</h2>
                    <ul class="header-dropdown">
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#addcontact"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="body taskboard">
                    <div class="dd" data-plugin="nestable">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <small>#L1008</small>
                                    <h6>Job title</h6>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <small>#L1002</small>
                                    <h6>New Code Updates</h6>                                        
                                </div>
                            </li>                                    
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card progress_task">
                <div class="header">
                    <h2>In progress</h2>
                    <ul class="header-dropdown">
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#addcontact"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="body taskboard">
                    <div class="dd" data-plugin="nestable">
                        <ol class="dd-list">
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>Job title</h6>
                                    <p>simply dummy text of the printing industry.</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>Design bug</h6>
                                    <p>Ipsum used since the 1500s is reproduced below</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>Vue Admin</h6>
                                    <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="list-unstyled team-info m-t-20 m-b-20">
                                        <li><img src="../assets/images/xs/avatar1.jpg" title="Avatar" alt="Avatar"></li>
                                        <li><img src="../assets/images/xs/avatar2.jpg" title="Avatar" alt="Avatar"></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <small>#L2008</small>
                                    <h6>Angular 5</h6>
                                    <p>sQuare admin Dashboard in Vue</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>Bug</h6>
                                    <p>Github new code update</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card completed_task">
                <div class="header">
                    <h2>Completed</h2>
                    <ul class="header-dropdown">
                        <li><a href="javascript:void(0);" data-toggle="modal" data-target="#addcontact"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="body taskboard">
                    <div class="dd" data-plugin="nestable">
                        <ol class="dd-list">                                   
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>Design bug</h6>
                                    <p>Ipsum used since the 1500s is reproduced below</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">
                                    <h6>Vue Admin</h6>
                                    <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="list-unstyled team-info m-t-20 m-b-20">
                                        <li><img src="../assets/images/xs/avatar3.jpg" title="Avatar" alt="Avatar"></li>
                                        <li><img src="../assets/images/xs/avatar4.jpg" title="Avatar" alt="Avatar"></li>
                                    </ul>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/nestable/jquery.nestable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/pages/ui/sortable-nestable.js')}}"></script>
<script src="{{asset('assets/js/pages/ui/dialogs.js')}}"></script>
@stop