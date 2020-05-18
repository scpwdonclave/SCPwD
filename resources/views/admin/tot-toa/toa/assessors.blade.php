@extends('layout.master')
@section('title', 'TOA-Assessors')
@section('parentPageTitle', 'TOT-TOA')
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/scpwd-common.css')}}">
@stop
@section('content')

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header d-flex justify-content-between">
                    <h2><strong>All</strong> TOA Records </h2>
                    <div>
                        <button type="button" class="btn btn-primary btn-round waves-effect" data-toggle="modal" data-target="#defaultModal">Link Assessor To AA</button>
                        <a class="btn btn-primary btn-round waves-effect" href="{{route('admin.tot-toa.addassessorcert')}}">Add New TOA</a>
                    </div>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table nobtn table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Assessor Name</th>
                                    <th>AA Name</th>
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
                                @foreach ($toas as $toa)
                                    <tr>
                                        <td>{{$toa->name}}</td>
                                        <td>{{$toa->agency->agency_name}}</td>
                                        <td>{{$toa->doc_no}}</td>
                                        <td>{{$toa->contact}}</td>

                                        <td>{{$toa->batchlatest?(is_null($toa->batchlatest->percentage)?'NA':$toa->batchlatest->percentage.'%'):'NA'}}</td>
                                        <td>{{$toa->batchlatest?(is_null($toa->batchlatest->percentage)?'NA':(is_null($toa->batchlatest->grade)?'Failed':$toa->batchlatest->grade)):'NA'}}</td>
                                        <td>{{$toa->batchlatest?(is_null($toa->batchlatest->validity)?'NA':Carbon\Carbon::parse($toa->batchlatest->validity)->format('d-m-Y')):'NA'}}</td>
                                        <td><button type="button" class="badge bg-green margin-0" onclick="location.href='{{route('admin.tot-toa.assessor.view',Crypt::encrypt($toa->id))}}'" >View</button></td>
                                        @if ($toa->batchlatest && !is_null($toa->batchlatest->grade))
                                            <td><button type="button" class="badge bg-green margin-0" onclick="window.open('{{route('admin.tot-toa.certificate.print',Crypt::encrypt($toa->batchlatest->id.',0,0'))}}');" formtarget="_blank">Print</button></td>
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
                    <h5 class="title" id="defaultModalLabel">Change AA of Existing Assessor</h5>
                </div>
                <div class="modal-body">
                    <form id="form_modal" method="POST" action="#">
                        @csrf
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm-6">
                                <label for="agency">Agencies</label>
                                <select class="form-control show-tick form-group selectpicker" id="agency" name="agency" data-live-search="true" required>
                                    <option value="">None</option>
                                    @foreach ($agencies as $agency)
                                        <option value="{{$agency->id}}">{{$agency->agency_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="assessor">Available Assessors to Switch</label>
                                <select class="form-control show-tick form-group selectpicker" id="assessor" name="assessor" data-live-search="true" required>
                                    <option value="">None</option>
                                    @foreach ($expired as $item)
                                        <option value="{{$item->id}}">{{$item->name.' | '.$item->doc_no.' (AA: '.$item->agency_name.')'}}</option>
                                    @endforeach
                                </select>
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
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
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
                url:'{{route("admin.tot-toa.assessors.linking.submit")}}',
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
</script>
@stop