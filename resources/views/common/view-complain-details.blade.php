@extends('layout.master')
@section('title', 'Support')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
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
                                  <a href="#0" class="selected">Initiated<br>{{ \Carbon\Carbon::parse($complain->created_at)->format('d-m-Y')}}</a>
                                  </li>
                                  <li>
                                    <a href="#1" class="{{$complain->process_at === null ? '' :'selected'}}">Processing<br>{{($complain->process_at) === null ? '' : \Carbon\Carbon::parse($complain->process_at)->format('d-m-Y')}}</a>
                                  </li>
                                  <li>
                                  <a href="#2" class="{{$complain->closed_at === null ? '' :'selected'}}">Closed<br>{{($complain->closed_at) === null ? '' : \Carbon\Carbon::parse($complain->closed_at)->format('d-m-Y')}}</a>
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
                                                        <th>#</th>
                                                        
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
                    @if ($complain->stage !='Closed')
                        <div class="row d-flex justify-content-center m-t-20 m-b-20">
                            <h6>
                                @if ($complain->assign_onclave)
                                    You have <span style="color:blue">Assigned</span> This Isuue to <span style="color:blue"> Onclave Systems Support Team</span>
                                @else
                                    Assign this Issue to <button type="button" onclick="location.href='{{route('admin.support.assign-to-onclave',Crypt::encrypt($complain->id))}}'" class="badge margin-0" title="Click to Assign it to Onclave Systems" style="color:blue">Onclave Systems Support Team</button> 
                                @endif
                            </h6>
                        </div>
                        <form id="form_complain" action="{{route('admin.support.stage-define')}}" method="post">
                            @csrf
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-4">
                                    <label for="stage">Select Stage <span style="color:red"> <strong>*</strong></span></label>
                                    <div class="form-group form-float">
                                        <select class="form-control show-tick" data-live-search="true" name="stage"  required>
                                            <option value="">--Select--</option>
                                            <option value="Processing">Processing</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="comp_id" value="{{$complain->id}}">
                            <div class="text-center" >
                                <button class="btn btn-round btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')

<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>
@stop