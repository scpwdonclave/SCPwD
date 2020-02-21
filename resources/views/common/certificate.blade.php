<html>
<title>{{isset($assessment)?$assessment->batch->batch_id:$batch->batch_id}}</title>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">        
<style type="text/css">
 
span.cls_002{font-family:Times,serif;font-size:16px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_002{font-family:Times,serif;font-size:16px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_003{font-family:Times,serif;font-size:16px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_003{font-family:Times,serif;font-size:16px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_004{font-family:Times,serif;font-size:24px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Times,serif;font-size:24px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Times,serif;font-size:60px;color:rgb(255,153,51);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_005{font-family:Times,serif;font-size:60px;color:rgb(255,153,51);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_006{font-family:Times,serif;font-size:25px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_006{font-family:Times,serif;font-size:25px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_007{font-family:Times,serif;font-size:25px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_007{font-family:Times,serif;font-size:25px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_008{font-family:Times,serif;font-size:20px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_008{font-family:Times,serif;font-size:20px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_009{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_009{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none} 

</style>

</head>
<body >

    @php
        $data = isset($assessment)?$assessment->candidateMarks:$batch->candidatesmap;
    @endphp

    @foreach ($data as $item)

        @php
            $flag = isset($assessment)?$item->passed:!is_null($item->centercandidate->certi_no);
        @endphp

        @if($flag)

            <div style="height:1000px;width:1500px;position:relative">
                <img src="{{asset('assets/images/certi.png')}}" style="height:1000px;width:1500px;">
                <div style="position:absolute;left:138px;top:125px;height:30px"  class="cls_002"><span class="cls_002">Certificate No: </span><span class="cls_003">{{isset($assessment)?$item->centerCandidate->certi_no:$item->centercandidate->certi_no}}</span></div>
                <div style="position:absolute;left:138px;top:160px;height:100px;">    
                    <img src="{{asset('storage/'.(isset($assessment)?$assessment->batch->scheme->logo:$batch->scheme->logo))}}" style="width:180px;">
                </div>

                <div style="position:absolute;left:385px;top:330px" class="cls_004"><span class="cls_004">Department of Empowerment of Persons with Disabilities (Divyangjan)</span></div>
                <div style="position:absolute;left:510px;top:360px" class="cls_004"><span class="cls_004">Ministry of Social Justice and Empowerment</span></div>
                <div style="position:absolute;left:625px;top:390px" class="cls_005"><span class="cls_005">Certificate</span></div>

                <div style="height:250px;width:1000px;position:absolute;left:290px;top:470px;" class="cls_006">
                    <span class="cls_006">This is to certify that </span>
                    @if ((isset($assessment)?$item->centerCandidate->candidate->gender:$item->centercandidate->candidate->gender)=='Male')
                        <span class="cls_007">Mr. {{isset($assessment)?$item->centerCandidate->candidate->name:$item->centercandidate->candidate->name}}</span>
                        @if ((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Father')
                            <span class="cls_006"> Son of</span>
                            <span class="cls_007"> Mr. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @elseif((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Mother')
                            <span class="cls_006"> Son of</span>
                            <span class="cls_007"> Ms. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @elseif((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Wife')
                            <span class="cls_006"> Husband of</span>
                            <span class="cls_007"> Ms. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @elseif((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Uncle')
                            <span class="cls_006"> Nephew of</span>
                            <span class="cls_007"> Mr. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @endif
                    @elseif((isset($assessment)?$item->centerCandidate->candidate->gender:$item->centercandidate->candidate->gender)=='Female') 
                        <span class="cls_007">Ms. {{isset($assessment)?$item->centerCandidate->candidate->name:$item->centercandidate->candidate->name}}</span>
                        @if ((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Father')
                            <span class="cls_006"> Daughter of</span>
                            <span class="cls_007"> Mr. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @elseif((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Mother')
                            <span class="cls_006"> Daughter of</span>
                            <span class="cls_007"> Ms. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @elseif((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Husband')
                            <span class="cls_006"> Wife of</span>
                            <span class="cls_007"> Mr. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @elseif((isset($assessment)?$item->centerCandidate->g_type:$item->centercandidate->g_type)=='Uncle')
                            <span class="cls_006"> Niece of</span>
                            <span class="cls_007"> Mr. {{isset($assessment)?$item->centerCandidate->g_name:$item->centercandidate->g_name}}</span>
                        @endif
                    @endif
                    @if (strlen((isset($assessment)?$item->centerCandidate->candidate->doc_no:$item->centercandidate->candidate->doc_no))==12)
                        <span class="cls_006">Aadhaar No. </span>
                        <span class="cls_007">******{{substr((isset($assessment)?$item->centerCandidate->candidate->doc_no:$item->centercandidate->candidate->doc_no),-6)}}</span>
                    @else
                        <span class="cls_006">Voter No. </span>
                        <span class="cls_007">*****{{substr((isset($assessment)?$item->centerCandidate->candidate->doc_no:$item->centercandidate->candidate->doc_no),-5)}}</span>  
                    @endif
                    <span class="cls_006">has successfully completed the course of</span>
                    <span class="cls_007"> {{isset($assessment)?$assessment->batch->jobrole->job_role:$batch->jobrole->job_role}}  (QP No.  {{isset($assessment)?$assessment->batch->jobrole->qp_code:$batch->jobrole->qp_code}}) </span>
                    <span class="cls_006">conforming to National Skill Qualifications Framework - Level </span><span class="cls_007">{{isset($assessment)?$assessment->batch->jobrole->nsqf_level:$batch->jobrole->nsqf_level}}</span>
                    <span class="cls_006">through</span>
                    <span class="cls_007"> {{isset($assessment)?$assessment->batch->center->center_name:$batch->center->center_name}}, {{isset($assessment)?$assessment->batch->center->city:$batch->center->city}} </span>
                    <span class="cls_006">in the month of</span>
                    @php
                        $assessment_certi_issued_on = isset($assessment)?$item->centerCandidate->assessment_certi_issued_on:$item->centercandidate->assessment_certi_issued_on;
                        $ass_cert_date = explode(',',$assessment_certi_issued_on);
                    @endphp
                    <span class="cls_007">{{Carbon\Carbon::parse($ass_cert_date[0])->format('M Y')}}. </span>
                </div>
                <div style="position:absolute;left:138px;top:770px" class="cls_008">
                    <span class="cls_008">(Dr. Niharika Nigam tanuj)</span><br>
                    <span class="cls_008">Head- Standards and Quality Assurance</span><br>
                    <span class="cls_008" style="font-weight:normal;">Skill Council for Persons with Disability</span>
                </div>
                <div style="position:absolute;top:630px;left:1100px">
                    {!! QrCode::size(230)->generate(route('assessment-qrdata',['id'=>$item->id])); !!}     
                </div>
                <div style="position:absolute;top:840px;left:1100px">
                    <span class="cls_008" style="font-weight:normal;">Month/Year of Issue - {{Carbon\Carbon::parse($ass_cert_date[1])->format('M/Y')}}</span>    
                </div>
            </div>
        @endif
    @endforeach
</body>
</html>
