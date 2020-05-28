<html>
    <head>
        <style>
            @page { size: 'A4';  margin: 5mm; }
            @media print {
                body {-webkit-print-color-adjust: exact;}
                }
            #customers {
              font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }
            
            #customers td, #customers th {
              border: 1px solid #ddd;
              padding: 8px;
            }
            
            #customers tr:nth-child(even){background-color: #f2f2f2;}
            
            #customers tr:hover {background-color: #ddd;}
            
            #customers th {
              padding-top: 12px;
              padding-bottom: 12px;
              text-align: left;
              background-color: #4CAF50;
              color: white;
            }
        </style>
        <title>{{($tag == 'tot')?$batchMapData->bt_tot_id:$batchMapData->bt_toa_id}}</title>
        <style>
            table {
            table-layout: fixed ;
            width: 100% ;
            }
            td {
            width: 25% ;
            }
            td.title{
                font-weight:bold;
            }
            div.text-center {
                text-align: center;
            }
        </style>
    </head>

    @php
        if ($tag == 'tot') {
            if($batchMapData->trainer->gender=='Male'){
                if ($batchMapData->trainer->g_type==='Father' || $batchMapData->trainer->g_type==='Mother') {
                    $guardian_of = 'Son of';
                } else {
                    $guardian_of = 'C/O of';
                }
            } elseif ($batchMapData->trainer->gender=='Female') {
                if ($batchMapData->trainer->g_type==='Father' || $batchMapData->trainer->g_type==='Mother') {
                    $guardian_of = 'Daughter of';
                } elseif ($batchMapData->trainer->g_type==='Husband') {
                    $guardian_of = 'Wife of';
                } else {
                    $guardian_of = 'C/O of';
                }
            } else {
                $guardian_of = 'C/O of';
            }
        } else {
            if($batchMapData->assessor->gender=='Male'){
                if ($batchMapData->assessor->g_type==='Father' || $batchMapData->assessor->g_type==='Mother') {
                    $guardian_of = 'Son of';
                } else {
                    $guardian_of = 'C/O of';
                }
            } elseif ($batchMapData->assessor->gender=='Female') {
                if ($batchMapData->assessor->g_type==='Father' || $batchMapData->assessor->g_type==='Mother') {
                    $guardian_of = 'Daughter of';
                } elseif ($batchMapData->assessor->g_type==='Husband') {
                    $guardian_of = 'Wife of';
                } else {
                    $guardian_of = 'C/O of';
                }
            } else {
                $guardian_of = 'C/O of';
            }
        }
        
    @endphp

    <body>
        <div class="text-center">
                <img src="{{asset('assets/images/scpwd-logo.png')}}" alt="SCPwD" style="height:120px;width:300px;">
        </div>
        <div class="text-center">
            {!! QrCode::size(300)->generate(route('tot-toa-qrdata',$batchMapData->digital_key)); !!}
        </div>
        <div style="position:relative">
            <table id="customers">
                <thead>
                    <tr>
                        <th>Details</th>
                        <th>Records</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="title">{{($tag == 'tot')?'Trainer':'Assessor'}} ID</td>
                        <td>{{($tag == 'tot')?$batchMapData->bt_tot_id:$batchMapData->bt_toa_id}}</td>
                    </tr>
                    <tr>
                        <td class="title">{{($tag == 'tot')?'Trainer':'Assessor'}} Name</td>
                        <td>{{($tag == 'tot')?$batchMapData->trainer->salutation.' '.$batchMapData->trainer->name:$batchMapData->assessor->salutation.' '.$batchMapData->assessor->name}}</td>
                    </tr>
                    <tr>
                        <td class="title">Guardian Name</td>
                        <td>{{$guardian_of.' '.(($tag == 'tot')?$batchMapData->trainer->g_name:$batchMapData->assessor->g_name)}}</td>
                    </tr>
                    <tr>
                        <td class="title">{{(($tag == 'tot')?$batchMapData->trainer->doc_type:$batchMapData->assessor->doc_type)?'Aadhaar':'Voter'}} No</td>
                        <td>{{str_repeat('*', strlen($batchMapData->doc_no) - 4) . substr($batchMapData->doc_no, -4)}}</td>
                    </tr>
                    @if ($tag == 'tot' && !$batchMapData->trainer->trainer_category)
                        <tr>
                            <td class="title">Grade</td>
                            <td>{{$batchMapData->grade}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="title">{{$tag == 'tot'?'TOT ':'TOA '}}Module</td>
                        <td>Disability Orientation & Sensitisation</td>
                    </tr>
                    <tr>
                        <td class="title">Covering Disability</td>
                        <td>Hearing Impairment, Blindness, Low Vision and Locomotor Disabilities</td>
                    </tr>
                    @if ($tag == 'tot' && !$batchMapData->trainer->trainer_category)
                        <tr>
                            <td class="title">TP Name</td>
                            <td>{{$batchMapData->tp_name}}</td>
                        </tr>
                    @endif
                    @if ($tag == 'toa')
                        <tr>
                            <td class="title">Agency Name</td>
                            <td>{{$batchMapData->assessor->agency->agency_name}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="title">Certificate Issue Date</td>
                        <td>{{Carbon\Carbon::parse($batchMapData->batch->batch_end)->format('d-m-Y')}}</td>
                    </tr>
                    <tr>
                        <td class="title">Certificate Valid Till</td>
                        <td>{{Carbon\Carbon::parse($batchMapData->validity)->format('d-m-Y')}}</td>
                    </tr>
                    <tr>
                        <td class="title">Certificate No</td>
                        <td>{{$batchMapData->qr_id}}</td>
                    </tr>
                    <tr>
                        <td class="title">Certifying Agency</td>
                        <td>Skill Council for Person with Disability (SCPwD)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>