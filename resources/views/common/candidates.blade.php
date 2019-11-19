@extends('layout.master')
@section('title', 'Candidates')
@section('page-style')
<!-- Custom Css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>

<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>My</strong> Candidates</h2>
                    @if (Request::segment(1) === 'center')
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('center.addcandidate')}}">Add New Candidate</a>                      
                    @endif
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @if (Request::segment(1) === 'admin')
                                        <th>TP</th>
                                    @endif
                                    @if (Request::segment(1) !== 'center')
                                        <th>TC</th>
                                    @endif
                                    <th>Candidate Name</th>
                                    <th>Contact</th>
                                    <th>Category</th>
                                    <th>Date of Birth</th>
                                    <th>Overall Status</th>
                                    @if (Request::segment(1) === 'admin')
                                        <th>Action</th>
                                    @endif
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidates as $key => $candidate)
                                    
                                <tr>
                                <td>{{$key+1}}</td>
                                @if (Request::segment(1) === 'admin')
                                    <td>{{$candidate->center->partner->tp_id}}</td>
                                @endif
                                @if (Request::segment(1) !== 'center')
                                    <td>{{$candidate->center->tc_id}}</td>
                                @endif
                                <td>{{$candidate->name}}</td>
                                <td>{{$candidate->contact}}</td>
                                <td>{{$candidate->category}}</td>
                                <td>{{$candidate->dob}}</td>
                                <td style="color:{{($candidate->jobrole->partnerjobrole->status && $candidate->center->partner->status && $candidate->center->status && $candidate->status)?'green':'red'}}">{{($candidate->jobrole->partnerjobrole->status && $candidate->center->partner->status && $candidate->center->status && $candidate->status)?'Active':'Inactive'}}</td>
                                @if (Request::segment(1)==='admin')
                                    @if($candidate->status)
                                        <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$candidate->id}})">Deactivate</a></td>
                                    @else
                                        <td><a class="badge bg-green margin-0" href="{{route('admin.tc.candidate.active',Crypt::encrypt($candidate->id))}}" >Activate</a></td>
                                    @endif
                                @endif
                                <td><a class="badge bg-green margin-0" href="{{route(Request::segment(1).(Request::segment(1) === 'center' ? null : '.tc').'.candidate.view',Crypt::encrypt($candidate->id))}}" >View</a></td>
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
@endsection

@section('page-script')
<script>
function showCancelMessage(f) {
    console.log(f);
    
    swal({
        title: "Deactive!",
        text: "Write Reason for Deactive:",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        showLoaderOnConfirm: true,
        inputPlaceholder: "Write reason"
    }, function (inputValue) {
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("You need to write something!"); return false
        }
        var id=f;
        var reason=inputValue;
        let _token = $("input[name='_token']").val();
   
        $.ajax({
        type: "POST",
        url: "{{route('admin.tc.candidate.deactive')}}",
        data: {_token,id,reason},
        success: function(data) {
           // console.log(data);
           swal({
        title: "Deactive",
        text: "Candidate Record Deactive",
        type:"success",
        
        showConfirmButton: true
    },function(isConfirm){

        if (isConfirm){
       
        window.location="{{route('admin.tc.candidates')}}";

        } 
        });
    
        }
    });
        
    });
}
</script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@endsection