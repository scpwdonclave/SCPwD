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
        <title>{{$tot->bt_tot_id}}</title>
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
        if($tot->trainer->gender=='Male'){
            if ($tot->trainer->g_type==='Father' || $tot->trainer->g_type==='Mother') {
                $guardian_of = 'Son of';
            } else {
                $guardian_of = 'C/O of';
            }
        } elseif ($tot->trainer->gender=='Female') {
            if ($tot->trainer->g_type==='Father' || $tot->trainer->g_type==='Mother') {
                $guardian_of = 'Daughter of';
            } elseif ($tot->trainer->g_type==='Husband') {
                $guardian_of = 'Wife of';
            } else {
                $guardian_of = 'C/O of';
            }
        } else {
            $guardian_of = 'C/O of';
        }
    @endphp

    <body>
        <div class="text-center">
                <img src="{{asset('assets/images/scpwd-logo.png')}}" alt="SCPwD" style="height:120px;width:300px;">
        </div>
        <div class="text-center">
            {!! QrCode::size(300)->generate(route('tot-qrdata',$tot->digital_key)); !!}
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
                        <td class="title">Trainer ID</td>
                        <td>{{$tot->bt_tot_id}}</td>
                    </tr>
                    <tr>
                        <td class="title">Trainer Name</td>
                        <td>{{$tot->trainer->salutation.' '.$tot->trainer->name}}</td>
                    </tr>
                    <tr>
                        <td class="title">Guardian Name</td>
                        <td>{{$guardian_of.' '.$tot->trainer->g_name}}</td>
                    </tr>
                    <tr>
                        <td class="title">{{$tot->trainer->doc_type?'Aadhaar':'Voter'}} No</td>
                        <td>{{str_repeat('*', strlen($tot->doc_no) - 4) . substr($tot->doc_no, -4)}}</td>
                    </tr>
                    @if (!$tot->trainer->trainer_category)
                        <tr>
                            <td class="title">Grade</td>
                            <td>{{$tot->grade}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="title">ToT Module</td>
                        <td>Disability Orientation & Sensitisation</td>
                    </tr>
                    <tr>
                        <td class="title">Covering Disability</td>
                        <td>Hearing Impairment, Blindness, Low Vision and Locomotor Disabilities</td>
                    </tr>
                    @if (!$tot->trainer->trainer_category)
                        <tr>
                            <td class="title">TP Name</td>
                            <td>{{$tot->tp_name}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="title">Certificate Issue Date</td>
                        <td>{{Carbon\Carbon::parse($tot->batch->batch_end)->format('d-m-Y')}}</td>
                    </tr>
                    <tr>
                        <td class="title">Certificate Valid Till</td>
                        <td>{{Carbon\Carbon::parse($tot->validity)->format('d-m-Y')}}</td>
                    </tr>
                    <tr>
                        <td class="title">Certificate No</td>
                        <td>{{$tot->qr_id}}</td>
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