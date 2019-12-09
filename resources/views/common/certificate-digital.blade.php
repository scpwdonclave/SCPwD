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
    </head>
  <title>{{$candidateMark->certi_no}}</title>
    <body>
            <div style="position:relative;margin-left:30%">
                    <img src="{{asset('assets/images/scpwd-logo.png')}}" alt="SCPwD" style="height:120px;width:300px;">
            </div>
            <div style="position:relative;margin-left:30%">
                    {!! QrCode::size(300)->generate(route('assessment-qrdata',['id'=>$candidateMark->id])); !!}     
            </div>
        <div style="position:relative">
        <table id="customers">
            <tr>
              <th>#</th>
              <th>Details</th>
            </tr>
        @if ($candidateMark->candidate->gender=='Male')
        <tr>
        <td style="font-weight:bold;">Candidates Name</td>
        <td>Mr. {{$candidateMark->candidate->name}}</td>
        </tr>
        
            @if ($candidateMark->candidate->g_type=='Father')
            <tr>
              <td style="font-weight:bold;">Son of</td>
              <td> Mr. {{$candidateMark->candidate->g_name}}</td>
            </tr>
            @elseif($candidateMark->candidate->g_type=='Mother')
            <tr>
              <td style="font-weight:bold;">Son of</td>
              <td> Ms. {{$candidateMark->candidate->g_name}}</td>
            </tr>
            @elseif($candidateMark->candidate->g_type=='Wife')
            <tr>
              <td style="font-weight:bold;"> Husband of</td>
              <td> Ms. {{$candidateMark->candidate->g_name}}</td>
            </tr>
          @elseif($candidateMark->candidate->g_type=='Uncle')
          <tr>
            <td style="font-weight:bold;"> Nephew of</td>
            <td> Mr. {{$candidateMark->candidate->g_name}}</td>
          </tr>
          @endif

        @elseif($candidateMark->candidate->gender=='Female') 
            <tr>
              <td style="font-weight:bold;">Candidates Name</td>
              <td>Ms. {{$candidateMark->candidate->name}}</td>
            </tr>
          
          @if ($candidateMark->candidate->g_type=='Father')
            <tr>
              <td style="font-weight:bold;"> Daughter of</td>
              <td> Mr. {{$candidateMark->candidate->g_name}}</td>
            </tr>
          
          @elseif($candidateMark->candidate->g_type=='Mother')
          <tr>
            <td style="font-weight:bold;"> Daughter of</td>
            <td> Ms. {{$candidateMark->candidate->g_name}}</td>
          </tr>
          
          @elseif($candidateMark->candidate->g_type=='Husband')
          <tr>
            <td style="font-weight:bold;"> Wife of</td>
            <td> Mr. {{$candidateMark->candidate->g_name}}</td>
          </tr>
          
          @elseif($candidateMark->candidate->g_type=='Uncle')
          <tr>
            <td style="font-weight:bold;"> Niece of</td>
            <td> Mr. {{$candidateMark->candidate->g_name}}</td>
          </tr>
          @endif
        @endif
            
        @if (strlen($candidateMark->candidate->doc_no)==12)
            <tr>
              <td style="font-weight:bold;">Aadhaar No. </td>
              <td>******{{substr($candidateMark->candidate->doc_no,-6)}}</td>
            </tr>
            
        @else
            <tr>
              <td style="font-weight:bold;">Voter No. </td>
              <td>*****{{substr($candidateMark->candidate->doc_no,-5)}}</td>
            </tr>
             
        @endif
            
            <tr>
              <td style="font-weight:bold;">Job Role</td>
            <td>{{$candidateMark->batchAssessment->batch->jobrole->job_role}}</td>
              
            </tr>
            <tr>
              <td style="font-weight:bold;">QP No.</td>
            <td>{{$candidateMark->batchAssessment->batch->jobrole->qp_code}}</td>
             
            </tr>
            <tr>
              <td style="font-weight:bold;">NSQF Level</td>
            <td>{{$candidateMark->batchAssessment->batch->jobrole->nsqf_level}}</td>
              
            </tr>
            <tr>
              <td style="font-weight:bold;">Institute Name</td>
              <td>{{$candidateMark->batchAssessment->batch->center->center_name}}</td>
              
            </tr>
            <tr >
              <td style="font-weight:bold;">Batch End Date</td>
            <td>{{$candidateMark->batchAssessment->batch->batch_end}}</td>
              
            </tr>
            {{-- <tr >
              <td style="font-weight:bold;">Year</td>
              <td>2019</td>
              
            </tr> --}}
            <tr>
              <td style="font-weight:bold;">Issue Month/Year</td>
              <td>{{Carbon\Carbon::parse($candidateMark->updated_at)->format('M Y')}}</td>
              
            </tr>
            <tr>
                <td style="font-weight:bold;">Certificate No.</td>
                <td>{{$candidateMark->certi_no}}</td>
                
              </tr>
          </table>
        </div>
    </body>
</html>