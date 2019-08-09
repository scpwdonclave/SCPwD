@extends('layout.master')
@section('title', 'Documents')
@section('parentPageTitle', 'File Manager')
@section('content')
<div class="container-fluid file_manager">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card bg-dark">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#doc">Doc</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pdf">PDF</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#xls">XLS</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="doc">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="file">
                                    <a href="javascript:void(0);">
                                        <div class="hover">
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">My_Doc_2015.doc</p>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report_2016.doc</p>
                                            <small>Size: 89KB <span class="date text-muted">Jun 21, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Document_2017.doc</p>
                                            <small>Size: 89KB <span class="date text-muted">Dec 15, 2017</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Document_2017.doc</p>
                                            <small>Size: 42KB <span class="date text-muted">Nov 02, 2017</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Document_2017.doc</p>
                                            <small>Size: 89KB <span class="date text-muted">Dec 15, 2017</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report_17.doc</p>
                                            <small>Size: 125KB <span class="date text-muted">Oct 13, 2017</span></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="pdf">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="file">
                                    <a href="javascript:void(0);">
                                        <div class="hover">
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-collection-pdf"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">sales.pdf</p>
                                            <small>Size: 4.2MB <span class="date text-muted">May 07, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-collection-pdf"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">incomereport.pdf</p>
                                            <small>Size: 3MB <span class="date text-muted">Feb 18, 2018</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-collection-pdf"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report_18.pdf</p>
                                            <small>Size: 3MB <span class="date text-muted">Jan 22, 2018</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-collection-pdf"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">My_data.pdf</p>
                                            <small>Size: 3MB <span class="date text-muted">Sept 17, 2016</span></small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="xls">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card">
                                <div class="file">
                                    <a href="javascript:void(0);">
                                        <div class="hover">
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2016.xls</p>
                                            <small>Size: 68KB <span class="date text-muted">Dec 12, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2017.xls</p>
                                            <small>Size: 103KB <span class="date text-muted">Jan 24, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2016.xls</p>
                                            <small>Size: 68KB <span class="date text-muted">Dec 12, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2016.xls</p>
                                            <small>Size: 68KB <span class="date text-muted">Dec 12, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2017.xls</p>
                                            <small>Size: 103KB <span class="date text-muted">Jan 24, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2016.xls</p>
                                            <small>Size: 68KB <span class="date text-muted">Dec 12, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2016.xls</p>
                                            <small>Size: 68KB <span class="date text-muted">Dec 12, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2017.xls</p>
                                            <small>Size: 103KB <span class="date text-muted">Jan 24, 2016</span></small>
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
                                            <button type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </div>
                                        <div class="icon">
                                            <i class="zmdi zmdi-chart"></i>
                                        </div>
                                        <div class="file-name">
                                            <p class="m-b-5 text-muted">Report2016.xls</p>
                                            <small>Size: 68KB <span class="date text-muted">Dec 12, 2016</span></small>
                                        </div>
                                    </a>
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
