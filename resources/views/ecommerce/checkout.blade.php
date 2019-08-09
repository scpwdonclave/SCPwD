@extends('layout.master')
@section('title', 'Checkout')
@section('parentPageTitle', 'eCommerce')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-steps/jquery.steps.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/ecommerce.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card ec-checkout">
                <div class="body">
                    <div id="wizard_horizontal">
                        <h2>Sign Up</h2>
                        <section>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter User Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <h2>Shipping</h2>
                        <section>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-2" placeholder="Address Line 1">
                                        <input type="text" class="form-control" placeholder="Address Line 2">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <select class="form-control show-tick">
                                        <option value="Country">Country</option>
                                        <option value="10">India</option>
                                        <option value="20">USA</option>
                                        <option value="30">UK</option>
                                        <option value="40">Brazil</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="State">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Zip Code">
                                    </div>
                                </div>                                    
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="tel" class="form-control" placeholder="Phone Number">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <h2>Payment</h2>
                        <section>
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12">
                                    <select class="form-control show-tick mb-3">
                                        <option value="Card Type">Card Type:</option>
                                        <option value="Visa">Visa</option>
                                        <option value="MasterCard">MasterCard</option>
                                        <option value="American Express">American Express</option>
                                        <option value="Discover">Discover</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Credit Card Number">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Card CVV">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <label class="pl-2">Expiration:</label>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Month">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Year">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <img src="../assets/images/ecommerce/visa-card.png" alt="">
                                        <img src="../assets/images/ecommerce/mastercard.png" alt="">
                                        <img src="../assets/images/ecommerce/paypal.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <h2>Review Cart</h2>
                        <section>
                            <div class="product_item_list cart-page">
                                <div class="table-responsive">
                                    <table class="table table-hover m-b-0 cart-table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th data-breakpoints="xs">Amount</th>
                                                <th data-breakpoints="sm xs md">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><img src="../assets/images/ecommerce/1.png" width="40" alt="Product img"></td>
                                                <td><h5>Simple Black Clock</h5></td>
                                                <td>
                                                    <div class="quantity-grp">
                                                        <div class="input-group spinner" data-trigger="spinner">                                    
                                                            <span class="input-group-addon">
                                                                <a href="javascript:void(0);" class="spin-up" data-spin="up"><i class="zmdi zmdi-plus"></i></a>
                                                            </span>
                                                            <input type="text" class="form-control text-center" value="1" data-rule="quantity">
                                                            <span class="input-group-addon">
                                                                <a href="javascript:void(0);" class="spin-down" data-spin="down"><i class="zmdi zmdi-minus"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$16.00</td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                    <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="../assets/images/ecommerce/10.png" width="40" alt="Product img"></td>
                                                <td><h5>Brone Candle</h5></td>
                                                <td>
                                                    <div class="quantity-grp">
                                                        <div class="input-group spinner" data-trigger="spinner">                                    
                                                            <span class="input-group-addon">
                                                                <a href="javascript:void(0);" class="spin-up" data-spin="up"><i class="zmdi zmdi-plus"></i></a>
                                                            </span>
                                                            <input type="text" class="form-control text-center" value="1" data-rule="quantity">
                                                            <span class="input-group-addon">
                                                                <a href="javascript:void(0);" class="spin-down" data-spin="down"><i class="zmdi zmdi-minus"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$15.00</td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                    <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><img src="../assets/images/ecommerce/11.png" width="40" alt="Product img"></td>
                                                <td><h5>Wood Simple Clock</h5></td>
                                                <td>
                                                    <div class="quantity-grp">
                                                        <div class="input-group spinner" data-trigger="spinner">                                    
                                                            <span class="input-group-addon">
                                                                <a href="javascript:void(0);" class="spin-up" data-spin="up"><i class="zmdi zmdi-plus"></i></a>
                                                            </span>
                                                            <input type="text" class="form-control text-center" value="1" data-rule="quantity">
                                                            <span class="input-group-addon">
                                                                <a href="javascript:void(0);" class="spin-down" data-spin="down"><i class="zmdi zmdi-minus"></i></a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$16.00</td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                    <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float btn-sm waves-red"><i class="zmdi zmdi-delete"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">Subtotal</th>
                                                <th colspan="2">$47.00</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-steps/jquery.steps.js')}}"></script>
<script src="{{asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/form-wizard.js')}}"></script>
@stop