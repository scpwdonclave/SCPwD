@extends('layout.master')
@section('title', 'Dashboard 2')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-balance zmdi-hc-3x col-amber"></i></h6>
                    <span>Total Revenue</span>
                    <h3 class="m-b-10">$<span class="number count-to" data-from="0" data-to="2078" data-speed="2000" data-fresh-interval="700">2078</span></h3>
                    <small class="text-muted">27% lower growth</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-assignment zmdi-hc-3x col-blue"></i></h6>
                    <span>Total Orders</span>
                    <h3 class="m-b-10 number count-to" data-from="0" data-to="865" data-speed="2000" data-fresh-interval="700">865</h3>
                    <small class="text-muted">88% lower growth</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-shopping-basket zmdi-hc-3x"></i></h6>
                    <span>Total Sales</span>
                    <h3 class="m-b-10 number count-to" data-from="0" data-to="3502" data-speed="2000" data-fresh-interval="700">3502</h3>
                    <small class="text-muted">38% lower growth</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card text-center">
                <div class="body">
                    <h6 class="m-b-20"><i class="zmdi zmdi-account-box zmdi-hc-3x col-green"></i></h6>
                    <span>New Employees</span>
                    <h3 class="m-b-10 number count-to" data-from="0" data-to="78" data-speed="2000" data-fresh-interval="700">78</h3>
                    <small class="text-muted">78% lower growth</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card bg-dark">
                <div class="header">
                    <h2><strong>Sales</strong> Overview</h2>
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
                    <div id="m_area_chart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0">102.07 Gb</h3>
                    <p class="text-muted">Traffic this month</p>
                    <div class="progress">
                        <div class="progress-bar l-blush" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small>13% higher than last Month</small>
                </div>
            </div>
            <div class="card overflowhidden">
                <div class="body">
                    <h6>Outbound Bandwidth</h6>
                    <h3>340</h3>
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="0" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                    data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(0, 150, 136)" data-spot-Color="rgba(3, 116, 192, 0.7)"
                    data-offset="90" data-width="100%" data-height="135px" data-line-Width="2" data-line-Color="rgba(3,116, 192, 0.7)"
                    data-fill-Color="rgba(3,116,192, 0.2)">5,2,4,6,5,3,7,2,4,5</div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2><strong>My</strong> Contact <small>Description text here...</small></h2>
                </div>
                <div class="body">
                    <ul class="follow_us list-unstyled">
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar4.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Chris Fox</span>
                                        <span class="message">Designer, Blogger</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar5.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Joge Lucky</span>
                                        <span class="message">Java Developer</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar2.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Isabella</span>
                                        <span class="message">CEO, Thememakker</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar1.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Folisise Chosielie</span>
                                        <span class="message">Art director, Movie Cut</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="../assets/images/xs/avatar3.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Alexander</span>
                                        <span class="message">Writter, Mag Editor</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2><strong>Invoice</strong></h2>
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
                    <div class="row">
                        <div class="col-md-12">
                            <address>
                                <strong>ThemeMakker Inc.</strong> <small class="float-right">16/03/2018</small><br>
                                795 Folsom Ave, Suite 546<br>
                                San Francisco, CA 54656<br>
                                <abbr title="Phone">P:</abbr> (123) 456-34636
                            </address>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Simple Black Clock</td>
                                    <td>$30</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Brone Candle</td>
                                    <td>$25</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><strong>$55</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-warning btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-print"></i></button>
                            <button class="btn btn-primary btn-round">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Orders</strong> Overview</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table center-aligned-table">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Product Name</th>
                                    <th>Purchased On</th>
                                    <th>Shipping Status</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Q01</td>
                                    <td>Iphone 7</td>
                                    <td>12 Jan 2018</td>
                                    <td>Dispatched</td>
                                    <td>Credit card</td>
                                    <td><label class="badge bg-green margin-0">Approved</label></td>
                                    <td><a href="#" class="btn btn-simple btn-success btn-sm btn-round">View Order</a></td>
                                    <td><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Q02</td>
                                    <td>Galaxy S8</td>
                                    <td>18 Jan 2018</td>
                                    <td>Dispatched</td>
                                    <td>Internet banking</td>
                                    <td><label class="badge bg-amber margin-0">Pending</label></td>
                                    <td><a href="#" class="btn btn-simple btn-success btn-sm btn-round">View Order</a></td>
                                    <td><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Q03</td>
                                    <td>Amazon Echo</td>
                                    <td>22 Feb 2018</td>
                                    <td>Dispatched</td>
                                    <td>Credit card</td>
                                    <td><label class="badge bg-green margin-0">Approved</label></td>
                                    <td><a href="#" class="btn btn-simple btn-success btn-sm btn-round">View Order</a></td>
                                    <td><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Q04</td>
                                    <td>Google Pixel</td>
                                    <td>22 Feb 2018</td>
                                    <td>Dispatched</td>
                                    <td>Cash on delivery</td>
                                    <td><label class="badge bg-red margin-0">Rejected</label></td>
                                    <td><a href="#" class="btn btn-simple btn-success btn-sm btn-round">View Order</a></td>
                                    <td><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Q05</td>
                                    <td>Mac Mini</td>
                                    <td>8 March 2018</td>
                                    <td>Dispatched</td>
                                    <td>Debit card</td>
                                    <td><label class="badge bg-green margin-0">Approved</label></td>
                                    <td><a href="#" class="btn btn-simple btn-success btn-sm btn-round">View Order</a></td>
                                    <td><button class="btn btn-simple btn-danger btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-delete"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card visitors-map">
                <div class="header">
                    <h2><strong>Site</strong> Visitors</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div id="world-map-markers" style="height: 320px;"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="progress-container progress-info m-b-25">
                                        <span class="progress-badge">Visitors From USA</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 78%;">
                                                <span class="progress-value">78%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="progress-container progress-primary m-b-25">
                                        <span class="progress-badge">Visitors From India</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 53%;">
                                                <span class="progress-value">53%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="progress-container progress-warning m-b-25">
                                        <span class="progress-badge">Visitors From Europe</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 31%;">
                                                <span class="progress-value">31%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="progress-container progress-success m-b-25">
                                        <span class="progress-badge">Visitors From Australia</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 27%;">
                                                <span class="progress-value">27%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="progress-container">
                                        <span class="progress-badge">Visitors From UAE</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                                <span class="progress-value">15%</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/index3.js')}}"></script>
@stop