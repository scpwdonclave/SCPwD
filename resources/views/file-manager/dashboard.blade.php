@extends('layout.master')
@section('title', 'Dashboard')
@section('parentPageTitle', 'File Manager')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.css')}}"/>
@stop
@section('content')
<div class="container-fluid file_manager">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <p class="text-muted">Storage <small class="text-muted float-right">of 1Tb</small></p>
                    <h4 class="m-t-0">32GB</h4>
                    <div class="progress m-t-10">
                        <div class="progress-bar l-green" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <p class="text-muted">Documents <small class="text-muted float-right">of 1Tb</small></p>
                    <h4 class="m-t-0">2GB</h4>
                    <div class="progress m-t-10">
                        <div class="progress-bar l-blush" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100" style="width: 12%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <p class="text-muted">Media <small class="text-muted float-right">of 1Tb</small></p>
                    <h4 class="m-t-0">10GB</h4>
                    <div class="progress m-t-10">
                        <div class="progress-bar l-parpl" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 39%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <p class="text-muted">Images <small class="text-muted float-right">of 1Tb</small></p>
                    <h4 class="m-t-0">20GB</h4>
                    <div class="progress m-t-10">
                        <div class="progress-bar l-blue" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-12 col-xs-12">
            <div class="card bg-dark">
                <div class="header">
                    <h2><strong>File</strong> Reports</h2>
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
                    <div id="m_area_chart"></div>                        
                </div>                    
            </div>
        </div>
    </div>        
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
                        <div class="image">
                            <img src="../assets/images/image-gallery/1.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">img21545ds.jpg</p>
                            <small>Size: 2MB <span class="date text-muted">Dec 11, 2017</span></small>
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
                            <i class="zmdi zmdi-collection-folder-image"></i>
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">hellonew.mkv</p>
                            <small>Size: 720MB <span class="date text-muted">Dec 08, 2017</span></small>
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
                            <i class="zmdi zmdi-playlist-audio"></i>
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">newsong.mp3</p>
                            <small>Size: 8MB <span class="date text-muted">Dec 11, 2017</span></small>
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
                            <p class="m-b-5 text-muted">asdf  hhkj.pdf</p>
                            <small>Size: 3MB <span class="date text-muted">Aug 18, 2017</span></small>
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
                            <i class="zmdi zmdi-collection-video"></i>
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">Jee Le Zara Song.mpg4</p>
                            <small>Size: 32MB <span class="date text-muted">Oct 11, 2016</span></small>
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
                        <div class="image">
                            <img src="../assets/images/image-gallery/3.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">img21545ds.jpg</p>
                            <small>Size: 2MB <span class="date text-muted">Nov 11, 2017</span></small>
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
                            <i class="zmdi zmdi-collection-folder-image"></i>
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">hellonew.mkv</p>
                            <small>Size: 720MB <span class="date text-muted">Feb 16, 2016</span></small>
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
                        <div class="image">
                            <img src="../assets/images/image-gallery/2.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">img21545ds.jpg</p>
                            <small>Size: 2MB <span class="date text-muted">Dec 11, 2017</span></small>
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
                            <i class="zmdi zmdi-collection-folder-image"></i>
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">hellonew.mkv</p>
                            <small>Size: 720MB <span class="date text-muted">Dec 08, 2017</span></small>
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
                            <i class="zmdi zmdi-playlist-audio"></i>
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">newsong.mp3</p>
                            <small>Size: 8MB <span class="date text-muted">Dec 11, 2017</span></small>
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
                        <div class="image">
                            <img src="../assets/images/image-gallery/8.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">img21545ds.jpg</p>
                            <small>Size: 2MB <span class="date text-muted">Dec 11, 2017</span></small>
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
                            <p class="m-b-5 text-muted">asdf  hhkj.pdf</p>
                            <small>Size: 3MB <span class="date text-muted">Aug 18, 2017</span></small>
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
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/file/filemanager.js')}}"></script>
@stop