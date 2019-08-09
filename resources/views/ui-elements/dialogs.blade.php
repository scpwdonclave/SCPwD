@extends('layout.master')
@section('title', 'Dialogs')
@section('parentPageTitle', 'UI')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix js-sweetalert">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="body">
                    <p>A basic message</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="basic">CLICK ME</button>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <p>A title with a text under</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="with-title">CLICK ME</button>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <p>A success message!</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="success">CLICK ME</button>
                </div>
            </div>                
            <div class="card">
                <div class="body">
                    <p>A message with a custom icon</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="with-custom-icon">CLICK ME</button>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <p>A warning message, with a function attached to the <b>Confirm</b> button...</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="confirm">CLICK ME</button>
                </div>
            </div>                
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="body">
                    <p>An HTML message</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="html-message">CLICK ME</button>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <p>A message with auto close timer</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="autoclose-timer">CLICK ME</button>
                </div>
            </div>
            <div class="card">
                <div class="body">
                    <p>A replacement for the <b>prompt</b> function</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="prompt">CLICK ME</button>
                </div>
            </div>
            <div class="card">
                <div class="body">
                        <p>With a loader (for AJAX request for example)</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="ajax-loader">CLICK ME</button>
                </div>
            </div>
            <div class="card">
                <div class="body">
                        <p>... and by passing a parameter, you can execute something else for <b>Cancel</b>.</p>
                    <button class="btn btn-raised btn-primary waves-effect btn-round" data-type="cancel">CLICK ME</button>
                </div>
            </div>               
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/pages/ui/dialogs.js')}}"></script>
@stop