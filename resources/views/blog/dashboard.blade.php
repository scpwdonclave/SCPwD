@extends('layout.master')
@section('title', 'Dashboard')
@section('parentPageTitle', 'Blog')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/blog.css')}}"/>
@stop
@section('content')
<div class="container-fluid blog-page">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card l-blue">
                <div class="body">
                    <h4 class="m-t-0 m-b-0">2,048</h4>
                    <p class="m-b-0">Total Leads</p>
                    <div class="sparkline" data-type="line" data-spot-Radius="0"  data-offset="90" data-width="100%" data-height="40px" data-line-Width="1" data-line-Color="#fff"
                data-fill-Color="transparent"> 7,6,7,8,5,9,8,6,7 </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card l-parpl">
                <div class="body">
                    <h4 class="m-t-0 m-b-0">521</h4>
                    <p class="m-b-0 ">Total Connections</p>
                    <div class="sparkline" data-type="line" data-spot-Radius="0"  data-offset="90" data-width="100%" data-height="40px" data-line-Width="1" data-line-Color="#fff"
                data-fill-Color="transparent"> 6,5,7,4,5,3,8,6,5 </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card l-seagreen">
                <div class="body">
                    <h4 class="m-t-0 m-b-0">73</h4>
                    <p class="m-b-0 ">Articles</p>
                    <div class="sparkline" data-type="line" data-spot-Radius="0"  data-offset="90" data-width="100%" data-height="40px" data-line-Width="1" data-line-Color="#fff"
                data-fill-Color="transparent"> 8,7,7,5,5,4,8,7,5 </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card l-pink">
                <div class="body">
                    <h4 class="m-t-0 m-b-0">15</h4>
                    <p class="m-b-0">Categories</p>
                    <div class="sparkline" data-type="line" data-spot-Radius="0"  data-offset="90" data-width="100%" data-height="40px" data-line-Width="1" data-line-Color="#fff"
                data-fill-Color="transparent"> 7,6,7,8,5,9,8,6,7 </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card bg-dark">
                <div class="header">
                    <h2><strong>Popular</strong> Categories</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i></a>
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
                    <div id="line_chart" class="graph"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-7 col-md-12">
            <div class="card visitors-map">
                <div class="header">
                    <h2><strong>Visitors</strong> Statistics</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="zmdi zmdi-more"></i></a>
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
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div id="world-map-markers" class="jvector-map"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover m-b-0">
                                    <thead>
                                        <tr>
                                            <th>Contrary</th>
                                            <th>2016</th>
                                            <th>2017</th>
                                            <th>Change</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>USA</td>
                                            <td>2,009</td>
                                            <td>3,591</td>
                                            <td>7.01% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>India</td>
                                            <td>1,129</td>
                                            <td>1,361</td>
                                            <td>3.01% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Canada</td>
                                            <td>2,009</td>
                                            <td>2,901</td>
                                            <td>9.01% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Australia</td>
                                            <td>954</td>
                                            <td>901</td>
                                            <td>5.71% <i class="zmdi zmdi-trending-down text-warning"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Other</td>
                                            <td>4,236</td>
                                            <td>4,591</td>
                                            <td>9.15% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>USA</strong> Categories Statistics</h2>
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
                    <div id="usa" class="text-center" style="height: 400px"></div>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <thead>
                                <tr>
                                    <th>Categories</th>
                                    <th>2016</th>
                                    <th>2017</th>
                                    <th>Change</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Web Design</td>
                                    <td>2,009</td>
                                    <td>3,591</td>
                                    <td>7.01% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Photography</td>
                                    <td>1,129</td>
                                    <td>1,361</td>
                                    <td>3.01% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Technology</td>
                                    <td>2,009</td>
                                    <td>2,901</td>
                                    <td>9.01% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                </tr>
                                <tr>
                                    <td>Lifestyle</td>
                                    <td>954</td>
                                    <td>901</td>
                                    <td>5.71% <i class="zmdi zmdi-trending-down text-warning"></i></td>
                                </tr>
                                <tr>
                                    <td>Sports</td>
                                    <td>4,236</td>
                                    <td>4,591</td>
                                    <td>9.15% <i class="zmdi zmdi-trending-up text-success"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card social_widget2">
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-thumb-up col-blue"></i>
                            <h4 class="m-t-0 m-b-0">2,365</h4>
                            <span>Post View</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-comment-text col-red"></i>
                            <h4 class="m-t-0 m-b-0">365</h4>
                            <span>Comments</span>
                        </li>
                    </ul>
                </div>
                <div class="name facebook">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-facebook-box m-r-10"></i> <span>Facebook</span></h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card social_widget2">
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-eye col-amber"></i>
                            <h4 class="m-t-0 m-b-0">365</h4>
                            <span>Post View</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-comment-text col-red"></i>
                            <h4 class="m-t-0 m-b-0">125</h4>
                            <span>Comments</span>
                        </li>
                    </ul>
                </div>
                <div class="name dribbble">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-dribbble m-r-10"></i> <span>Dribbble</span></h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card social_widget2">
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-thumb-up col-blue"></i>
                            <h4 class="m-t-0 m-b-0">3,159</h4>
                            <span>Like</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-comment-text col-red"></i>
                            <h4 class="m-t-0 m-b-0">462</h4>
                            <span>Twitt</span>
                        </li>
                    </ul>
                </div>
                <div class="name twitter">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-twitter-box m-r-10"></i> <span>Twitter</span></h5>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card social_widget2">
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-eye col-amber"></i>
                            <h4 class="m-t-0 m-b-0">5,192,776</h4>
                            <span>Views</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-youtube-play col-red"></i>
                            <h4 class="m-t-0 m-b-0">10K</h4>
                            <span>Subscribe</span>
                        </li>
                    </ul>
                </div>
                <div class="name youtube">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-youtube m-r-10"></i> <span>YouTube</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12">
            <div class="card single_post">
                <div class="header">
                    <h2><strong>Latest</strong> Post</h2>
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
                    <h3 class="m-t-0 m-b-5"><a href="{{route('blog.blog-detail')}}">Apple Introduces Search Ads Basic</a></h3>
                    <ul class="meta">
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-account col-blue"></i>Posted By: John Smith</a></li>
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-label col-amber"></i>Technology</a></li>
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-comment-text col-blue"></i>Comments: 3</a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="img-post m-b-15">
                        <img src="../assets/images/blog/blog-page-4.jpg" alt="Awesome Image">
                        <div class="social_share">
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-facebook"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-twitter"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-instagram"></i></button>
                        </div>
                    </div>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal</p>
                    <a href="{{route('blog.blog-detail')}}" title="read more" class="btn btn-round btn-info">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card single_post">
                <div class="header">
                    <h2><strong>Latest</strong> Post</h2>
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
                    <h3 class="m-t-0 m-b-5"><a href="{{route('blog.blog-detail')}}">Apple Introduces Search Ads Basic</a></h3>
                    <ul class="meta">
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-account col-blue"></i>Posted By: John Smith</a></li>
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-label col-amber"></i>Technology</a></li>
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-comment-text col-blue"></i>Comments: 3</a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="img-post m-b-15">
                        <img src="../assets/images/blog/blog-page-3.jpg" alt="Awesome Image">
                        <div class="social_share">
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-facebook"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-twitter"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-instagram"></i></button>
                        </div>
                    </div>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal</p>
                    <a href="{{route('blog.blog-detail')}}" title="read more" class="btn btn-round btn-info">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card single_post">
                <div class="header">
                    <h2><strong>Latest</strong> Post</h2>
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
                    <h3 class="m-t-0 m-b-5"><a href="{{route('blog.blog-detail')}}">Apple Introduces Search Ads Basic</a></h3>
                    <ul class="meta">
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-account col-blue"></i>Posted By: John Smith</a></li>
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-label col-amber"></i>Technology</a></li>
                        <li><a href="javascript:void(0);"><i class="zmdi zmdi-comment-text col-blue"></i>Comments: 3</a></li>
                    </ul>
                </div>
                <div class="body">
                    <div class="img-post m-b-15">
                        <img src="../assets/images/blog/blog-page-2.jpg" alt="Awesome Image">
                        <div class="social_share">
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-facebook"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-twitter"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-instagram"></i></button>
                        </div>
                    </div>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal</p>
                    <a href="{{route('blog.blog-detail')}}" title="read more" class="btn btn-round btn-info">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
                <div class="card">
                <div class="header">
                    <h2><strong>Social</strong> Media</h2>
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
                    <div class="table-responsive social_media_table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Media</th>
                                    <th>Name</th>
                                    <th>Like</th>
                                    <th>Comments</th>
                                    <th>Share</th>
                                    <th>Members</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="social_icon linkedin"><i class="zmdi zmdi-linkedin"></i></span>
                                    </td>
                                    <td><span class="list-name">Linked In</span>
                                        <span class="text-muted">Florida, United States</span>
                                    </td>
                                    <td>19K</td>
                                    <td>14K</td>
                                    <td>10K</td>
                                    <td>
                                        <span class="badge badge-success">2341</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon twitter-table"><i class="zmdi zmdi-twitter"></i></span>
                                    </td>
                                    <td><span class="list-name">Twitter</span>
                                        <span class="text-muted">Arkansas, United States</span>
                                    </td>
                                    <td>7K</td>
                                    <td>11K</td>
                                    <td>21K</td>
                                    <td>
                                        <span class="badge badge-success">952</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon facebook"><i class="zmdi zmdi-facebook"></i></span>
                                    </td>
                                    <td><span class="list-name">Facebook</span>
                                        <span class="text-muted">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>8K</td>
                                    <td>
                                        <span class="badge badge-success">6127</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon google"><i class="zmdi zmdi-google-plus"></i></span>
                                    </td>
                                    <td><span class="list-name">Google Plus</span>
                                        <span class="text-muted">Arizona, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>154</td>
                                    <td>
                                        <span class="badge badge-success">325</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon youtube"><i class="zmdi zmdi-youtube-play"></i></span>
                                    </td>
                                    <td><span class="list-name">YouTube</span>
                                        <span class="text-muted">Alaska, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>200</td>
                                    <td>
                                        <span class="badge badge-success">160</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js')}}"></script>
<script src="{{asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/blog/blog.js')}}"></script>
@stop