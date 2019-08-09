@extends('layout.master')
@section('title', 'Product List')
@section('parentPageTitle', 'eCommerce')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/ecommerce.css')}}">
@stop
@section('content')
<div class="container-fluid ecommerce-page">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card action_bar">
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-8 col-md-7 col-9">
                            <div class="input-group search m-b-0">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-addon">
                                    <i class="zmdi zmdi-search"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 col-3 text-right">
                            <div class="btn-group hidden-sm-down" role="group">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-neutral btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-label"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right pullDown">
                                        <li>
                                            <a href="javascript:void(0);">In Stock</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Low Stock</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">Out Of Stock</a>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li>
                                            <a href="javascript:void(0);">Create a Label</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn btn-neutral btn-sm hidden-sm-down">
                                <i class="zmdi zmdi-plus-circle"></i>
                            </button>
                            <button type="button" class="btn btn-neutral btn-sm hidden-sm-down">
                                <i class="zmdi zmdi-archive"></i>
                            </button>
                            <button type="button" class="btn btn-neutral btn-sm">
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
                    <div class="table-responsive product_item_list">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Detail</th>
                                    <th>Amount</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="../assets/images/ecommerce/1.png" class="rounded" width="40" alt="Product img"></td>
                                    <td><h5>Simple Black Clock</h5></td>
                                    <td><span class="text-muted">randomised words even slightly believable</span></td>
                                    <td>$16.00</td>
                                    <td><span class="col-green">In Stock</span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="../assets/images/ecommerce/10.png" class="rounded" width="40" alt="Product img"></td>
                                    <td><h5>Brone Candle</h5></td>
                                    <td><span class="text-muted">It is a long established  will be distracted</span></td>
                                    <td>$15.00</td>
                                    <td><span class="col-amber">Low Stock</span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="../assets/images/ecommerce/11.png" class="rounded" width="40" alt="Product img"></td>
                                    <td><h5>Wood Simple Clock</h5></td>
                                    <td><span class="text-muted">There passages of Lorem Ipsum available</span></td>
                                    <td>$16.00</td>
                                    <td><span class="col-amber">Low Stock</span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="../assets/images/ecommerce/5.png" class="rounded" width="40" alt="Product img"></td>
                                    <td><h5>Unero Small Bag</h5></td>
                                    <td><span class="text-muted">It is a long established fact that a distracted</span></td>
                                    <td>$23.00</td>
                                    <td><span class="col-red">Out Of Stock</span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="../assets/images/ecommerce/6.png" class="rounded" width="40" alt="Product img"></td>
                                    <td><h5>Simple Black Clock</h5></td>
                                    <td><span class="text-muted">Contrary to popular belief, simply random text</span></td>
                                    <td>$16.00</td>
                                    <td><span class="col-green">In Stock</span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="../assets/images/ecommerce/2.png" class="rounded" width="40" alt="Product img"></td>
                                    <td><h5>Brone Lamp Glasses</h5></td>
                                    <td><span class="text-muted">All the Lorem Ipsum generators on predefined chunks</span></td>
                                    <td>$12.00</td>
                                    <td><span class="col-green">In Stock</span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><img src="../assets/images/ecommerce/3.png" class="rounded" width="40" alt="Product img"></td>
                                    <td><h5>Simple Black Clock</h5></td>
                                    <td><span class="text-muted">established fact that a be distracted</span></td>
                                    <td>$22.00</td>
                                    <td><span class="col-red">Out Of Stock</span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                    </td>
                                </tr>        
                            </tbody>
                        </table>
                    </div>
                    <ul class="pagination pagination-primary m-b-0">
                        <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="zmdi zmdi-arrow-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                        <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="zmdi zmdi-arrow-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@stop