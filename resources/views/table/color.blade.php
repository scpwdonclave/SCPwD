@extends('layout.master')
@section('title', 'Table Color')
@section('parentPageTitle', 'Table')
@section('content')
<div class="container-fluid">       
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Solid Color</strong> background <small>You can use material design colors which examples are <code>.bg-pink</code></small> </h2>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Class name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-blue">
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>.bg-blue</td>
                                </tr>
                                <tr class="bg-cyan">
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>.bg-cyan</td>
                                </tr>
                                <tr class="bg-amber">
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>.bg-amber</td>
                                </tr>
                                <tr class="bg-blush">
                                    <th scope="row">4</th>
                                    <td>Larry</td>
                                    <td>Jellybean</td>
                                    <td>.bg-blush</td>
                                </tr>
                                <tr class="bg-purple">
                                    <th scope="row">5</th>
                                    <td>Larry</td>
                                    <td>Kikat</td>
                                    <td>.bg-purple</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Gradient Color</strong> background <small>You can use material design colors which examples are <code>.l-pink</code></small> </h2>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Class name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="l-pink">
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>.l-pink</td>
                                </tr>
                                <tr class="l-turquoise">
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>.l-turquoise</td>
                                </tr>
                                <tr class="l-parpl">
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>.l-parpl</td>
                                </tr>
                                <tr class="l-blue">
                                    <th scope="row">4</th>
                                    <td>Larry</td>
                                    <td>Jellybean</td>
                                    <td>.l-blue</td>
                                </tr>
                                <tr class="l-blush">
                                    <th scope="row">5</th>
                                    <td>Larry</td>
                                    <td>Kikat</td>
                                    <td>.l-blush</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Light Color</strong> background <small>You can use material design colors which examples are <code>.xl-pink</code></small> </h2>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Class name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="xl-pink">
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>.xl-pink</td>
                                </tr>
                                <tr class="xl-turquoise">
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>.xl-turquoise</td>
                                </tr>
                                <tr class="xl-parpl">
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>.xl-parpl</td>
                                </tr>
                                <tr class="xl-blue">
                                    <th scope="row">4</th>
                                    <td>Larry</td>
                                    <td>Jellybean</td>
                                    <td>.xl-blue</td>
                                </tr>
                                <tr class="xl-khaki">
                                    <th scope="row">5</th>
                                    <td>Larry</td>
                                    <td>Kikat</td>
                                    <td>.xl-khaki</td>
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