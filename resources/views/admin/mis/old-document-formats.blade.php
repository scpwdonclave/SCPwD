@extends('layout.master')
@section('title', 'Formats')
@section('parentPageTitle', 'MIS')
@section('content')
<div class="container-fluid file_manager">
    <div class="row clearfix">
        <div class="col-lg-12">
            
            <div class="tab-content">
                {{-- <div class="tab-pane active"> --}}
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="file">
                                    <a href="javascript:void(0);">
                                        <div class="hover">
                                           
                                            <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',['document' => 'Requirements.xlsx' ])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                <i class="zmdi zmdi-download"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Scpwd report Analysis</p>
                                            <small>Size: 42KB <span class="date text-muted">Jan 02, 2015</span></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="file">
                                    <a href="javascript:void(0);">
                                        <div class="hover">
                                           
                                            <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',['document' => 'Requirements.xlsx' ])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                <i class="zmdi zmdi-download"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Scpwd report Analysis</p>
                                            <small>Size: 42KB <span class="date text-muted">Jan 02, 2015</span></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="file">
                                    <a href="javascript:void(0);">
                                        <div class="hover">
                                           
                                            <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',['document' => 'Requirements.xlsx' ])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                <i class="zmdi zmdi-download"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Scpwd report Analysis</p>
                                            <small>Size: 42KB <span class="date text-muted">Jan 02, 2015</span></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="file">
                                    <a href="javascript:void(0);">
                                        <div class="hover">
                                           
                                            <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',['document' => 'Requirements.xlsx' ])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                <i class="zmdi zmdi-download"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Scpwd report candidate Analysis</p>
                                            <small>Size: 420KB <span class="date text-muted">Jan 02, 2015</span></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                {{-- </div> --}}
                
                
            </div>
        </div>
    </div>
</div>
@stop
