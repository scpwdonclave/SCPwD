@extends('layout.master')
@section('title', 'Batch')
{{-- @section('parentPageTitle', 'Partners-verify') --}}
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/timeline.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    @if (!is_null($batchData->batch_id))
                        <div class="text-center">
                            <h6>
                                Batch ID: <span style='color:blue'>{{$batchData->batch_id}}</span>
                            </h6>
                        </div>
                        <br>
                    @endif
                    <ul class="cbp_tmtimeline">
                        
                        <li>
                            <time class="cbp_tmtime" datetime="2017-11-03T13:22"><span>Batch Details</span></time>
                            <div class="cbp_tmicon bg-green"> <i class="zmdi zmdi-account"></i></div>
                            <div class="cbp_tmlabel">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Partner ID</small>
                                        <p>{{$batchData->partner->tp_id}}</p>
                                        <hr>
                                    </div>
                                
                                    <div class="col-sm-4">
                                        <small class="text-muted">Training Center ID</small>
                                        <p>{{$batchData->center->tc_id}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Trainer ID</small>
                                        <p>{{$batchData->trainer->trainer_id}}</p>
                                        <hr>
                                    </div>
                                  
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">Scheme</small>
                                        <p>{{$batchData->scheme}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted">Job Role</small>
                                        <p>{{$batchData->job_role}}</p>
                                        <hr>
                                    </div>
                                
                                    {{-- <div class="col-sm-4">
                                        <small class="text-muted">Document Number</small>
                                        <p>
                                            {{$batchData->doc_no}} &nbsp;&nbsp;
                                            <a class="btn-icon-mini" href="{{route('trainer.files.trainer-file',['id'=>$batchData->id,'action'=>'download','filename'=>basename($batchData->doc_file)])}}" download="{{basename($batchData->doc_file)}}"><i class="zmdi zmdi-download"></i></a>
                                        </p>
                                        <hr>
                                    </div> --}}
                
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <small class="text-muted">Batch start Date</small>
                                        <p>{{$batchData->batch_start_time}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Batch End Date</small>
                                        <p>{{$batchData->batch_end_time}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4">
                                        <small class="text-muted">Assesment Date</small>
                                        <p>{{$batchData->assesment_date}}</p>
                                        <hr>
                                    </div>
                
                                </div>
                            </div>
                        </li>
                        
                    </ul>
                    @auth('admin')
                        <div class="text-center" >
                            @if (Request::segment(1)==='admin')
                            @if ($batchData->status==0 && $batchData->verified==0)
                            <button class="btn btn-success" onclick="location.href='{{route('admin.bt.batch.verify',['batch_id' => Crypt::encrypt($batchData->id) ])}}';this.disabled = true;">Accept</button>
                            <button class="btn btn-danger" onclick="showPromptMessage();">Reject</button>
                            @endif
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =================== --}}
<div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Batch</strong> Students</h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Aadhaar</th>
                                        <th>View</th>
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                       
                                       @foreach ($candidates as $key=>$item)
                                           
                                       <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->candidate->name}}</td>
                                        <td>{{$item->candidate->contact}}</td>
                                        <td>{{$item->candidate->email}}</td>
                                        <td>{{$item->candidate->doc_no}}</td>
                                        <td><a class="badge bg-green margin-0" href="{{route('admin.tc.candidate.view',['id'=>$item->candidate->id])}}" >View</a></<td>
                                        
                                    </tr>
                                    @endforeach     
                                      
                                        
                                       
                                    </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div>
{{-- =================== --}}
@stop
@section('page-script')
@auth('admin')
    <script>
        function showPromptMessage() {
            swal({
                title: "Reason of Rejection",
                text: "Please Describe the Reason",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                inputPlaceholder: "Reason"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!"); return false
                }
                var id={{$batchData->id}};
                var note=inputValue;
                let _token = $("input[name='_token']").val();
            
                $.ajax({
                type: "POST",
                url: "{{route('admin.bt.reject.batch')}}",
                data: {_token,id,note},
                success: function(data) {
                    // console.log(data);
                    swal({
                title: "Deleted",
                text: "Record Deleted",
                type:"success",
                //timer: 2000,
                showConfirmButton: true
            },function(isConfirm){
        
                if (isConfirm){
                
                window.location="{{route('admin.batch.pb')}}";
        
                } 
                });
            
                }
            });
                
            });
        }
    </script>
@endauth

<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop