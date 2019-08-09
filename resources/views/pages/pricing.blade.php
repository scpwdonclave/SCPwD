@extends('layout.master')
@section('title', 'Pricing')
@section('parentPageTitle', 'Pages')
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-dark sprice text-center">
                <div class="body">
                    <h4 class="col-white">STARTER</h4>
                    <div class="sprice-circle l-slategray">
                        <span>$</span>9
                    </div>
                    <ul class="list-unstyled m-t-10">
                        <li>25GB Storage</li>
                        <li>300GB Brandwidth</li>
                        <li>20 Email Accounts</li>
                        <li>10 Databases</li>
                        <li>12 Domain</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-simple">Sign Up</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-dark sprice text-center">
                <div class="body">
                    <h4 class="col-white">BUSINESS</h4>
                    <div class="sprice-circle l-amber">
                        <span>$</span>19
                    </div>
                    <ul class="list-unstyled m-t-10">
                        <li>10GB Storage</li>
                        <li>300GB Brandwidth</li>
                        <li>20 Email Accounts</li>
                        <li>12 Databases</li>
                        <li>12 Databases</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-round">Sign Up</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-dark sprice text-center">
                <div class="body">
                    <h4 class="col-white">PREMIUM</h4>
                    <div class="sprice-circle l-slategray">
                        <span>$</span>39
                    </div>
                    <ul class="list-unstyled m-t-10">
                        <li>100GB Storage</li>
                        <li>500GB Brandwidth</li>
                        <li>100 Email Accounts</li>
                        <li>20 Databases</li>
                        <li>30 Domain</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-simple">Sign Up</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-dark sprice text-center">
                <div class="body">
                    <h5 class="col-white">ULTIMATE</h5>
                    <div class="sprice-circle l-slategray">
                        <span>$</span>59
                    </div>
                    <ul class="list-unstyled m-t-10">
                        <li>1TB Storage</li>
                        <li>Unlimited Bandwidth</li>
                        <li>500 Email Accounts</li>
                        <li>Unlimited Domains</li>
                        <li>Unlimited Domains</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-simple">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="card sprice2">                    
                <div class="body data text-center">
                    <h2>$9</h2>
                    <ul class="list-unstyled m-t-10">
                        <li>25GB Storage</li>                            
                        <li>20 Email Accounts</li>
                        <li>10 Databases</li>
                        <li>12 Domain</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-simple btn-round">Sign Up</button>
                </div>
                <div class="name l-amber">                        
                    <h5><i class="zmdi zmdi-label-alt m-r-10"></i> <span>STARTER</span></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="card sprice2">                    
                <div class="body data text-center">
                    <h2>$29</h2>
                    <ul class="list-unstyled m-t-10">
                        <li>100GB Storage</li>                            
                        <li>50 Email Accounts</li>
                        <li>20 Databases</li>
                        <li>15 Domain</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-round">Sign Up</button>
                </div>
                <div class="name l-parpl">                        
                    <h5><i class="zmdi zmdi-label-alt m-r-10"></i> <span>BUSINESS</span></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="card sprice2">                    
                <div class="body data text-center">
                    <h2>$39</h2>
                    <ul class="list-unstyled m-t-10">
                        <li>500GB Storage</li>                            
                        <li>100 Email Accounts</li>
                        <li>50 Databases</li>
                        <li>30 Domain</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-simple btn-round">Sign Up</button>
                </div>
                <div class="name l-pink">                        
                    <h5><i class="zmdi zmdi-label-alt m-r-10"></i> <span>PREMIUM</span></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-3">
            <div class="card sprice2">                    
                <div class="body data text-center">
                    <h2>$59</h2>
                    <ul class="list-unstyled m-t-10">
                        <li>1TB Storage</li>                            
                        <li>200 Email Accounts</li>
                        <li>Unlimited Domains</li>
                        <li>Unlimited Domains</li>
                        <li>Free backup</li>
                    </ul>
                    <button class="btn btn-primary btn-simple btn-round">Sign Up</button>
                </div>
                <div class="name l-blue">                        
                    <h5><i class="zmdi zmdi-label-alt m-r-10"></i> <span>ULTIMATE</span></h5>
                </div>
            </div>
        </div>
    </div>        
</div>
@stop