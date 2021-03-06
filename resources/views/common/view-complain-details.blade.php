@extends('layout.master')
@section('title', 'Support')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/customtimeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($complain->token_id))
                        <div class="text-center">
                            <h6>
                                TOKEN ID: <span style='color:blue'>{{$complain->token_id}}</span>
                            </h6>
                        </div>
                        <br>
                        <div class="timeline">
                            <div class="events">
                                <ol>
                                    <ul>
                                        <li>
                                            <a href="javascript::void()" class="selected">Initiated<br>{{ \Carbon\Carbon::parse($complain->created_at)->format('d-m-Y')}}</a>
                                        </li>
                                        <li>
                                            @if (is_null($complain->process_at))
                                                <a href="javascript::void()">Not Processed Yet</a>
                                            @else
                                                <a href="javascript::void()" class="selected">Processing<br>{{\Carbon\Carbon::parse($complain->process_at)->format('d-m-Y')}}</a>
                                            @endif
                                        </li>
                                        <li>
                                            @if (is_null($complain->closed_at))
                                                <a href="javascript::void()">Not Closed Yet</a>
                                            @else
                                                <a href="javascript::void()" class="selected">Closed<br>{{\Carbon\Carbon::parse($complain->closed_at)->format('d-m-Y')}}</a>
                                            @endif
                                        </li>
                                    </ul>
                                </ol>
                            </div>
                        </div>
                        <br>
                    @endif
                   
                    <ul class="cbp_tmtimeline">
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Complain Information</span></time>
                            <div class="cbp_tmicon bg-blue"> <i class="zmdi zmdi-local-store"></i></div>
                            <div class="cbp_tmlabel">
                                
                                <div class="row">
                                        <div class="col-sm-3">
                                            <small class="text-muted">Subject line</small>
                                                <p>{{$complain->subject}}</p>
                                            <hr>
                                        </div>
                                    
                                        <div class="col-sm-3">
                                                <small class="text-muted">Issue Type</small>
                                                <p>{{$complain->issue}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-3">
                                                <small class="text-muted">Complain Date</small>
                                                <p>{{\Carbon\Carbon::parse($complain->created_at)->format('d-m-Y')}}</p>
                                                <hr>
                                        </div>
                                        <div class="col-sm-3">
                                                <small class="text-muted">Complain Time</small>
                                                <p>{{\Carbon\Carbon::parse($complain->created_at)->format('g:i A')}}</p>
                                                <hr>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Description Of Issue</small>
                                        <p>{{$complain->description}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Closure Comment</small>
                                        <p>{{$complain->closure_comment}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Closure Attachement</small>
                                        @if (is_null($complain->attachment))
                                            <p>No Document Provided</p>
                                        @else
                                            <p>Document
                                                &nbsp;&nbsp;
                                            <a class="btn-icon-mini" href="{{route(Request::segment(1).'.support.complain-file',['id'=>$complain->id,'action'=>'download','column'=>'attachment'])}}" ><i class="zmdi zmdi-download"></i></a>
                                            </p>
                                        @endif
                                        <hr>
                                    </div>
                                </div>
                                
                            </div>
                        </li>
                        @if ($complain->complainfile->isNotEmpty())
                            <li>
                                <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Complain Files</span></time> 
                                <div class="cbp_tmicon bg-pink"> <i class="zmdi zmdi-pin"></i></div>
                                <div class="cbp_tmlabel">
                                    
                                <div class="table-responsive">
                                        <table class="table m-b-0">
                                            <thead>
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>File</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=0;
                                                @endphp
                                                @foreach ($complain->complainfile as $item) 
                                                    <tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        <td>{{$i}}</td>
                                                        <td>Sample File {{$i}} &nbsp;&nbsp;<a class="btn-icon-mini" href="{{route(Request::segment(1).'.support.complain-file',['id'=>$item->id,'action'=>'download','column'=>'screen_shot'])}}" ><i class="zmdi zmdi-download"></i></a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                    @auth('admin')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Request::segment(1)==='admin')                        
                            @if ($complain->stage !='Closed')
                                <div class="row d-flex justify-content-center m-t-20 m-b-20">
                                    <h6>
                                        @if ($complain->assign_onclave)
                                            You have <span style="color:blue">Assigned</span> This Issue to <span style="color:blue"> Onclave Systems Support Team</span>
                                        @else
                                            Assign this Issue to <button type="button" onclick="location.href='{{route('admin.support.assign-to-onclave',Crypt::encrypt($complain->id))}}'" class="badge margin-0" title="Click to Assign it to Onclave Systems" style="color:blue">Onclave Systems Support Team</button> 
                                        @endif
                                    </h6>
                                </div>
                                <div class="row d-flex justify-content-center">
                                    @if ($complain->stage === 'Processing')
                                        <button class="btn btn-danger m-l-10" data-toggle="modal" data-target="#defaultModal">Mark as <strong>Closed</strong></button>
                                    @else
                                        <button class="btn btn-primary m-r-10" onclick="location.href='{{route('admin.support.stage-process',Crypt::encrypt($complain->id))}}';this.disabled = true;">Mark as <strong>Processing</strong></button>
                                        <button class="btn btn-danger m-l-10" data-toggle="modal" data-target="#defaultModal">Mark as <strong>Closed</strong></button>
                                    @endif
                                </div>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('modal')
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog"> 
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="title" id="defaultModalLabel">Closure Comments</h5>
                </div>
                <div class="modal-body">
                    <form id="form_modal" method="POST" action="{{route('admin.support.stage-close')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="cid" value="{{Crypt::encrypt($complain->id)}}">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-12">
                                <label for="comment">Closure Comment <span style="color:red"> <strong>*</strong></span></label>    
                                <div class="form-group form-float">
                                    <input type="text" class="form-control" placeholder="Closure Comments" name="comment" required>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-12">
                                <label for="attachment">Attachment</label>    
                                <div class="form-group form-float">
                                    <input type="file" class="form-control" name="attachment">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button id="btnSubmit" class="btn btn-raised btn-primary btn-round waves-effect" type="submit" >Close This Issue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>
@stop