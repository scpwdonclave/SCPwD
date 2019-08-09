@extends('layout.master')
@section('title', 'Calendar')
@section('parentPageTitle', 'App')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}">
@stop
@section('content')
<div class="container-fluid page-calendar">
    <div class="row">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <div class="card">
                <div class="body">
                    <button type="button" class="btn btn-round btn-info waves-effect" data-toggle="modal" data-target="#addevent">Add Events</button>
                    <div>
                        <hr>
                        <div class="event-name b-primary row">
                            <div class="col-2 text-center">
                                <h4>11<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-10">
                                <h6>Conference</h6>
                                <p>Mobile World Congress 2018</p>
                                <address><i class="zmdi zmdi-pin"></i> 71 Pilgrim Avenue Chevy Chase, MD 20815</address>
                            </div>
                        </div>                            
                        <div class="event-name b-primary row">
                            <div class="col-2 text-center">
                                <h4>13<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-10">
                                <h6>Birthday</h6>
                                <p>Today, guests are getting in on the action</p>
                                <address><i class="zmdi zmdi-pin"></i> 4 Goldfield Rd. Honolulu, HI 96815</address>
                            </div>
                        </div>
                        <hr>
                        <div class="event-name b-lightred row">
                            <div class="col-2 text-center">
                                <h4>09<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-10">
                                <h6>Repeating Event</h6>
                                <p>Before there were tech conferences, there was Disrupt.</p>
                                <address><i class="zmdi zmdi-pin"></i> 44 Shirley Ave. West Chicago, IL 60185</address>
                            </div>
                        </div>
                        <hr>
                        <div class="event-name b-greensea row">
                            <div class="col-2 text-center">
                                <h4>16<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-10">
                                <h6>Repeating Event</h6>
                                <p>It is a long established fact that a reader will be distracted</p>
                                <address><i class="zmdi zmdi-pin"></i> 123 6th St. Melbourne, FL 32904</address>
                            </div>
                        </div>
                        <div class="event-name b-greensea row">
                            <div class="col-2 text-center">
                                <h4>28<span>Dec</span><span>2017</span></h4>
                            </div>
                            <div class="col-10">
                                <h6>Google</h6>
                                <p>Google Hardware and Pixel 2 Launch</p>
                                <address><i class="zmdi zmdi-pin"></i> 514 S. Magnolia St. Orlando, FL 32806</address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8 col-xl-8">
            <div class="card">
                <div class="body">
                    <button class="btn btn-primary btn-round waves-effect" id="change-view-today">today</button>
                    <button class="btn btn-default btn-simple btn-round waves-effect" id="change-view-day" >Day</button>
                    <button class="btn btn-default btn-simple btn-round waves-effect" id="change-view-week">Week</button>
                    <button class="btn btn-default btn-simple btn-round waves-effect" id="change-view-month">Month</button>
                    <div id="calendar" class="m-t-20"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('modal')
<div class="modal fade" id="addevent" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">Add Event</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-line">
                        <input type="number" class="form-control" placeholder="Event Date">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" placeholder="Event Title">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <textarea class="form-control no-resize" placeholder="Event Description..."></textarea>
                    </div>
                </div>       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-round waves-effect">Add</button>
                <button type="button" class="btn btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/bundles/fullcalendarscripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/calendar/calendar.js')}}"></script>
@stop