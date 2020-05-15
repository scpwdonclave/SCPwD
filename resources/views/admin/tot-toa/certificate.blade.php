<html>
<title>{{$trainer->bt_tot_id}}</title>
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
            padding-top: 212px;
        } 
        div.dates_mtr {
            padding-top: 166px;
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
        <strong class="exclude">{{$trainer->trainer->salutation.' '.$trainer->trainer->name}} </strong>({{$trainer->trainer->doc_type?'Aadhaar':'Voter'}} No. - <strong class="exclude">{{str_repeat('*', strlen($trainer->doc_no) - 4) . substr($trainer->doc_no, -4)}}</strong>) with Trainer ID - <strong class="exclude">{{$trainer->bt_tot_id}}</strong>
        <br>
        @if ($trainer->trainer->trainer_category)
            has successfully cleared the assessment as
            <br>
            <strong class="exclude"> Master Trainer</strong> in the
            <br>
            Disability Orientation & Sensitization Training
        @else
            @if ($trainer->grade == 'Provisionally Pass')
                has provisionally cleared the assessment as Trainer
                <br>
                in the Disability Orientation & Sensitization Module
            @else
                has successfully cleared the assessment as
                <br>
                Trainer with Grade <strong>'{{$trainer->grade}}'</strong>
                <br>
                in the Disability Orientation & Sensitization Module
            @endif
        @endif
        <br>
        covering Hearing Impairment, Blindness, Low Vision and Locomotor Disabilities.
    </div>
    <div class="dates {{$trainer->trainer->trainer_category?'dates_mtr':'dates_tr'}}">
        {{Carbon\Carbon::parse($trainer->batch->batch_end)->format('d-m-Y')}}
        <br>
        <span class="valid">
            {{Carbon\Carbon::parse($trainer->validity)->format('d-m-Y')}}
        </span>
    </div>
    <div class="qr_section">
        {!! QrCode::size(200)->generate(route('tot-qrdata',$trainer->digital_key)); !!}
            <br>
        <span class="qrid">
            {{$trainer->qr_id}}
        </span>
    </div>

</body>
</html>
