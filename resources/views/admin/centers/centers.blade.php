@extends('layout.master')
@section('title', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')
{{-- DATA Tables --}}

<div class="row clearfix">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Training Center</strong> Record </h2>
            </div>
            <div class="body">
                {{-- <button type="button" class="btn  btn-simple btn-sm btn-default btn-filter" data-target="all">All</button>
                <button type="button" class="btn  btn-simple btn-sm btn-success btn-filter" data-target="approved">Active</button>
                <button type="button" class="btn  btn-simple btn-sm btn-warning btn-filter" data-target="suspended">Suspended</button>
                <button type="button" class="btn  btn-simple btn-sm btn-info btn-filter" data-target="pending">Pending</button> --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Spoc Name</th>
                                <th>Spoc Email</th>
                                <th>Spoc Mobile</th>
                                <th style="width:20px;">Incorp. Document</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key=>$item)
                                
                            <tr>
                            @if ($item->status==1)
                            <td><i class="zmdi zmdi-circle text-success"></i></td>
                            @elseif ($item->status==0)
                            <td><i class="zmdi zmdi-circle text-danger"></i></td>
                            @endif
                            <td>{{$item->spoc_name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->spoc_mobile}}</td>
                                <td class="text-center">
                                    <a class="" href="#largeModal{{$item->id}}" data-toggle="modal" data-target="#largeModal{{$item->id}}"><i class="zmdi zmdi-eye"></i></a>
                                </td>
                            @if ($item->status==1 && $item->complete_profile==1 && $item->pending_verify==0)
                            <td><span class="badge badge-success">Approved</span></td>
                            <td ><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.verify',['id'=>$item->id])}}" >View</a></td>
                            <td><a class="badge bg-red margin-0" href="{{route('admin.training_partner.partner.deactive',['id'=>$item->id])}}" >Deactive</a></td>
                            @elseif($item->status==1 && $item->complete_profile==1 && $item->pending_verify==1)
                            <td><span class="badge badge-info">Pending</span></td>
                            <td ><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.verify',['id'=>$item->id])}}" >View</a></td>
                            <td><a class="badge bg-red margin-0" href="{{route('admin.training_partner.partner.deactive',['id'=>$item->id])}}" >Deactive</a></td>
                            @elseif($item->status==1 && $item->complete_profile==0 && $item->pending_verify==null)
                            <td><span class="badge badge-warning">First Instance</span></td>
                            <td>&nbsp;</td>
                            <td><a class="badge bg-red margin-0" href="{{route('admin.training_partner.partner.deactive',['id'=>$item->id])}}" >Deactive</a></td>
                            @elseif($item->status==0)
                            <td><span class="badge badge-danger">Deactive</span></td>
                            <td>&nbsp;</td>
                            <td><a class="badge bg-green margin-0" href="{{route('admin.training_partner.partner.active',['id'=>$item->id])}}" >Active</a></td>
                            
                            @endif

                                
                            </tr>
                            <div class="modal fade" id="largeModal{{$item->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            
                                            <div class="modal-body embed-responsive embed-responsive-16by9">
                                                    <iframe class="embed-responsive-item" src="{{route('partner.files.partner-file',['action'=>'view','filename'=>basename($item->incorp_doc)])}}" allowfullscreen runat="server">
                                                </iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{route('partner.files.partner-file',['action'=>'download','filename'=>basename($item->incorp_doc)])}}" download="{{substr($item->incorp_doc,8)}}" class="btn btn-default btn-round waves-effect">Download</a>
                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                           
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot> --}}
                    </table>
                    </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-12 col-lg-4">
            <div class="card activities">
                    <div class="header">
                        <h2><strong>Training Partner Update</strong> Request</h2>
                    </div>
                    <div class="body">
                            @if(!$tp_updt_req->isEmpty())
                        <ul class="list-unstyled activity">
                       @foreach ($tp_updt_req as $item)
                       <li>
                            <a href="javascript:void(0);">
                                <i class="zmdi zmdi-tag bg-blush"></i>
                                <div class="info">
                                <h4>{{$item->uname}}</h4>                    
                                <small><strong>Email: </strong>{{$item->uemail}},{{$item->tp_id}}</small> <br>
                                <small><strong>Phone: </strong>{{$item->umobile}}</small><br>
                                
                                <button  class="btn btn-sm" style="align:right;" onclick="location.href='#smallModal{{$item->id}}'" data-toggle="modal" data-target="#smallModal{{$item->id}}" >show</button>    
                                <button  class="btn btn-success btn-sm" style="align:right;" onclick="location.href='{{route('admin.accept.tp-updt-req',['id' =>$item->id,'tp_id'=>$item->tp_id])}}'" >Accept</button>    
                                <button  class="btn btn-danger btn-sm" style="align:right;"  onclick="showPromptMessage({{$item->id}},'{{$item->tp_id}}');" >Reject</button>    
                                
                            </div>
                               
                            </a>
                        </li>
                        <div class="modal fade" id="smallModal{{$item->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        
                                            <div class="modal-body">
                                                    <div class="table-responsive">
                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Old Data</th>
                                                                        <th>New data</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="font-weight:bold">Name</td>
                                                                        @if ($item->pname==$item->uname)
                                                                        <td>{{$item->pname}}</td>
                                                                        <td>{{$item->uname}}</td>
                                                                        @else
                                                                        <td style="color:firebrick">{{$item->pname}}</td>
                                                                        <td style="color:green">{{$item->uname}}</td>
                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-weight:bold">Email</td>
                                                                        @if ($item->pemail==$item->uemail)
                                                                        <td>{{$item->pemail}}</td>
                                                                        <td>{{$item->uemail}}</td>
                                                                        @else
                                                                        <td style="color:firebrick">{{$item->pemail}}</td>
                                                                        <td style="color:green">{{$item->uemail}}</td>
                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-weight:bold">Phone</td>
                                                                        @if ($item->pmobile==$item->umobile)
                                                                        <td>{{$item->pmobile}}</td>
                                                                        <td>{{$item->umobile}}</td>
                                                                        @else
                                                                        <td style="color:firebrick">{{$item->pmobile}}</td>
                                                                        <td style="color:green">{{$item->umobile}}</td>
                                                                        @endif
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                            </div>
                                        <div class="modal-footer">
                                            
                                            <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       @endforeach
                        </ul>
                        @else 
                        <div class="body text-center">
                            <div class="not_found">
                                <i class="zmdi zmdi-mood-bad zmdi-hc-4x"></i>
                                <h4 class="m-b-0">No pending record found.</h4>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
        </div> --}}
    </div>

{{-- End DATA Tables --}}


@stop
@section('page-script')
<script>
    $(document).ready(function () {
        $('.star').on('click', function () {
            $(this).toggleClass('star-checked');
        });

        $('.ckbox label').on('click', function () {
            $(this).parents('tr').toggleClass('selected');
        });

        $('.btn-filter').on('click', function () {
            var $target = $(this).data('target');
            if ($target != 'all') {
                $('.table tr').css('display', 'none');
                $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
            } else {
                $('.table tr').css('display', 'none').fadeIn('slow');
            }
        });
    });
</script>
<script>
        function showPromptMessage(f,t) {
                // d = f.split(',');
                console.log(t);
            swal({
                title: "An input!",
                text: "Write something interesting:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!"); return false
                }
                var id=f;
                var tpid=t;
                
                var note=inputValue;
                let _token = $("input[name='_token']").val();
            //console.log(note);
                $.ajax({
                type: "POST",
                url: "{{route('admin.reject.tp-updt-req')}}",
                data: {_token,id,tpid,note},
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
                //swal("Shortlisted!", "Candidates are successfully shortlisted!", "success");
                window.location="{{route('admin.tp.partners')}}";
        
                } 
                });
            
                }
            });
            });
        }
        </script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop