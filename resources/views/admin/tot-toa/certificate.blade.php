<html>
<title>{{($tag)?$data->bt_tot_id:$data->bt_toa_id}}</title>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">        
    <style type="text/css">
        html { 
            background: url("{{asset('assets/images/certificate/toa-tot.jpg')}}") no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            height:1000px;
            width:1500px;
        }
        div.text {
            padding-top: 395px;    
            text-align: center;
            font-size:28px;
            letter-spacing: 1.5px;
            font-family: "Times New Roman", Times, serif;
            font-weight:normal;
            font-style:normal;
            text-decoration: none;
            line-height: 1.6;
        }
        div.dates_tr {
            padding-top: 166px;
        } 
        div.dates_mtr {
            padding-top: 212px;
        } 
        div.dates{
            /* 166 / 212 */
            font-size:20px;
            padding-left: 195px;
            font-family: "Times New Roman", Times, serif;
            font-weight:bold;
            font-style:normal;
            text-decoration: none;
        }
        span.valid {
            margin-left: -38px;
        }
        .exclude{
            letter-spacing: 0px;
        }
        .qr_section{
            /* text-align: end; */
            margin-left: 1200px;
            padding-right: 70px;
            margin-top: -373px;
            vertical-align:top;
        }
        span.qrid {
            margin-left: 50px;
            margin-top: -30px;
            font-size:20px;
            font-family: "Times New Roman", Times, serif;
            font-weight:bold;
            font-style:normal;
            text-decoration: none;
        }
    </style>
</head>
<body >
    <div class="text">
        This is to certify that
        <br>
        @if ($tag)
            <strong class="exclude">{{$data->trainer->salutation.' '.$data->trainer->name}} </strong>({{$data->trainer->doc_type?'Aadhaar':'Voter'}} No. - <strong class="exclude">{{str_repeat('*', strlen($data->doc_no) - 4) . substr($data->doc_no, -4)}}</strong>) with Trainer ID - <strong class="exclude">{{$data->bt_tot_id}}</strong>
        @else
            <strong class="exclude">{{$data->assessor->salutation.' '.$data->assessor->name}} </strong>({{$data->assessor->doc_type?'Aadhaar':'Voter'}} No. - <strong class="exclude">{{str_repeat('*', strlen($data->doc_no) - 4) . substr($data->doc_no, -4)}}</strong>) with Assessor ID - <strong class="exclude">{{$data->bt_toa_id}}</strong>
        @endif
        <br>
        @if ($tag)
            @if ($data->trainer->trainer_category)
                has successfully cleared the assessment as
                <br>
                <strong class="exclude"> Master Trainer</strong> in the
                <br>
                Disability Orientation & Sensitization Training
            @else
                @if ($data->grade == 'Provisionally Pass')
                    has provisionally cleared the assessment as Trainer
                    <br>
                    in the Disability Orientation & Sensitization Module
                @else
                    has successfully cleared the assessment as
                    <br>
                    Trainer with Grade <strong>'{{$data->grade}}'</strong>
                    <br>
                    in the Disability Orientation & Sensitization Module
                @endif
            @endif
        @else
            @if ($data->grade == 'Provisionally Pass')
                has provisionally cleared the assessment as Assessor
                <br>
                in the Disability Orientation & Sensitization Module
            @else
                has successfully cleared the assessment as
                <br>
                Assessor with Grade <strong>'{{$data->grade}}'</strong>
                <br>
                in the Disability Orientation & Sensitization Module
            @endif
        @endif
        <br>
        covering Hearing Impairment, Blindness, Low Vision and Locomotor Disabilities.
    </div>
    @if ($tag)
        <div class="dates {{$data->trainer->trainer_category?'dates_tr':(($data->grade=='Provisionally Pass')?'dates_mtr':'dates_tr')}}">
            {{Carbon\Carbon::parse($data->batch->batch_end)->format('d-m-Y')}}
            <br>
            <span class="valid">
                {{Carbon\Carbon::parse($data->validity)->format('d-m-Y')}}
            </span>
        </div>
    @else
        <div class="dates {{($data->grade=='Provisionally Pass')?'dates_mtr':'dates_tr'}}">
            {{Carbon\Carbon::parse($data->batch->batch_end)->format('d-m-Y')}}
            <br>
            <span class="valid">
                {{Carbon\Carbon::parse($data->validity)->format('d-m-Y')}}
            </span>
        </div>
    @endif
    <div class="qr_section">
        {!! QrCode::size(200)->generate(route('tot-toa-qrdata',$data->digital_key)); !!}
            <br>
        <span class="qrid">
            {{$data->qr_id}}
        </span>
    </div>

</body>
</html>
