@extends('layout.master')
@section('title', $data)
@section('parentPageTitle', 'MIS')
@section('content')
<div class="container-fluid file_manager">
    <div class="row clearfix">
        <div class="col-lg-12">
            
            <div class="tab-content">
                <div class="row clearfix">
                    @switch($data)
                        @case('candidates')
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SIPDA_Candidate_wise_Complied_Sheet_16-17.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SIPDA Candidate wise Complied Sheet 16-17</p>
                                                <small>Size: 4.79MB <span class="date text-muted">April 15, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SIPDA_Candidate_wise_Complied_Sheet_17-18.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SIPDA Candidate wise Complied Sheet 17-18</p>
                                                <small>Size: 13.9MB <span class="date text-muted">April 22, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SIPDA_Candidate_wise_Complied_Sheet_18-19.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SIPDA Candidate wise Complied Sheet 18-19</p>
                                                <small>Size: 2.33MB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case('formats')
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SCPwD_Candidate_Data_Format_SIPDA.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SCPwD Candidate Data Format SIPDA</p>
                                                <small>Size: 12.8KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SCPwD_Result_Format_for_MSJE.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SCPwD Result Format for MSJE</p>
                                                <small>Size: 14.5KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SCPwD_Weekly_Assessment_Report_Jul2019_onword.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SCPwD Weekly Assessment Report Jul 2019 onword</p>
                                                <small>Size: 21.6KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SSC_Monthly_Report_Revised_Template.xls'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SSC Monthly Report Revised Template</p>
                                                <small>Size: 243KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'Upcoming_Assessment_Details(_Daily_Update_Req)_26-Jul-19_onword.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">Upcoming Assessment Details( Daily Update Req) 26-Jul-19 onword</p>
                                                <small>Size: 80.7KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case('tot-toa')
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'Assessor_Data_For_Certificates_26-Mar-2020.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">Assessor Data For Certificates 26-Mar-2020</p>
                                                <small>Size: 79.1KB <span class="date text-muted">April 21, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'Assessor_data_OLD_data_25-Mar-20.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">Assessor data OLD data 25-Mar-20</p>
                                                <small>Size: 465KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SCPwD_TOA_Nomination_Format.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SCPwD TOA Nomination Format</p>
                                                <small>Size: 12.2KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SCPwD_TOT-TOA_Data_till_26-Mar-2020.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SCPwD TOT-TOA Data till 26-Mar-2020</p>
                                                <small>Size: 23.1KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'Trainer_Revised_Nomination_Format_15-04-2020.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">Trainer Revised Nomination Format 15-04-2020</p>
                                                <small>Size: 10.3KB <span class="date text-muted">April 15, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'Trainer_Data.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">Trainer Data</p>
                                                <small>Size: 224KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case('trackers')
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'Ali_Yavar_Jung_Tracker_FY_16-17.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">Ali Yavar Jung Tracker FY 16-17</p>
                                                <small>Size: 56.5KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'Batches_Allocation_to_AA_From_1-Apr-19_to_31-Dec-19.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">Batches Allocation to AA From 1-Apr-19 to 31-Dec-19</p>
                                                <small>Size: 39.3KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'National_Institue_Tracker_FY_17-18.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">National Institue Tracker FY 17-18</p>
                                                <small>Size: 231KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'NHFDC_Tracker_CSR_FYI_19-20.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">NHFDC Tracker CSR FYI 19-20</p>
                                                <small>Size: 39.6KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'NHFDC_Tracker_Final_FY_16-17.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">NHFDC Tracker Final FY 16-17</p>
                                                <small>Size: 64.9KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'PMKVY_Training_and_Assessments_Trackers.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">PMKVY Training and Assessments Trackers</p>
                                                <small>Size: 14KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SIPDA_TRACKER_Final_FY_16-17.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SIPDA TRACKER Final FY 16-17</p>
                                                <small>Size: 427KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SIPDA_TRACKER_Final_FY_17-18.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SIPDA TRACKER Final FY 17-18</p>
                                                <small>Size: 0.99MB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="card">
                                    <div class="file">
                                        <a href="javascript:void(0);">
                                            <div class="hover">
                                                <button type="button" onclick="location.href='{{route('admin.mis.old-document-download',[$data,'SIPDA_TRACKER_Final_FY_18-19.xlsx'])}}'" class="btn btn-icon btn-icon-mini btn-round btn-success">
                                                    <i class="zmdi zmdi-download"></i>
                                                </button>
                                            </div>
                                            <div class="icon">
                                                <i class="zmdi zmdi-file-text"></i>
                                            </div>
                                            <div class="file-name">
                                                <p class="m-b-5 text-muted">SIPDA TRACKER Final FY 18-19</p>
                                                <small>Size: 288KB <span class="date text-muted">April 4, 2020</span></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @break
                        @default
                            
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</div>
@stop
