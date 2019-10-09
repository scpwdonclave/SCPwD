@extends('layout.master')
@section('title', 'Target Partner')
@section('parentPageTitle', 'Partners')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
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
                                <button class="btn btn-primary btn-sm" style="float:right;" onclick="location.href='#largeModal1'" data-toggle="modal" data-target="#largeModal1">Add Job Role</button>
                                <br><br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                            <tr>
                                            <th>#</th>
                                            
                                            <th>Scheme</th>
                                            <th>Sector</th>
                                            <th>Job Role</th>
                                            <th>Target Allocated</th>
                                            <th>Student Enroll</th>
                                            <th>Target Achieve</th>
                                            <th>Action</th>
                                            <th>Edit</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($partner->partner_jobroles as $key=>$job)
                                            <tr>
                                                <td class="text-center">{{$key+1}}</td>
                                               
                                                <td class="text-center">{{$job->scheme->scheme}}</td>
                                                <td class="text-center">{{$job->sector->sector}}</td>
                                                <td class="text-center">{{$job->jobrole->job_role}}</td>
                                                <td class="text-center">{{$job->target}}</td>
                                                <td class="text-center">{{$job->target}}</td>
                                                <td class="text-center">{{$job->target}}</td>
                                                @if($job->status==1 && $job->scheme_status==1)
                                                <td class="text-center"><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$job->id}})">Deactivate</a></td>
                                                <td class="text-center"><a class="badge bg-green margin-0" href="#" onclick="showEditJobrole({{$job->id}})"  >Edit</a></td>
                                                @elseif($job->scheme_status==0)
                                                <td class="text-center"><a class="badge bg-grey margin-0" href="#" >Activate</a></td>
                                                <td class="text-center"><a class="badge bg-grey margin-0" href="#"  >Edit</a></td>
                                                @elseif($job->status==0)
                                                <td class="text-center"><a class="badge bg-green margin-0" href="{{route('admin.tp.partner.jobrole.active',['id'=>$job->id])}}" >Activate</a></td>
                                                <td class="text-center"><a class="badge bg-grey margin-0" href="#"  >Edit</a></td>
                                                @endif
                                                {{-- @if($job->status)
                                                    <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$job->id}})" >Deactivate</a></td>
                                                    <td><a class="badge bg-green margin-0" href="#" onclick="showEditJobrole({{$job->id}})"  >Edit</a></td>
                                                @else
                                                    <td><a class="badge bg-green margin-0" href="{{route('admin.tp.partner.jobrole.active',['id'=>$job->id])}}" >Activate</a></td>
                                                    <td><a class="badge bg-grey margin-0" href="#"  >Edit</a></td>
                                                @endif --}}
                                             </tr>
                                            @endforeach
                                           
                                                <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                                <div class="modal-header">
                                                                        <h4 class="title" id="defaultModalLabel">Job Role Update</h4>
                                                                    </div>
                                                            <div class="modal-body">
                                                            <form id="form2" method="POST" action="{{route('admin.tp.partner.jobtarget.update')}}" onsubmit="event.preventDefault();return myFunction2()">
                                                                        @csrf
                
                                                                        <input type="hidden" value="{{$partner->id}}" name="tpid2">
                                                                        <input type="hidden"  name="p_job_id" id="p_job_id">
                                                                        <input type="hidden"  name="scheme2_u" id="scheme2_u">
                                                                        <input type="hidden"  name="sector2_u" id="sector2_u">
                                                                        <input type="hidden"  name="jobrole2_u" id="jobrole2_u">
                                                                        
                                                                        
                
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                        <label for="scheme">Select Scheme</label>    
                                                                                    <select class="form-control show-tick form-group" id="scheme_u" name="scheme_u" onchange="valinst2(this.value,2);" data-live-search="true" required >
                                                                                       
                                                                                    </select>
                                                                                    <span id="e_scheme2" class="error text-danger">This Field required</span>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                        <label for="sector">Select Sector</label>
                                                                                        <select class="form-control show-tick form-group" onchange="fetchJobRole(this.value,2);" id="sector_u" name="sector_u" data-live-search="true" required >
                                                                                                
                                                                                            </select>
                                                                                            <span id="e_sector2" class="error text-danger">This Field required</span>
                                                                                    
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                        <label for="jobrole">Select Job Role</label>
                                                                                        <select class="form-control show-tick form-group" id="jobrole_u" name="jobrole_u" onchange="valinst(this.value,2);" data-live-search="true" required >
                                                                                            </select>
                                                                                            <span id="e_jobrole2" class="error text-danger">This Field required</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                            <label for="scheme">Enter Target Value</label>    
                                                                                            <div class="form-group form-float">
                                                                                                <input type="number" class="form-control" placeholder="Enter Target Value" name="target_u" id="target_u">
                                                                                            </div>
                                                                                        <span id="e_target2" class="error text-danger">This Field required</span>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                    
                                                                            </form>
                                                                            <button class="btn btn-raised btn-primary btn-round waves-effect" type="submit" form="form2" >UPDATE</button>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                                <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- =========================== --}}

                                            <div class="modal fade" id="largeModal1" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                                <div class="modal-header">
                                                                        <h4 class="title" id="defaultModalLabel">Job Role</h4>
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
                                                                                                <input type="number" class="form-control" placeholder="Enter Target Value" name="target" id="target">
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
                var form = document.getElementById("form2");
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
            function showCancelMessage(f,i) {
                let _token = $("input[name='_token']").val();
                var id=f;
                swal({
                    title: "Are you sure?",
                    text: "Job Role will not be able to Access!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No, cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "{{route('admin.tp.partner.jobrole.deactive')}}",
                            data:{_token,id},
                            success: function(data) {
                               
                               swal({
                            title: "Done",
                            text: "Job Role Deactivated",
                            type:"success",
                            
                            showConfirmButton: true
                        },function(isConfirm){
                    
                            if (isConfirm){
                           
                            window.location="{{route('admin.tp.partners')}}";
                    
                            } 
                            });
                        
                            }
                        });
                       
                    } else {
                        swal("Cancelled", "Your Job Role is safe :)", "error");
                    }
                });
            }
            </script>
    <script>
    function showEditJobrole(e_id){
        console.log(e_id);
        let _token = $("input[name='_token']").val();
            var e_id=e_id;
            
            $.ajax({
                    url:"{{route('admin.tp.fetch-prvdata')}}",
                    data:{_token,e_id},
                    method:'POST',
                    success: function(data){
                     
                    //  $('#jobrole_u').empty();
                    //  $('#jobrole_u').append('<option value="">Please select</option>');
                    //  $.each (data.jobroles, function (bb) {
                    //         var jobrole=data.jobroles[bb].job_role;
                    //         var jobid=data.jobroles[bb].id;
                            
                    //         $('#jobrole').append('<option value="'+jobid+'">'+jobrole+'</option>');
                    //      });
                    $('#sector_u').empty();
                    $('#scheme_u').empty();
                    $('#jobrole_u').empty();

                    $.each (data.sectors, function (index) {
                    var id=data.sectors[index].id;
                    var sector=data.sectors[index].sector;
                    
                    $('#sector_u').append('<option value="'+id+'">'+sector+'</option>');
                    });
                    $("#sector_u").val(data.data.sector_id);
                    $('#sector_u').selectpicker('refresh');
                    
                    $.each (data.schemes, function (index) {
                    var s_id=data.schemes[index].id;
                    var scheme=data.schemes[index].scheme;
                    
                    $('#scheme_u').append('<option value="'+s_id+'">'+scheme+'</option>');
                    });
                    $("#scheme_u").val(data.data.scheme_id);
                    $('#scheme_u').selectpicker('refresh');

                    $.each (data.job, function (index) {
                    var id=data.job[index].id;
                    var job_role=data.job[index].job_role;
                    
                    $('#jobrole_u').append('<option value="'+id+'">'+job_role+'</option>');
                    });
                    $("#jobrole_u").val(data.data.jobrole_id);
                    $('#jobrole_u').selectpicker('refresh');

                    $("#target_u").val(data.data.target);
                    
                   
                    $("#p_job_id").val(data.data.id);
                    $("#scheme2_u").val(data.data.scheme_id);
                    $("#sector2_u").val(data.data.sector_id);
                    $("#jobrole2_u").val(data.data.jobrole_id);
                    $("#target2_u").val(data.data.target);


                        }
                     });
         $("#defaultModal").modal('show');
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