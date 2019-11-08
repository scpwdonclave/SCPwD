@extends('layout.master')
@section('title', 'Batch Updates')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/morrisjs/morris.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
{{-- DATA Tables --}}

<div class="row clearfix">
    <div class="col-md-12 col-lg-8">
        <div class="card">
            <div class="header">
                <h2><strong>Batch Updates</strong> Record </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Batch ID</th>
                                <th>Trainer ID</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Batch</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($batchupdates as $key=>$item)                              
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->batch->batch_id}}</td>
                                <td>{{$item->trainer->trainer_id}}</td>
                                <td class="text-{{($item->approved)?'success':'danger'}}">{{($item->approved)?'Approved':'Rejected'}}</td>
                                <td><button class="badge margin-0" style="align:right;" onclick="location.href='#viewModal{{$item->id}}'" data-toggle="modal" data-target="#viewModal{{$item->id}}" >show</button></td>
                                <td><a class="badge bg-green margin-0" href="{{route('admin.bt.batch.view',['id'=>Crypt::encrypt($item->batch->id)])}}" >View</a></td>
                            </tr>
                                @section('modal')
                                <div class="modal fade" id="viewModal{{$item->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="nobtn table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Old Data</th>
                                                                    <th>New data</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-weight:bold">Trainer</td>
                                                                    <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'firebrick'}}">{{$item->trainer->trainer_id}}</td>
                                                                    <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'green'}}">{{$item->new_trainer->trainer_id}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-weight:bold">End Date</td>
                                                                    <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'firebrick'}}">{{$item->batch->batch_end}}</td>
                                                                    <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'green'}}">{{$item->end_date}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-weight:bold">Assessment</td>
                                                                    <td style="color:{{$item->assessment==$item->batch->assessment? null: 'firebrick'}}">{{$item->batch->assessment}}</td>
                                                                    <td style="color:{{$item->assessment==$item->batch->assessment? null: 'green'}}">{{$item->assessment}}</td>
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
                                @endsection
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="card activities">
            <div class="header">
                <h2><strong>Batch Update</strong> Request</h2>
            </div>
            <div class="body">
                @if(count($updaterequests) > 0)
                    <ul class="list-unstyled activity">
                    @foreach ($updaterequests as $item)
                        <li>
                            <a href="javascript:void(0);">
                                <i class="zmdi zmdi-tag bg-blush"></i>
                                <div class="info">
                                <h4>{{$item->batch->batch_id}}</h4>                    
                                <small><strong>Trainer: </strong>{{$item->new_trainer->trainer_id}}</small> <br>
                                <small><strong>End Date: </strong>{{$item->end_date}}</small><br>
                                <small><strong>Assessment: </strong>{{$item->assessment}}</small><br>
                                
                                <button  class="btn btn-sm" style="align:right;" onclick="location.href='#smallModal{{$item->id}}'" data-toggle="modal" data-target="#smallModal{{$item->id}}" >show</button>    
                                <button  class="btn btn-success btn-sm" style="align:right;" onclick="location.href='{{route('admin.batch.bu.submit',['id' =>Crypt::encrypt($item->batch->id),'action'=>'accept'])}}'" >Accept</button>    
                                <button  class="btn btn-danger btn-sm" style="align:right;"  onclick="showPromptMessage({{$item->id}});" >Reject</button>    
                            </div>
                                
                            </a>
                        </li>
                        <div class="modal fade" id="smallModal{{$item->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="nobtn table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Old Data</th>
                                                        <th>New data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="font-weight:bold">Trainer</td>
                                                        <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'firebrick'}}">{{$item->trainer->trainer_id}}</td>
                                                        <td style="color:{{$item->tr_id==$item->new_tr_id? null: 'green'}}">{{$item->new_trainer->trainer_id}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold">End Date</td>
                                                        <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'firebrick'}}">{{$item->batch->batch_end}}</td>
                                                        <td style="color:{{$item->end_date==$item->batch->batch_end? null: 'green'}}">{{$item->end_date}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-weight:bold">Assessment</td>
                                                        <td style="color:{{$item->assessment==$item->batch->assessment? null: 'firebrick'}}">{{$item->batch->assessment}}</td>
                                                        <td style="color:{{$item->assessment==$item->batch->assessment? null: 'green'}}">{{$item->assessment}}</td>
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
                            <i class="zmdi zmdi-mood zmdi-hc-4x"></i>
                            <h4 class="m-b-0">No pending record found.</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
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
        function showPromptMessage(f) {
            swal({
                title: "An input!",
                text: "Write something interesting:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            }, function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("You need to write something!"); return false
                }
                var id=f;
                //console.log(id);
                
                var note=inputValue;
                let _token = $("input[name='_token']").val();
            //console.log(note);
                $.ajax({
                type: "POST",
                url: "{{route('admin.reject.tp-updt-req')}}",
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