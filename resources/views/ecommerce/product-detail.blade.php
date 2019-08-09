@extends('layout.master')
@section('title', 'Product Details')
@section('parentPageTitle', 'eCommerce')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/ecommerce.css')}}">
@stop
@section('content')
<div class="container-fluid ecommerce-page">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="preview col-lg-4 col-md-12">
                            <div class="preview-pic tab-content">
                                <div class="tab-pane active" id="product_1"><img src="../assets/images/ecommerce/1.png" class="img-fluid" /></div>
                                <div class="tab-pane" id="product_2"><img src="../assets/images/ecommerce/2.png" class="img-fluid"/></div>
                                <div class="tab-pane" id="product_3"><img src="../assets/images/ecommerce/3.png" class="img-fluid"/></div>
                                <div class="tab-pane" id="product_4"><img src="../assets/images/ecommerce/4.png" class="img-fluid"/></div>
                                <div class="tab-pane" id="product_5"><img src="../assets/images/ecommerce/5.png" class="img-fluid"/></div>
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#product_1"><img src="../assets/images/ecommerce/1.png" /></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product_2"><img src="../assets/images/ecommerce/2.png" /></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product_3"><img src="../assets/images/ecommerce/3.png" /></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product_4"><img src="../assets/images/ecommerce/4.png" /></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product_5"><img src="../assets/images/ecommerce/5.png" /></a></li>                                    
                            </ul>                
                        </div>
                        <div class="details col-lg-8 col-md-12">
                            <h3 class="product-title m-b-0">Simple Black Clock</h3>
                            <h4 class="price m-t-0">Current Price: <span class="col-amber">$180</span></h4>
                            <div class="rating">
                                <div class="stars">
                                    <span class="zmdi zmdi-star col-amber"></span>
                                    <span class="zmdi zmdi-star col-amber"></span>
                                    <span class="zmdi zmdi-star col-amber"></span>
                                    <span class="zmdi zmdi-star col-amber"></span>
                                    <span class="zmdi zmdi-star-outline"></span>
                                </div>
                                <span class="m-l-10">41 reviews</span>
                            </div>
                            <hr>
                            <p class="product-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <p class="vote"><strong>78%</strong> of buyers enjoyed this product! <strong>(23 votes)</strong></p>
                            <h5 class="sizes">sizes:
                                <span class="size" title="small">s</span>
                                <span class="size" title="medium">m</span>
                                <span class="size" title="large">l</span>
                                <span class="size" title="xtra large">xl</span>
                            </h5>
                            <h5 class="colors">colors:
                                <span class="color bg-amber not-available"  title="Not In store"></span>
                                <span class="color bg-green"></span>
                                <span class="color bg-blue"></span>
                            </h5>
                            <hr>
                            <div class="action">
                                <button class="btn btn-primary btn-round waves-effect" type="button">add to cart</button>
                                <button class="btn btn-primary btn-icon btn-icon-mini btn-round waves-effect" type="button"><span class="zmdi zmdi-favorite"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <ul class="nav nav-tabs pl-0 mb-3">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description">Description</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#review">Review</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#about">About</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="description">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                        </div>
                        <div class="tab-pane" id="review">
                            <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied</p>
                            <ul class="row list-unstyled c_review">
                                <li class="col-12">
                                    <div class="avatar">
                                        <a href="javascript:void(0);"><img class="rounded" src="../assets/images/xs/avatar2.jpg" alt="user" width="60"></a>
                                    </div>                                
                                    <div class="comment-action">
                                        <h5 class="c_name">Hossein Shams</h5>
                                        <p class="c_msg m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. </p>
                                        <div class="badge badge-primary">iPhone 8</div>
                                        <span class="m-l-10">
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star-outline text-muted"></i></a>
                                        </span>
                                        <small class="comment-date float-sm-right">Dec 21, 2017</small>
                                    </div>                                
                                </li>
                                <li class="col-12">
                                    <div class="avatar">
                                        <a href="javascript:void(0);"><img class="rounded" src="../assets/images/xs/avatar3.jpg" alt="user" width="60"></a>
                                    </div>                                
                                    <div class="comment-action">
                                        <h5 class="c_name">Tim Hank</h5>
                                        <p class="c_msg m-b-0">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout</p>
                                        <div class="badge badge-primary">Nokia 8</div>
                                        <span class="m-l-10">
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <a href="javascript:void(0);"><i class="zmdi zmdi-star-outline text-muted"></i></a>
                                        </span>
                                        <small class="comment-date float-sm-right">Dec 18, 2017</small>
                                    </div>                                
                                </li>                                   
                            </ul>
                        </div>
                        <div class="tab-pane" id="about">
                            <h6>Where does it come from?</h6>
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop