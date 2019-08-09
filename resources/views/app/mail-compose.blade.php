@extends('layout.master')
@section('title', 'Mail Compose')
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
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="To">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="CC">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <strong>Content:</strong>
                            <textarea id="ckeditor">
                                <h2>WYSIWYG Editor</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ullamcorper sapien non nisl facilisis bibendum in quis tellus. Duis in urna bibendum turpis pretium fringilla. Aenean neque velit, porta eget mattis ac, imperdiet quis nisi. Donec non dui et tortor vulputate luctus. Praesent consequat rhoncus velit, ut molestie arcu venenatis sodales.</p>
                                <h3>Lacinia</h3>
                                <ul>
                                    <li>Suspendisse tincidunt urna ut velit ullamcorper fermentum.</li>
                                    <li>Nullam mattis sodales lacus, in gravida sem auctor at.</li>
                                    <li>Praesent non lacinia mi.</li>
                                    <li>Mauris a ante neque.</li>
                                    <li>Aenean ut magna lobortis nunc feugiat sagittis.</li>
                                </ul>
                                <h3>Pellentesque adipiscing</h3>
                                <p>Maecenas quis ante ante. Nunc adipiscing rhoncus rutrum. Pellentesque adipiscing urna mi, ut tempus lacus ultrices ac. Pellentesque sodales, libero et mollis interdum, dui odio vestibulum dolor, eu pellentesque nisl nibh quis nunc. Sed porttitor leo adipiscing venenatis vehicula. Aenean quis viverra enim. Praesent porttitor ut ipsum id ornare.</p>
                            </textarea>
                            <button type="button" class="btn btn-primary btn-round waves-effect m-t-20">Send Message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/editors.js')}}"></script>
@stop