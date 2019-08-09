@extends('layout.master')
@section('title', 'Product')
@section('parentPageTitle', 'eCommerce')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/ecommerce.css')}}">
@stop
@section('content')
<div class="container-fluid ecommerce-page">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/1.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Simple Black Clock</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$13.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/15.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Simple Black Clock</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$12.00</li>
                            <li class="new_price">$11.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/13.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Brone Candle</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$23.00</li>
                            <li class="new_price">$17.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/4.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Simple Black Clock</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$10.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/5.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Brone Lamp Glasses</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$18.00</li>
                            <li class="new_price">$15.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/14.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Unero Small Bag</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$21.00</li>
                            <li class="new_price">$17.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/7.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Unero Round Sunglass</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$10.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/8.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Wood Simple Clock</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$10.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/9.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Wood Long TV Board</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$10.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/10.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Simple Black Clock</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$10.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/11.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Wood Simple Chair V2</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$10.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="../assets/images/ecommerce/12.png" alt="Product" class="img-fluid" />
                        <div class="hover">
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-plus"></i></a>
                            <a href="javascript:void(0);" class="btn btn-sm btn-primary waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                        <h5><a href="{{route('ecommerce.product-detail')}}">Simple Black Clock</a></h5>
                        <ul class="product_price list-unstyled">
                            <li class="old_price">$16.00</li>
                            <li class="new_price">$10.00</li>
                        </ul>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>
@stop