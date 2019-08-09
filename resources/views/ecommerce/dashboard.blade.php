@extends('layout.master')
@section('title', 'Dashboard')
@section('parentPageTitle', 'eCommerce')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/ecommerce.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-amber"><i class="zmdi zmdi-store"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">Our Store</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="46" data-speed="2000" data-fresh-interval="700">46</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-blue"><i class="zmdi zmdi-shopping-cart"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">Total Sales</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="746" data-speed="2000" data-fresh-interval="700">746</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-blush"><i class="zmdi zmdi-chart"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">Total Revenue</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="6204" data-speed="2000" data-fresh-interval="700">6204</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-parpl"><i class="zmdi zmdi-receipt"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">Orders Received</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="416" data-speed="2000" data-fresh-interval="700">416</h4>
                    </div>
                </div>
            </div>
        </div>            
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card bg-dark">
                <div class="header">
                    <h2><strong>Product</strong> Report</h2>
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
                    <div class="sales-bars-chart m-t-20" style="height: 300px;"> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-12">
            <div class="card visitors-map">
                <div class="header">
                    <h2><strong>Top</strong> Selling Country</h2>
                </div>
                <div class="body">
                    <div class="row">                            
                        <div class="col-xl-8 col-lg-8 col-md-12">
                            <div id="world-map-markers" class="jvector-map"></div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12">
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
                                            <td>Germany</td>
                                            <td>594</td>
                                            <td>500</td>
                                            <td>6.11% <i class="zmdi zmdi-trending-down text-warning"></i></td>
                                        </tr>
                                        <tr>
                                            <td>UK</td>
                                            <td>1,500</td>
                                            <td>1,971</td>
                                            <td>8.50% <i class="zmdi zmdi-trending-up text-success"></i></td>
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
    </div>
    <div class="row clearfix">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Annual</strong> Report <small>Description text here...</small></h2>
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
                    <div id="area_chart" class="graph"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card tasks_report">
                <div class="header">
                    <h2><strong>Total</strong> Revenue</h2>
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
                <div class="body text-center">
                    <h4 class="m-t-0">Total Sale</h4>
                    <h6 class="m-b-20">2,45,124</h6>
                    <input type="text" class="knob dial1" value="78" data-width="140" data-height="140" data-thickness="0.2" data-bgColor="#f4f7f6" data-linecap="round" data-fgColor="#fda582" readonly>
                    <h6 class="m-t-30">Satisfaction Rate</h6>
                    <small class="displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                    <div class="sparkline m-t-20" data-type="bar" data-width="97%" data-height="42px" data-bar-Width="2" data-bar-Spacing="8" data-bar-Color="#000">3,2,6,5,9,8,7,8,4,5,1,2,9,5,1,3,5,7,4,6</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Recent</strong> Orders</h2>
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
                    <div class="table-responsive members_profiles">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:60px;">#</th>
                                    <th>Name</th>
                                    <th>Item</th>
                                    <th>Address</th>
                                    <th>Quantity</th>                                    
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="http://via.placeholder.com/60x50" alt="Product img"></td>
                                    <td>Hossein</td>
                                    <td>IPONE-7</td>
                                    <td>Porterfield 508 Virginia Street Chicago, IL 60653</td>
                                    <td>3</td>
                                    <td><span class="badge badge-success">DONE</span></td>
                                </tr>
                                <tr>
                                    <td><img src="http://via.placeholder.com/60x50" alt="Product img"></td>
                                    <td>Camara</td>
                                    <td>NOKIA-8</td>
                                    <td>2595 Pearlman Avenue Sudbury, MA 01776 </td>
                                    <td>3</td>
                                    <td><span class="badge badge-default">Delivered</span></td>                                    
                                </tr>
                                <tr>
                                    <td><img src="http://via.placeholder.com/60x50" alt="Product img"></td>
                                    <td>Maryam</td>
                                    <td>NOKIA-456</td>
                                    <td>Porterfield 508 Virginia Street Chicago, IL 60653</td>
                                    <td>4</td>
                                    <td><span class="badge badge-success">DONE</span></td>
                                </tr>
                                <tr>
                                    <td><img src="http://via.placeholder.com/60x50" alt="Product img"></td>
                                    <td>Micheal</td>
                                    <td>SAMSANG PRO</td>
                                    <td>508 Virginia Street Chicago, IL 60653</td>
                                    <td>1</td>
                                    <td><span class="badge badge-success">DONE</span></td>
                                </tr>
                                <tr>
                                    <td><img src="http://via.placeholder.com/60x50" alt="Product img"></td>
                                    <td>Frank</td>
                                    <td>NOKIA-456</td>
                                    <td>1516 Holt Street West Palm Beach, FL 33401</td>
                                    <td>13</td>
                                    <td><span class="badge badge-warning">PENDING</span></td>
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
<script src="{{asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/flotscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/sparkline.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/knob.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/ecommerce.js')}}"></script>
<script src="{{asset('assets/js/pages/charts/jquery-knob.min.js')}}"></script>
@stop