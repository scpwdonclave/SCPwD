@extends('layout.master')
@section('title', 'Candidate Re-Assessment Marks')
@section('parentPageTitle', 'Assessor')
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
                    <div class="header d-flex justify-content-between">
                        <h2><strong>Add</strong> Candidate Re-Assessment Marks </h2>
                    </div>
                    <div class="text-center">
                    <h6><strong>Batch ID: <span style="color:blue">{{$reassessment->batch->batch_id}}</span></strong></h6>
                    </div>
                    <div class="body">
                    <form id="form_candidate_mark" method="POST" action="{{route('assessor.as.batch.candidate-re-mark-insert')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="reassid" value="{{$reassessment->id}}">
                        <input type="hidden" name="bt_id" value="{{$reassessment->bt_id}}">

                        <div class="table-responsive">
                            <table class="table nobtn table-bordered ">
                                <thead>
                                    <tr>
                                        <th>Candidate Name</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Attendence</th>
                                        <th>Mark</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                        @php
                                            $i=0;
                                        @endphp
                                    @foreach ($reassessment->candidates as $reass_candidate)
                                        @if ($reass_candidate->appear && $reass_candidate->centercandidate->dropout===0 && $reass_candidate->centercandidate->candidate->status===1)
                                        @php
                                        $i++;    
                                        @endphp    
                                        <tr>
                                                <td>
                                                    {{$reass_candidate->centercandidate->candidate->name}}
                                                    <input type="hidden" name="candidate_id[]" value="{{$reass_candidate->centercandidate->id}}"> 
                                                    <input type="hidden" name="reass_candidate_id[]" value="{{$reass_candidate->id}}"> 
                                                </td>
                                                <td>{{$reass_candidate->centercandidate->candidate->dob}}</td>
                                                <td>{{$reass_candidate->centercandidate->candidate->gender}}</td>
                                                <td>
                                                    <select class="col-sm-12 form-control show-tick" name="attendence[]" onchange="markDisable(this.value,{{$i}})">
                                                        <option value="present" >Present</option>
                                                        <option value="absent" >Absent</option>
                                                    </select>
                                                </td>
                                                <td style="width:10px;"><input class="text-center" type="number" size='30' style="height:30px;border:none" name="mark[]" id="mark{{$i}}" onchange="passFail(this.value,{{$i}})" /></td>
                                                <td>
                                                    <strong>
                                                        <p  id="remark{{$i}}"></p>
                                                        <input type="hidden" name="remark{{$i}}">
                                                    </strong>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br><br>
                        
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm-4">
                                <label>Attendence Sheet <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input id="attendence_doc" type="file" class="form-control" name="attendence_doc" required>
                                    <span id="attendence_doc_error" style="color:red;"></span>                                                            
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>Mark sheet <span style="color:red"> <strong>*</strong></span></label>
                                <div class="form-group form-float">
                                    <input id="marksheet_doc" type="file" class="form-control" name="marksheet_doc" required>
                                    <span id="marksheet_doc_error" style="color:red;"></span>                                                            
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="submit" id="submit_form" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-right"></span> SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script>
    $(function(){
         /* Start File Type Validation */         
         
            var _URL = window.URL || window.webkitURL;
            $("[type='file']").change(function(e) {
                var image, file;
                for (var i = this.files.length - 1; i >= 0; i--) {
                    if ((file = this.files[i])) {
                        size = Math.round((file.size/1024/1024) * 100) / 100; // Size in MB
                        image = new Image();
                        var fileType = file["type"];
                        
                        if(e.currentTarget.id==='marksheet_doc'){
                            var ValidImageTypes = ["application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
                            var txt_msg="File has to be in Excel Format";
                        }else if(e.currentTarget.id==='attendence_doc'){
                            var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf", "application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.wordprocessingml.document"];
                            var txt_msg='File has to be in jpg, jpeg, png ,pdf or Excel Format';
                        }

                        if ($.inArray(fileType, ValidImageTypes) < 0) {
                            $("#"+e.currentTarget.id).val('');
                            $("#" + e.currentTarget.id + "_error").text(txt_msg);
                        } else {
                            $("#" + e.currentTarget.id + "_error").text('');
                        }
                        image.onload = function() {
                            if (size > 5) {
                                $("#"+e.currentTarget.id).val('');
                                $("#" + e.currentTarget.id + "_error").text('File Size is Exceeding the limit of 5 MB');
                            } else {
                                $("#" + e.currentTarget.id + "_error").text('');
                            }
                        };
                        image.src = _URL.createObjectURL(file);
                    }
                }
            });
         
         /* End File Type Validation */
 
     });

    function markDisable(val,id) {
    if(val==='absent'){
            $('#mark'+id).attr('readonly',true);
            //$('#mark'+id).val('');
            $('#mark'+id).val(0);
            $('#remark'+id).addClass('text-success').html('Recorded'); //Absent
            //$('#remark'+id).removeClass().html('');
            $('[name=remark'+id+']').val(0);

        }else{
            $('#mark'+id).attr('readonly',false);
            $('#remark'+id).removeClass().html('');


        }
    }

    function passFail(m,m_id){
        var full_mark='{{$reassessment->batch->jobrole->full_marks}}';
        var pass_mark='{{$reassessment->batch->jobrole->pass_marks}}';
    if (m > Number(full_mark) || m < 0){
        alert("No numbers above "+full_mark+" and Below 0");
        $('#mark'+m_id).val('');
        $('#remark'+m_id).removeClass().html('');
        $('[name=remark'+m_id+']').val('');

        return false;
        }
        

    if(m < Number(pass_mark) && m!='' ){
        $('#remark'+m_id).addClass('text-success').html('Recorded'); //failed
        $('[name=remark'+m_id+']').val(0);
        
    }else if(m >= Number(pass_mark)){
        $('#remark'+m_id).removeClass().html('');
        $('#remark'+m_id).addClass('text-success').html('Recorded'); //passed
        $('[name=remark'+m_id+']').val(1);
        }else{
        $('#remark'+m_id).removeClass().html('');
        $('[name=remark'+m_id+']').val('');


        }
    }
</script>

<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/js/scpwd-common.js')}}"></script>

@stop