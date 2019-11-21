@extends('layout.master')
@section('title', 'Target Partner')
@section('parentPageTitle', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Target Details</strong> For Partner</h2>
                </div>
                <div class="body">
                    <div class="text-center">
                        <h4 class="margin-0">{{$partner->spoc_name}}</h4>
                        <h6 class="m-b-20">{{$partner->tp_id}}</h6>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" style="float:right;" onclick="popupMenu()">Add Job Role</button>
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Scheme | Sector | Job Role</th>
                                    <th>Target Allocated</th>
                                    <th>Student Enroll</th>
                                    <th>Target Achieve</th>
                                    <th>Scheme Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partner->partner_jobroles as $job)
                                    <tr>
                                        <td>{{$job->scheme->scheme.' | '.$job->sector->sector.' | '.$job->jobrole->job_role}}</td>
                                        <td>{{$job->target}}</td>
                                        <td>{{$job->assigned}}</td>
                                        <td>{{$job->target}}</td>
                                        <td class="text-{{($job->status)?'success':'danger'}}"><strong>{{($job->status)?'Active':'Inactive'}}</strong></td>
                                        @if($job->status)
                                            <td><button type="button" class="badge bg-green margin-0" onclick="popupMenu({{$job->id}})">Edit</button></td>
                                        @else
                                            <td><button type="button" class="badge bg-grey margin-0" onclick="return false">Edit</button></td>
                                        @endif
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
@stop
@section('modal')
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <form id="form_modal" method="POST" action="{{route('admin.tp.target.action')}}">
                        @csrf
                        <input type="hidden" name="jobid">
                        <input type="hidden" name="userid" value="{{$partner->id}}">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="scheme">Select Scheme</label>    
                                <select class="form-control show-tick form-group" id="scheme" name="scheme" data-live-search="true" required >
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="sector">Select Sector</label>
                                <select class="form-control show-tick form-group" onchange="fetchJobRole(this.value);" id="sector" name="sector" data-live-search="true" required >
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="jobrole">Select Job Role</label>
                                <select class="form-control show-tick form-group" id="jobrole" name="jobrole" data-live-search="true" required >
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-6">
                                <label for="target">Enter Target Value</label>    
                                <div class="form-group form-float">
                                    <input type="number" class="form-control" placeholder="Enter Target Value" name="target" id="target" required>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button id="btnConfirm" class="btn btn-raised btn-primary btn-round waves-effect" type="submit" ></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script>

    // * On load Function
    
    $(()=>{
        $('#form_modal').validate();
    });
    
    // * End On load Function


    // Job role Fetch on Sector Change on Modal
    
    function fetchJobRole(sector){
        if(sector != undefined || sector != null || sector != ''){
            let _token = $("[name='_token']").val();
            $.ajax({
                url:"{{route('admin.tp.fetch-jobrole')}}",
                data:{_token,sector},
                method:'POST',
                success: function(data){
                    $('[name=jobrole]').empty();
                    $('[name=jobrole]').append('<option value="">Please select</option>');
                    $.each (data.jobroles, function (index) {
                            $('[name=jobrole]').append('<option value="'+data.jobroles[index].id+'">'+data.jobroles[index].job_role+'</option>');
                        });
                    $('[name=jobrole]').selectpicker('refresh');
                    }
                });
        }
    }

    // End Job role Fetch on Sector Change on Modal
    

    // Call Modal of Adding or Updating Job roles

    function popupMenu(id){
        let _token = $("[name=_token]").val();
        if (id === undefined) {
            data = null;
            $('#defaultModalLabel').html('Add Job Role with Target');
            $('#btnConfirm').html('Add JobRole');
        } else if(id != '') {
            $('#defaultModalLabel').html('Update Job Role & Target');
            $('#btnConfirm').html('Update JobRole');
            $('[name=jobid]').val(id);
            data = id;
        }
        
            $.ajax({
                url:"{{route('admin.tp.fetch-data')}}", 
                data:{_token,data},
                method:'POST',
                success: function(data){
                    
                    $('[name=scheme]').empty();
                    $('[name=sector]').empty();
                    $('[name=jobrole]').empty();
                    
                    $.each (data.schemes, function (index) {
                        var s_id=data.schemes[index].id;
                        var scheme=data.schemes[index].scheme;
                        $('[name=scheme]').append('<option value="'+s_id+'">'+scheme+'</option>');
                    });
                    
                    $.each (data.sectors, function (index) {
                        var id=data.sectors[index].id;
                        var sector=data.sectors[index].sector;
                        $('[name=sector]').append('<option value="'+id+'">'+sector+'</option>');
                    });
                    
                    
                    $.each (data.job, function (index) {
                        var id=data.job[index].id;
                        var job_role=data.job[index].job_role;
                        $('[name=jobrole]').append('<option value="'+id+'">'+job_role+'</option>');
                    });
                    
                    if(id != '' && id !== undefined) {
                        
                        $("[name=scheme]").val(data.data.scheme_id);
                        $("[name=sector]").val(data.data.sector_id);
                        $("[name=jobrole]").val(data.data.jobrole_id);
                        $("[name=target]").val(data.data.target);
                        if (data.data.assigned == 0) {
                            $("[name=target]").attr("min", 1);
                        } else {
                            $("[name=target]").attr("min", data.data.assigned);
                        }
                    }

                    $('[name=scheme]').selectpicker('refresh');
                    $('[name=sector]').selectpicker('refresh');
                    $('[name=jobrole]').selectpicker('refresh');

                },
                error: function(){
                    swal('Attention', 'Something went Wrong, Try Again', 'error').then(function(){location.reload()});
                }
                });
         $("#defaultModal").modal('show');
    }

    // End Call Modal of Adding or Updating Job roles


    //* Modal Close Event
    
    $("#defaultModal").on("hidden.bs.modal", function () {
        $("label[class^='error']").each(function() {
            $(this).hide();
        });
        $(this).find('form').trigger('reset');
    });
    
    //* End Modal Close Event
   
</script>

<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
@stop