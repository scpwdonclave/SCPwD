@extends('layout.master')
@section('title', 'TOT-Trainers')
@section('parentPageTitle', 'TOT-TOA')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>All</strong> TOT Records </h2>
                    <span>
                        <button type="button" class="btn btn-primary btn-round waves-effect" data-toggle="modal" data-target="#defaultModal">Link Trainer To TP</button>
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('admin.tot-toa.addtrainercert')}}">Add New TOT</a>
                    </span>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Trainer Name</th>
                                    <th>TP Name</th>
                                    <th>Doc No</th>
                                    <th>Contact</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Expiry</th>
                                    <th>View</th>
                                    <th>Certificate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tots as $tot)
                                    <tr>
                                        <td>{{$tot->name}}</td>
                                        <td>{{$tot->tp_name}}</td>
                                        <td>{{$tot->doc_no}}</td>
                                        <td>{{$tot->contact}}</td>
                                        <td>{{$tot->batchlatest?(is_null($tot->batchlatest->percentage)?'NA':$tot->batchlatest->percentage.'%'):'NA'}}</td>
                                        <td>{{$tot->batchlatest?(is_null($tot->batchlatest->percentage)?'NA':(is_null($tot->batchlatest->grade)?'Failed':$tot->batchlatest->grade)):'NA'}}</td>
                                        <td>{{$tot->batchlatest?(is_null($tot->batchlatest->validity)?'NA':Carbon\Carbon::parse($tot->batchlatest->validity)->format('d-m-Y')):'NA'}}</td>
                                        <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tot-toa.trainer.view',Crypt::encrypt($tot->id))}}'" >View</button></td>
                                        @if ($tot->batchlatest && !is_null($tot->batchlatest->grade))
                                            <td><button type="button" class="badge bg-green margin-0" onclick="window.open('{{route('admin.tot-toa.certificate.print',Crypt::encrypt($tot->batchlatest->id.',0'))}}');" formtarget="_blank">Print</button></td>
                                        @else
                                            <td>NA</td>
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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="title" id="defaultModalLabel">Switch Trainer Type OR Change TP of Existing Trainer</h5>
                </div>
                <div class="modal-body">
                    <form id="form_modal" method="POST" action="#">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-8">
                                <label for="trainer">Available Trainers to Switch</label>
                                <select class="form-control show-tick form-group selectpicker" id="trainer" name="trainer" data-live-search="true" required>
                                    <option value="">None</option>
                                    @foreach ($expired as $item)
                                        <option value="{{$item->id.','.$item->trainer_category}}">{{$item->name.' | '.$item->doc_no.' (TP: '.$item->tp_name.')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-6">
                                <label for="tp_name">TP Name <span style="color:red" class="toggle_category"> <strong>*</strong></span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="TP Name" name="tp_name" autoComplete="off" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="trainer_type">Trainer Type</label>
                                <select class="form-control show-tick form-group selectpicker" id="trainer_type" name="trainer_type" required>
                                    <option value="">None</option>
                                    <option value="1">Master Trainer</option>
                                    <option value="0">Trainer</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 toggle" style="display: none">
                                <label for="scheme">Scheme <span style="color:red"> <strong>*</strong></span></label>
                                <select class="form-control show-tick form-group selectpicker" id="scheme" name="scheme" required>
                                    <option value="">None</option>
                                    @foreach ($schemes as $scheme)
                                        <option value="{{$scheme->scheme}}">{{$scheme->scheme}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 toggle" style="display: none">
                                <label for="tc_name">TC Name <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="TC Name" name="tc_name" autoComplete="off" required>
                                </div>
                            </div> 
                            <div class="col-sm-4 toggle" style="display: none">
                                <label for="sip_tcid">SIP TC ID <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="SIP TC ID" name="sip_tcid" autoComplete="off" required>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-8 toggle" style="display: none">
                                <label for="tc_location">TC Location <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="TC Location" name="tc_location" autoComplete="off" required>
                                </div>
                            </div> 
                            <div class="col-sm-4 toggle" style="display: none">
                                <label for="domain_cert_no">Domain SSC Certificate No </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Domain SSC Certificate No" name="domain_cert_no" autoComplete="off">
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-4 toggle" style="display: none">
                                <label for="is_insprcted">Physical Inspection Details <span style="color:red"> <strong>*</strong></span></label>
                                <select class="form-control show-tick form-group selectpicker" id="is_insprcted" name="is_insprcted" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="col-sm-4 toggle" style="display: none">
                                <label for="job_role">Domain JobRole <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Domain JobRole" name="job_role" autoComplete="off" required>
                                </div>
                            </div> 
                            <div class="col-sm-4 toggle" style="display: none">
                                <label for="job_role_code">Domain JobRole Code <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Domain JobRole Code" name="job_role_code" autoComplete="off" required>
                                </div>
                            </div> 
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button id="btnSubmit" class="btn btn-raised btn-primary btn-round waves-effect" type="submit" >Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>

<script>

    $('#form_modal').validate();

    $('#form_modal').on('submit', (e)=>{
        e.preventDefault();
        let form = $('#form_modal');    
        let swalText = document.createElement("div");
        
        if (form.valid()) {
            $('#btnSubmit').text('Please wait..');
            $('#btnSubmit').prop('disabled', true);
            $.ajax({
                url:'{{route("admin.tot-toa.trainers.linking.submit")}}',
                method:'POST',
                data: form.serialize(),
                success: function(data){
                    if (data.success) {
                        swalText.innerHTML = data.message; 
                        swal({title:'Attention', content: swalText, icon: 'success', buttons: false, timer: 4000}).then(()=>{location.reload()});
                    } else {
                        $('#btnSubmit').text('Submit');
                        $('#btnSubmit').prop('disabled', false);
                        swalText.innerHTML = data.message; 
                        swal({title:'Attention', content: swalText, icon: 'error', buttons: false, timer: 4000});
                    }
                },
                error: function(){
                    swalText.innerHTML = 'Something Went Wrong, Please Try Again'; 
                    swal({title:'Oops', content: swalText, icon: 'error', buttons: false, timer: 4000}).then(()=>{location.reload()});
                }
            })
        }
        
    })

    $('#trainer_type').on('change', ()=>{
        let tariner_data = $('#trainer').val().split(',');
        if($('#trainer_type').val() == '1'){
            $('.toggle_category').hide();
            $('[name=tp_name]').prop('required', false);
            $('.toggle').slideUp();
        } else if ($("#trainer_type").val() == '0') {
            if (tariner_data[1] == '1') {
                $('.toggle').slideDown();
            }
            $('.toggle_category').show();
            $('[name=tp_name]').prop('required', true);
        }
    })

    $('#trainer').on('change', (e)=>{
        let data = e.currentTarget.value.split(',');
        let select = (data[1] == 1) ? '1' : '0';
        $("#trainer_type > [value='"+select+"']").prop('selected', true);
        $("#trainer_type > [value='']").remove();
        $("#trainer > [value='']").remove();
        
        if (select == '1') {
            $('.toggle_category').hide();
            $('[name=tp_name]').prop('required', false);
        } else {
            $('.toggle_category').show();
            $('[name=tp_name]').prop('required', true);
        }
        $(".selectpicker").selectpicker('refresh');
        $('.toggle').slideUp();
    });

</script>

@stop