@extends('layout.master')
@section('title', 'Sparkline Chart')
@section('parentPageTitle', 'Charts')
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>All</strong> Examples</h2>
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
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <p> Mouse speed <span id="mousespeed">Loading..</span> </p>
                            <p> Inline <span class="sparkline-1">10,8,9,3,5,8,5</span> line graphs <span class="sparkline-1">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span> </p>
                            <p> Bar charts <span class="sparkbar">10,8,9,3,5,8,5</span> negative values: <span class="sparkbar">-3,1,2,0,3,-1</span> stacked: <span class="sparkbar">0:2,2:4,4:2,4:1</span> </p>
                            <p> Composite inline <span id="compositeline">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span> </p>
                            <p> Inline with normal range <span id="normalline">8,4,0,0,0,0,1,4,4,10,10,10,10,0,0,0,4,6,5,9,10</span> </p>
                            <p> Composite bar <span id="compositebar">4,6,7,7,4,3,2,1,4</span> </p>
                            <p> Discrete <span class="discrete1">4,6,7,7,4,3,2,1,4,4,5,6,7,6,6,2,4,5</span><br>
                                Discrete with
                                threshold <span id="discrete2">4,6,7,7,4,3,2,1,4</span> </p>
                            <p> Bullet charts<br>
                                <span class="sparkbullet">10,12,12,9,7</span><br>
                                <span class="sparkbullet">14,12,12,9,7</span><br>
                                <span class="sparkbullet">10,12,14,9,7</span><br>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p> Customize size and colours <span id="linecustom">10,8,9,3,5,8,5,7</span> </p>
                            <p> Tristate charts <span class="sparktristate">1,1,0,1,-1,-1,1,-1,0,0,1,1</span><br>
                                (think games won,
                                lost or drawn) </p>
                            <p> Tristate chart using a colour map: <span class="sparktristatecols">1,2,0,2,-1,-2,1,-2,0,0,1,1</span> </p>
                            <p> Box Plot: <span class="sparkboxplot">4,27,34,52,54,59,61,68,78,82,85,87,91,93,100</span><br>
                                Pre-computed box plot <span class="sparkboxplotraw">Loading..</span> </p>
                            <p> <span class="sparkpie">1,1,2</span> <span class="sparkpie">1,5</span> <span class="sparkpie">20,50,80</span> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card">
                <div class="body text-center">
                    <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#00ced1">1,2,2,3,3,4,4,5,5,6,6,5,5,4,4,3,3,2,2,1</div>
                    <h3 class="m-b-0">457 512</h3>
                    <small class="displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card">
                <div class="body text-center">
                    <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#e4d354">1,2,2,3,3,4,4,5,5,6,6,5,5,4,4,3,3,2,2,1</div>
                    <h3 class="m-b-0">236 512</h3>
                    <small class="displayblock">13% Average <i class="zmdi zmdi-trending-down"></i></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card">
                <div class="body text-center">
                    <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#7cb5ec">1,2,3,4,5,4,3,2,1,2,3,4,5,6,7,8,7,6,5,4</div>
                    <h3 class="m-b-0">236 512</h3>
                    <small class="displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="card">
                <div class="body text-center">
                    <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#f15c80">8,7,6,5,4,3,2,2,3,4,5,6,7,8,7,6,5,4</div>
                    <h3 class="m-b-0">236 512</h3>
                    <small class="displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                </div>
            </div>
        </div>
    </div>        
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card ">
                <div class="header">
                    <h2><strong>Sales</strong> This week</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-sm-6 col-6 m-b-10">
                            <span class="text-muted">This Week</span>
                            <h5 class="m-b-0">1,256</h5>
                            <span><i class="zmdi zmdi-caret-up text-success"></i> +18%</span>
                        </div>
                        <div class="col-sm-6 col-6 m-b-10">
                            <span class="text-muted">Average</span>
                            <h5 class="m-b-0">981</h5>
                            <span><i class="zmdi zmdi-caret-up text-success"></i> +5%</span>
                        </div>
                    </div>                        
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="1" data-highlight-Spot-Color="rgb(63, 81, 181)" data-highlight-Line-Color="#222"
                data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(63, 81, 181)" data-spot-Color="rgb(63, 81, 181, 0.7)"
                data-offset="90" data-width="100%" data-height="50px" data-line-Width="1" data-line-Color="rgb(63, 81, 181, 0.7)"
                data-fill-Color="rgba(221,94,137, 0.7)"> 1,2,3,1,4,3,6,4,4,1 </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card ">
                <div class="header">
                    <h2><strong>Earnings</strong> This week</h2>                        
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-sm-6 col-6 m-b-10">
                            <span class="text-muted">This Week</span>
                            <h5 class="m-b-0">1,951</h5>
                            <span><i class="zmdi zmdi-caret-up text-success"></i> +15%</span>
                        </div>
                        <div class="col-sm-6 col-6 m-b-10">
                            <span class="text-muted">Average</span>
                            <h5 class="m-b-0">1,100</h5>
                            <span><i class="zmdi zmdi-caret-up text-success"></i> +17%</span>
                        </div>
                    </div>                        
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="1" data-highlight-Spot-Color="rgb(63, 81, 181)" data-highlight-Line-Color="#222"
                data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(120, 184, 62)" data-spot-Color="rgb(63, 81, 181, 0.7)"
                data-offset="90" data-width="100%" data-height="50px" data-line-Width="1" data-line-Color="rgb(63, 81, 181, 0.7)"
                data-fill-Color="rgba(128,133,233, 0.7)"> 9,5,6,8,4,8,7,9,8,3</div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div class="card ">
                <div class="header">
                    <h2><strong>Traffic</strong> This week</h2>                        
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-sm-6 col-6 m-b-10">
                            <span class="text-muted">This Week</span>
                            <h5 class="m-b-0">1,951</h5>
                            <span><i class="zmdi zmdi-caret-up text-success"></i> +15%</span>
                        </div>
                        <div class="col-sm-6 col-6 m-b-10">
                            <span class="text-muted">Average</span>
                            <h5 class="m-b-0">1,100</h5>
                            <span><i class="zmdi zmdi-caret-up text-success"></i> +17%</span>
                        </div>
                    </div>                        
                </div>
                <div class="sparkline" data-type="line" data-spot-Radius="1" data-highlight-Spot-Color="rgb(63, 81, 181)" data-highlight-Line-Color="#222"
                data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(120, 184, 62)" data-spot-Color="rgb(63, 81, 181, 0.7)"
                data-offset="90" data-width="100%" data-height="50px" data-line-Width="1" data-line-Color="rgb(63, 81, 181, 0.7)"
                data-fill-Color="rgba(255,193,7, 0.7)"> 5,4,9,8,3,5,2,9,5,1</div>
            </div>
        </div>           
    </div>
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card l-slategray">                    
                <div class="body">
                    <div id="sparkline14"></div>                            
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">                    
                <div class="body">
                    <div id="sparkline16" class="text-center"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2><strong>Line</strong> Chart</h2>
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
                    <div class="sparkline" data-type="line" data-spot-Radius="3" data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                                data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(0, 150, 136)" data-spot-Color="rgba(3, 116, 192, 0.7)"
                                data-offset="90" data-width="100%" data-height="150px" data-line-Width="2" data-line-Color="rgba(3,116, 192, 0.7)"
                                data-fill-Color="rgba(3,116,192, 0.4)">2,3,5,6,4,5,1,2,3,2,5</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2><strong>Pie</strong> Chart</h2>
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
                <div class="body align-center">
                    <div class="sparkline-pie">6,4,8</div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="header">
                    <h2><strong>Bar</strong> Chart</h2>
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
                    <div class="sparkline" data-type="bar" data-width="97%" data-height="150px" data-bar-Width="16" data-bar-Spacing="7" data-bar-Color="rgba(251, 179, 61, 0.4)"> 2,5,8,9,6,3,5,4,2,5,7</div>
                </div>
            </div>
        </div>            
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/js/pages/charts/sparkline.js')}}"></script>
@stop