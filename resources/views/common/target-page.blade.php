@extends('layout.master')
@section('title', (Request::segment(1)==='admin')?'Target Partner':'Target Center')
@section('parentPageTitle', (Request::segment(1)==='admin')?'Partners':'Center')
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
                    <h2><strong>Target Details</strong> For {{(Request::segment(1)==='admin')?'Partner':'Center'}}</h2>
                </div>
                <div class="body">
                    <div class="text-center">
                        <h4 class="margin-0">{{(Request::segment(1)==='admin')?$partner->spoc_name:$center->spoc_name}}</h4>
                        <h6 class="m-b-20" style="color:blue">{{(Request::segment(1)==='admin')?$partner->tp_id:$center->tc_id}}</h6>
                    </div>
                    @if ( request()->segment(1)==='admin')
                        @if (!auth()->guard('admin')->user()->ministry)
                            <button type="button" class="btn btn-primary btn-sm" style="float:right;" onclick="popupMenu()">Add Job Role</button>
                        @endif
                    @else                
                        <button type="button" class="btn btn-primary btn-sm" style="float:right;" onclick="popupMenu()">Add Job Role</button>
                    @endif
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th class="text-center">Scheme | Sector | Job Role</th>
                                    <th>Allocated</th>
                                    @if (Request::segment(1)==='admin')
                                        <th>Distributed</th>
                                    @endif
                                    <th>Enrolled</th>
                                    <th>Achieved</th>
                                    <th>Scheme Status</th>
                                    @if ( request()->segment(1)==='admin' )
                                        @if (!auth()->guard('admin')->user()->ministry)
                                            <th>Edit</th>
                                        @endif
                                    @else
                                        <th>Target</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if (Request::segment(1)==='admin')
                                    @foreach ($partner->partner_jobroles as $job)
                                        <tr>
                                            <td>{{$job->scheme->scheme.' | '.$job->sector->sector.' | '.$job->jobrole->job_role}}</td>
                                            <td>{{$job->target}}</td>
                                            <td>{{$job->assigned}}</td>
                                            @php
                                                $passed=0;
                                                $count = 0;
                                                foreach ($job->centerjobroles as $centerJob) {
                                                    $count += $centerJob->candidates->count();
                                                    
                                                    foreach ($centerJob->candidates as $ccd) {
                                                        if ($ccd->passed == 1) {
                                                        $passed+=1;  
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <td>{{$count}}</td>
                                            <td>{{$passed}}</td>
                                            <td class="text-{{($job->status)?'success':'danger'}}"><strong>{{($job->status)?'Active':'Inactive'}}</strong></td>
                                            @if ( request()->segment(1)==='admin' )
                                                @if (!auth()->guard('admin')->user()->ministry)
                                                    @if($job->status)
                                                        <td><button type="button" class="badge bg-green margin-0" onclick="popupMenu({{$job->id}})">Edit</button></td>
                                                    @else
                                                        <td><button type="button" class="badge bg-grey margin-0" onclick="return false">Edit</button></td>
                                                    @endif
                                                @endif
                                            @else
                                                @if($job->status)
                                                    <td><button type="button" class="badge bg-green margin-0" onclick="popupMenu({{$job->id}})">Increase</button></td>
                                                @else
                                                    <td><button type="button" class="badge bg-grey margin-0" onclick="return false">Increase</button></td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($center->center_jobroles as $job)
                                        <tr>
                                            <td>{{$job->partnerjobrole->scheme->scheme.' | '.$job->partnerjobrole->sector->sector.' | '.$job->partnerjobrole->jobrole->job_role}}</td>
                                            <td>{{$job->target}}</td>
                                            <td>{{$job->candidates->count()}}</td>
                                            @php
                                                $passed=0;
                                                foreach ($job->candidates as $ccd) {
                                                    if ($ccd->passed == 1) {
                                                      $passed+=1;  
                                                    }
                                                }
                                            @endphp
                                            <td>{{$passed}}</td>
                                            <td class="text-{{($job->status)?'success':'danger'}}"><strong>{{($job->status)?'Active':'Inactive'}}</strong></td>
                                            @if ( request()->segment(1)==='admin' )
                                                @if (!auth()->guard('admin')->user()->ministry)
                                                    @if($job->status)
                                                    <td><button type="button" class="badge bg-green margin-0" onclick="popupMenu({{$job->id}})">Edit</button></td>
                                                @else
                                                    <td><button type="button" class="badge bg-grey margin-0" onclick="return false">Edit</button></td>
                                                @endif
                                                @endif
                                            @else
                                                @if($job->status)
                                                    <td><button type="button" class="badge bg-green margin-0" onclick="popupMenu({{$job->id}})">Increase</button></td>
                                                @else
                                                    <td><button type="button" class="badge bg-grey margin-0" onclick="return false">Increase</button></td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="title" id="defaultModalLabel"></h4>
                </div>
                <div class="modal-body">
                    @php
                        $url = Request::segment(1)==='admin'?'admin.tp.target.action':'partner.tc.target.action';
                    @endphp
                    <form id="form_modal" method="POST" action="{{route($url)}}">
                        @csrf
                        @if (Request::segment(1)==='admin')
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
                        @else
                            <input type="hidden" name="jobid">
                            <input type="hidden" name="userid" value="{{$center->id}}">
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-10">
                                    <label for="jobrole">Select Job Role</label>    
                                    <select class="form-control show-tick form-group" id="jobrole" name="jobrole" onchange="jobchanged()" data-live-search="true" required >
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
                        @endif
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

@if (Request::segment(1)==='admin')
<script>
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
</script>
@endif


<script>

    // * On load Function
    
    $(()=>{
        $('#form_modal').validate();
    });
    
    // * End On load Function
    

    // Call Modal of Adding or Updating Job roles

    function popupMenu(id){
        var user = '{{Request::segment(1)}}';
        var url = '';
        var text = '';
        if (user==='admin') {
            url = "{{route('admin.tp.fetch-data')}}";
            text = "Update";
        } else {
            url = "{{route('partner.tp.fetch-data')}}";
            text = "Increase";
        }
        let _token = $("[name=_token]").val();
        if (id === undefined) {
            data = null;
            $('#defaultModalLabel').html('Add Job Role with Target');
            $('#btnConfirm').html('Add JobRole');
        } else if(id != '') {
            $('#defaultModalLabel').html('Update Job Role & Target');

            $('#btnConfirm').html(text+' JobRole');
            $('[name=jobid]').val(id);
            data = id;
        }
        
            $.ajax({
                url:url, 
                data:{_token,data},
                method:'POST',
                success: function(data){
                    
                    if (user==='admin') {
                        $('[name=scheme]').empty();
                        $('[name=sector]').empty();
                        $('[name=jobrole]').empty();
                    } else {
                        $('[name=jobrole]').empty();                            
                    }
                    
                    
                    if (user==='admin') {
                        $.each (data.schemes, function (index) {
                            let s_id=data.schemes[index].id;
                            let scheme=data.schemes[index].scheme;
                            $('[name=scheme]').append('<option value="'+s_id+'">'+scheme+'</option>');
                        });
                        $.each (data.sectors, function (index) {
                            let id=data.sectors[index].id;
                            let sector=data.sectors[index].sector;
                            $('[name=sector]').append('<option value="'+id+'">'+sector+'</option>');
                        });
                        
                        
                        $.each (data.job, function (index) {
                            let id=data.job[index].id;
                            let job_role=data.job[index].job_role;
                            $('[name=jobrole]').append('<option value="'+id+'">'+job_role+'</option>');
                        });
                    } else {
                        if (id === undefined) {
                            $.each (data.schemedata, function (index) {
                                let s_id=data.id[index];
                                let jobrole=data.schemedata[index];
                                $('[name=jobrole]').append('<option value="'+s_id+'">'+jobrole+'</option>');
                            });
                            jobchanged();
                        } else {
                            // let job = $("[name=jobrole]").val();
                            // let jobdata = job.split(',');
                            $('[name=jobrole]').append('<option value="'+data.data.id+'">'+data.data.jobdata+'</option>');
                            $("[name=target]").attr("max", Number(data.data.partnerjobrole.target)-Number(data.data.partnerjobrole.assigned));
                            $("[name=target]").attr("min", 1);

                            // if (data.data.enrolled == 0) {
                            //     $("[name=target]").attr("min", 1);
                            // } else {
                            //     $("[name=target]").attr("min", data.data.enrolled);
                            // }
                        }
                    }
                    
                    if(id != '' && id !== undefined) {
                        
                        if (user==='admin') {
                            $("[name=scheme]").val(data.data.scheme_id);
                            $("[name=sector]").val(data.data.sector_id);
                            $("[name=target]").val(data.data.target);
                            if (data.data.assigned == 0) {
                                $("[name=target]").attr("min", 1);
                            } else {
                                $("[name=target]").attr("min", data.data.assigned);
                            }
                        }
                    }

                    $('[name=jobrole]').selectpicker('refresh');
                    if (user==='admin') {
                        $('[name=scheme]').selectpicker('refresh');
                        $('[name=sector]').selectpicker('refresh');
                    }

                },
                error: function(){
                    swal('Attention', 'Something went Wrong, Try Again', 'error').then(function(){location.reload()});
                }
            });
        $("#defaultModal").modal('show');
    }

    // End Call Modal of Adding or Updating Job roles


    function jobchanged(){
        let job = $("[name=jobrole]").val();
        let jobdata = job.split(',');        
        $("[name=target]").attr("max", jobdata[1]);
        $("[name=target]").attr("min", 1);
    }


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