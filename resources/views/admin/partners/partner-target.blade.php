@extends('layout.master')
@section('title', 'Target Partner')
@section('parentPageTitle', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/> --}}
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
                                           
                                                
                                            {{-- =========================== --}}

                                            <div class="modal fade" id="largeModal1" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                                <div class="modal-header">
                                                                        <h4 class="title" id="defaultModalLabel1">Job Role</h4>
                                                                    </div>
                                                            <div class="modal-body">
                                                            <form id="form_validation" method="POST" action="{{route('admin.tp.partner.jobtarget')}}" onsubmit="event.preventDefault();return myFunction()">
                                                                        @csrf
                
                                                                        <input type="hidden" value="{{$partner->tp_id}}" name="tp_id">
                                                                        <input type="hidden" value="{{$partner->id}}" name="tpid">
                                                                        <input type="hidden"  name="scheme2" id="scheme2">
                                                                        <input type="hidden"  name="sector2" id="sector2">
                                                                        <input type="hidden"  name="jobrole2" id="jobrole2">
                                                                        
                
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                        <label for="scheme">Select Scheme</label>    
                                                                                    <select class="form-control show-tick form-group" id="scheme" name="scheme" onchange="valinst2(this.value,1);" data-live-search="true" required >
                                                                                        <option value="">Scheme :</option>
                                                                                        @foreach ($schemes as $scheme)
                                                                                            <option value="{{$scheme->id}}">{{ $scheme->scheme }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <span id="e_scheme" class="error text-danger">This Field required</span>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                        <label for="sector">Select Sector</label>
                                                                                        <select class="form-control show-tick form-group" onchange="fetchJobRole(this.value,1);" id="sector" name="sector" data-live-search="true" required >
                                                                                                <option value="">Sector :</option>
                                                                                                @foreach ($sectors as $sector)
                                                                                                    <option value="{{$sector->id}}">{{ $sector->sector }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            <span id="e_sector" class="error text-danger">This Field required</span>
                                                                                    
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                        <label for="jobrole">Select Job Role</label>
                                                                                        <select class="form-control show-tick form-group" id="jobrole" name="jobrole" onchange="valinst(this.value,1);" data-live-search="true" required >
                                                                                            </select>
                                                                                            <span id="e_jobrole" class="error text-danger">This Field required</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                            <label for="scheme">Enter Target Value</label>    
                                                                                            <div class="form-group form-float">
                                                                                                <input type="number" class="form-control" placeholder="Enter Target Value" name="target" id="target" required>
                                                                                            </div>
                                                                                        <span id="e_target" class="error text-danger">This Field required</span>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                    
                                                                            </form>
                                                                            <button class="btn btn-raised btn-primary btn-round waves-effect" type="submit" form="form_validation" >SUBMIT</button>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                           
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
                    <form id="form_modal" method="POST" action="{{route('admin.tp.partner.jobtarget.update')}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="scheme">Select Scheme</label>    
                                <select class="form-control show-tick form-group" id="scheme" name="scheme" data-live-search="true" required >
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="sector">Select Sector</label>
                                <select class="form-control show-tick form-group" onchange="fetchJobRole(this.value,2);" id="sector" name="sector" data-live-search="true" required >
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
        $(function(){
            $('#e_scheme').hide();
            $('#e_sector').hide();
            $('#e_jobrole').hide();
            $('#e_target').hide();

            $('#e_scheme2').hide();
            $('#e_sector2').hide();
            $('#e_jobrole2').hide();
            $('#e_target2').hide();
        });
        function myFunction(){
            var scheme=$('#scheme').val();
            var sector=$('#sector').val();
            var jobrole=$('#jobrole').val();
            var target=$('#target').val();
            if(scheme==""){
                $('#e_scheme').show();
                return false;
            }else if(sector==""){
                $('#e_sector').show();
                return false;
            }else if(jobrole==""){
                $('#e_jobrole').show();
                return false;
            }else if(target==""){
                $('#e_target').show();
                return false;
            }
            else{
                var form = document.getElementById("form_validation");
                form.submit();
                return true;
            }
        }

        function myFunction2(){
            var scheme=$('#scheme_u').val();
            var sector=$('#sector_u').val();
            var jobrole=$('#jobrole_u').val();
            var target=$('#target_u').val();
            if(scheme==""){
                $('#e_scheme2').show();
                return false;
            }else if(sector==""){
                $('#e_sector2').show();
                return false;
            }else if(jobrole==""){
                $('#e_jobrole2').show();
                return false;
            }else if(target==""){
                $('#e_target2').show();
                return false;
            }
            else{
                var form = document.getElementById("modal_form");
                form.submit();
                return true;
            }
        }
    
    </script>
    <script>
    function fetchJobRole(sector,i){
            let _token = $("input[name='_token']").val();
            var sector=sector;
            
            $.ajax({
                    url:"{{route('admin.tp.fetch-jobrole')}}",
                    data:{_token,sector},
                    method:'POST',
                    success: function(data){
                     if(i==1){
                     $('#jobrole').empty();
                     $('#jobrole').append('<option value="">Please select</option>');
                     $.each (data.jobroles, function (bb) {
                            var jobrole=data.jobroles[bb].job_role;
                            var jobid=data.jobroles[bb].id;
                            
                            $('#jobrole').append('<option value="'+jobid+'">'+jobrole+'</option>');
                         });
                     $('#jobrole').selectpicker('refresh');

                            }else{
                    $('#jobrole_u').empty();
                    $('#jobrole_u').append('<option value="">Please select</option>');
                    $.each (data.jobroles, function (bb) {
                        var jobrole=data.jobroles[bb].job_role;
                        var jobid=data.jobroles[bb].id;
                        
                        $('#jobrole_u').append('<option value="'+jobid+'">'+jobrole+'</option>');
                        });
                    $('#jobrole_u').selectpicker('refresh');   
                            }
                        }
                     });

                    if(i==1){
                $('#sector2').val(sector);
                    }else{
                $('#sector2_u').val(sector);   
                    }
                
                
    
            }
    
    function valinst(f,i1){
        console.log(i1);
        if(i1==1){
        $('#jobrole2').val(f);
        }else{
        $('#jobrole2_u').val(f);

        }
    }
    function valinst2(f,i2){
        console.log(i2);

        if(i2==1){
        $('#scheme2').val(f);
    }else{
        $('#scheme2_u').val(f);

        }
    }
    </script>

    <script>
    function popupMenu(id){
        let _token = $("[name=_token]").val();
        if (id === undefined) {
            data = null;
            $('#defaultModalLabel').html('Add Job Role with Target');
            $('#btnConfirm').html('Add JobRole');
        } else if(id != '') {
            $('#defaultModalLabel').html('Update Job Role & Target');
            $('#btnConfirm').html('Update JobRole');
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

    $(()=>{
        $('#form_modal').validate();
    });

    //* Modal Close Event
    
    $("#defaultModal").on("hidden.bs.modal", function () {
        $("label[class^='error']").each(function() {
            $(this).hide();
        });
        $(this).find('form').trigger('reset');
    });
    
    //* End Modal Close Event
    
    $('#form_modal').on('submit', function(e){
        e.preventDefault();
        console.log(e.currentTarget);
        
    });


   
</script>

<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script> --}}
@stop