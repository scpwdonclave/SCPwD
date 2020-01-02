@extends('layout.master')
@section('title', 'Assesors')
@section('parentPageTitle', 'Agency')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')

<div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header d-flex justify-content-between">
                            <h2><strong>All</strong> Assessor</h2>
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('agency.add-assessor')}}">Add Assessor</a> 
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Assessor ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Batch</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($data as $key=>$item)
                                             @if ($item->status)
                                             <tr>
                                             <td>{{$key+1}}</td>
                                                @if ($item->as_id!=null)
                                                    <td>{{$item->as_id}}</td>
                                                @else
                                                    <td>{{Config::get('constants.nullidtext')}}</td> 
                                                @endif
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->mobile}}</td>
                                                <td class="text-{{$item->verified?'success':'danger'}}"><strong>{{$item->verified?'Verified':'Not Verified'}}</strong></td>
                                                @if ($item->verified)
                                                    <td><a class="badge bg-green margin-0" href="{{route('agency.as.assessor.batch',['id'=>Crypt::encrypt($item->id)])}}" >Batch</a></td>
                                                @else
                                                    <td><a class="badge bg-grey margin-0" href="#" >Batch</a></td>
                                                @endif
                                                <td><a class="badge bg-green margin-0" href="{{route('agency.as.assessor.view',['id'=>Crypt::encrypt($item->id)])}}">View</a></td>
                                             </tr>
                                             @endif   
                                          
                                            @endforeach
                                           
                                        </tbody>
                                </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between">
                        <h2><strong>All</strong> Deactive Assessor </h2>
                       
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Assessor ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Aadhaar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key=>$item)
                                    @if (!$item->status)
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->as_id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->mobile}}</td>
                                    <td>{{$item->aadhaar}}</td>
                                    <td><a class="badge bg-green margin-0" href="{{route('agency.as.assessor.view',['id'=>$item->id])}}" >View</a></td>
                                    {{-- @if($item->status==1)
                                    <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$item->id}})">Deactivate</a></td>
                                    @elseif($item->status==0)
                                    <td><a class="badge bg-green margin-0" href="{{route('admin.aa.agency.active',['id'=>Crypt::encrypt($item->id)])}}" >Activate</a></td>
                                    @endif --}}
                                    </tr>
                                    @endif   
                                 
                                   @endforeach
                                       
                                    </tbody>
                            </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@stop
@section('page-script')
{{-- <script>
function showCancelMessage(f) {
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
        url: "{{route('admin.aa.agency.deactive')}}",
        data: {_token,id,reason},
        success: function(data) {
           // console.log(data);
           swal({
        title: "Deactive",
        text: "Agency Record Deactive",
        type:"success",
        
        showConfirmButton: true
    },function(isConfirm){

        if (isConfirm){
       
        window.location="{{route('admin.agency.agencies')}}";

        } 
        });
    
        }
    });
        
    });
}

</script> --}}
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop