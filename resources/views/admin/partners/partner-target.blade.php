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
                                            @foreach ($tp_job as $key=>$item)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                               
                                                <td>{{$item->scheme_id}}</td>
                                                <td>{{$item->sector}}</td>
                                                <td>{{$item->job_role}}</td>
                                                <td>{{$item->target}}</td>
                                                <td>{{$item->target}}</td>
                                                <td>{{$item->target}}</td>
                                                @if($item->status==0)
                                                <td><a class="badge bg-green margin-0" href="{{route('admin.tp.partner.jobrole.active',['id'=>$item->id])}}" >Activate</a></td>
                                                <td><a class="badge bg-grey margin-0" href="#"  >Edit</a></td>
                                                @else
                                                <td><a class="badge bg-red margin-0" href="#" onclick="showCancelMessage({{$item->id}})" >Deactivate</a></td>
                                                <td><a class="badge bg-green margin-0" href='#Modal'{{$item->id}} data-toggle="modal" data-target="#Modal"{{$item->id}}  >Edit</a></td>
                                                @endif
                                             </tr>

                                             {{-- start each Modal edit --}}
                                             <div class="modal fade" id="Modal"{{$item->id}} tabindex="-1" role="dialog">
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
                                                                                <select class="form-control show-tick form-group" id="scheme" name="scheme" onchange="valinst2(this.value);" data-live-search="true" required >
                                                                                    <option value="">Head/Reason :</option>
                                                                                    <option value="Internet">Internet</option>
                                                                                    <option value="Travel Coveyance">Travel Coveyance</option>
                                                                                </select>
                                                                                <span id="e_scheme" class="error text-danger">This Field required</span>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                    <label for="sector">Select Sector</label>
                                                                                    <select class="form-control show-tick form-group" onchange="fetchJobRole(this.value);" id="sector" name="sector" data-live-search="true" required >
                                                                                            <option value="">Sector :</option>
                                                                                            @foreach ($sectors as $sector)
                                                                                                <option value="{{$sector->id}}" {{ ( $sector->id ==$item->sector_id) ? 'selected' : '' }}>{{ $sector->sector }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <span id="e_sector" class="error text-danger">This Field required</span>
                                                                                
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                                    <label for="jobrole">Select Job Role</label>
                                                                                    <select class="form-control show-tick form-group" id="jobrole" name="jobrole" onchange="valinst(this.value);" data-live-search="true" required >
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
                                             {{-- End each Modal edit --}}
                                           
                                            @endforeach

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
                                                                                    <select class="form-control show-tick form-group" id="scheme" name="scheme" onchange="valinst2(this.value);" data-live-search="true" required >
                                                                                        <option value="">Head/Reason :</option>
                                                                                        <option value="Internet">Internet</option>
                                                                                        <option value="Travel Coveyance">Travel Coveyance</option>
                                                                                    </select>
                                                                                    <span id="e_scheme" class="error text-danger">This Field required</span>
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                        <label for="sector">Select Sector</label>
                                                                                        <select class="form-control show-tick form-group" onchange="fetchJobRole(this.value);" id="sector" name="sector" data-live-search="true" required >
                                                                                                <option value="">Sector :</option>
                                                                                                @foreach ($sectors as $sector)
                                                                                                    <option value="{{$sector->id}}">{{ $sector->sector }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            <span id="e_sector" class="error text-danger">This Field required</span>
                                                                                    
                                                                                </div>
                                                                                <div class="col-sm-4">
                                                                                        <label for="jobrole">Select Job Role</label>
                                                                                        <select class="form-control show-tick form-group" id="jobrole" name="jobrole" onchange="valinst(this.value);" data-live-search="true" required >
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
    
    </script>
    <script>
    function fetchJobRole(sector){
            let _token = $("input[name='_token']").val();
            var sector=sector;
            
            $.ajax({
                    url:"{{route('admin.tp.fetch-jobrole')}}",
                    data:{_token,sector},
                    method:'POST',
                    success: function(data){
                     
                     $('#jobrole').empty();
                     $('#jobrole').append('<option value="">Please select</option>');
                     $.each (data.jobroles, function (bb) {
                            var jobrole=data.jobroles[bb].job_role;
                            var jobid=data.jobroles[bb].id;
                            
                            $('#jobrole').append('<option value="'+jobid+'">'+jobrole+'</option>');
                         });
                     $('#jobrole').selectpicker('refresh');
                        }
                     });
                $('#sector2').val(sector);
                // var a=$("#jobrole option:selected").val();
                // 
    
            }
    
    function valinst(f){
        $('#jobrole2').val(f);
    }
    function valinst2(f){
        $('#scheme2').val(f);
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

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
@stop