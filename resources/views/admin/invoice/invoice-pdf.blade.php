
<html>
 <head>
 <title>{{$invoice->invoice_id}}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}"> 
        {{-- <link href="../../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../../assets/css/main.css" rel="stylesheet">
        <link href="../../../assets/css/color_skins.css" rel="stylesheet"> --}}
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <style>
            .table th{
                padding: 0.30rem !important
            }
            body { font-family: 'Montserrat, Arial, Tahoma, sans-serif'; }
            /* .table td {
                vertical-align: center;
                border-top: 1px solid #dee2e6;
                text-align: center;
                    }
                    .table:not(.nobtn) td {
                    padding: .10rem;
                    }    */
        
            </style>  
 </head>
 <body style="background-color:white;"> 
   
<div class="container" style="border:1px solid #cecece;"><br>
                                 
    <div class="row">
            <div class="col-4" style="float:left;">
            <strong><span style="font-size:16px;">Skill Council for Persons with Disability </span></strong>
                   <br />
                  <span style="font-size:15px;">
                    501 City Centre Plot No.5 Sec-12 Dwarka<br>
                    New Delhi<br>
                    E-Mail : bhupesh.sharma@scpwd.in<br>
                </span>
                    
              </div>
        <div class="col-4" style="float:left;">
                <div class="text-center">
                        <h4>INVOICE</h4>
                    </div> 
        </div>
       <div class="col-4" style="float:left;">
          <img src="{{asset('assets/images/scpwd-logo.png')}}" /> 
       </div>
        
   </div>
   <div  class="row" style="padding-top:15%;">
    <div class="col-12"  style="float:left;border-top:1px solid #cecece;border-bottom:1px solid #cecece;">

       <div class="col-6" style="float:left;border-right:1px solid #cecece;">
           <span style="font-size:17px;">
            <strong>BUYER </strong>
           </span><br>
           <span style="font-size:13px;">
            @if ($invoice->re_assessment===0)
            {{$invoice->scheme->department->dept_name}} <br>
            {{$invoice->scheme->department->dept_address}}
                
            @else
            {{$invoice->center->center_name}} <br>
            {{$invoice->center->center_address}}  
            @endif
            </span><br><br><br><br><br>
       </div>
       <div class="col-6" style="float:left;">
            <span style="font-size:15px;">
            Invoice No: <strong>{{$invoice->invoice_id}}</strong>
                </span><br>
            <span style="font-size:15px;">
            Dated: <strong>{{Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y')}}</strong>
                </span><br>
            <span style="font-size:15px;">
                    Mode/Terms Of Payment: <strong>N/A</strong>
                </span><br>
            <span style="font-size:15px;">
                    Supplier's Ref: <strong>{{$invoice->ref_no}}
                    </strong>
                </span><br>
            <span style="font-size:15px;">
                @if ($invoice->other_ref_no === null)
                Other Reference(s): <strong>N/A</strong>
                
                @else
            Other Reference(s): <strong>{{$invoice->other_ref_no}}</strong>
                    
                @endif
                </span><br><br>
        </div>
   </div>
   </div> 
  
   
   <div class="row">
       <div class="col-md-12">
       
                <table  class="table nobtn table-bordered ">
                      
                        <thead>
                            <tr style="height:50px;">
                                <th style="width:5px;">#</th>
                                <th>Particulars</th>
                                <th style="width:155px;">Amount</th>
                                
                            </tr>
                           
                        </thead>
                              <tbody>
                                 
                                    <tr>
                                    <td style="width:5px;">1.</td>
                                    <td style="text-align:left;">
                                       <p><strong>FEE-ASSESSMENT-DEPwD</strong></p> 
                                        <p>{{$invoice->partner->org_name}} </p>
                                        <p>JOBROLE/NO OF CANDIDATES--</p>
                                        @foreach ($invoice->invoice_job as $key => $item)
                                    <p>{{$key+1}}. {{$item->jobrole->job_role}}- {{$item->candidate_no}} </p>
                                            
                                        @endforeach
                                        

                                    </td>
                                <td style="width:155px;text-align:center"><strong>{{number_format($total_candidate*1000)}}</strong></td>
                                    </tr> 
                                    {{-- <tr>
                                    <td style="width:5px;">1.</td>
                                    <td style="text-align:left;">
                                       <p><strong>FEE-ASSESSMENT-DEPwD</strong></p> 
                                        <p>TP-SURGAUJA GYANODAYA ASSPCOATION </p>
                                        <p>JOBROLE/NO OF CANDIDATES--</p>
                                        <p>1.ASSISSTANT HAIR STYLIST-30 </p>
                                        <p>2.ASSISSTANT BEAUTY THERPIST-30 </p>
                                       <p> 3.AUTOMOTIVE SERVICE TECHNICIAN-30 </p>
                                        <p>4.HAND EMBROIDERER-30</p>

                                    </td>
                                    <td style="width:155px;">988989</td>
                                    </tr>  --}}
                                   <tr>
                                       <td></td>
                                       <td style="text-align:right;"><strong>TOTAL</strong></td>
                                   <td><strong>{{number_format($total_candidate*1000)}}</strong></td>
                                   </tr>
                                  
                                   
                              </tbody>
                             
                      </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span><strong>&nbsp;&nbsp;&nbsp;Amount Chargeable (in words)</strong></span><span style="float:right;">E & OE &nbsp;&nbsp;&nbsp;</span>
                <p><strong>&nbsp;&nbsp;&nbsp;INR {{ucwords($amount_word)}} Only</strong></p>
                </div>
                <br><br>
                <div class="col-6">
                    <span><strong>&nbsp;&nbsp;&nbsp;Remarks:</strong></span>
                    <p class="container"> BEING AMOUNT OF ASSESSMENT FEE@Rs 1000 * {{$total_candidate}} FOR ASSESSMENT COMPLETED/RESULT SUBMITTED</p>
                    <p>&nbsp;&nbsp;&nbsp;Company’s PAN : <strong>AANAS7044L</strong></p>
                </div>
                
            </div>
            <div class="row">
                <div style="padding-left:25rem">
                   
                    <table>
                        <tr>
                            <td colspan="2"><strong>Company’s Bank Details </strong></td>
                            
                        </tr>
                        <tr>
                            <td>Bank Name :</td>
                            <td><strong>HDFC BANK</strong></td>
                        </tr>
                        <tr>
                            <td> A/C NO.</td>
                            <td><strong>50100132666285</strong></td>
                        </tr>
                        <tr>
                            <td>Branch & IFS Code :</td>
                            <td><strong>DWARKA SECTOR - 11 & HDFC0001338</strong></td>
                        </tr>
                    </table>
                    </div>
                </div><br>
    <div class="row">
    <div  style="border:1px solid #cecece;float:left;width:50%">
        <p> Customer’s Seal and Signature</p><br><br><br>
      
    
    </div>
    <div  style="border:1px solid #cecece;float:left;width:50%">
        <p>For Skill Council for Persons with Disability</p><br><br>
        <table>
            <tr>
                <td style="padding-right:70px">Prepared by </td>
                <td style="padding-right:70px">Verified by</td>
                <td>Authorised Signatory</td>
            </tr>
        </table>
    
    </div>
</div>
  {{-- ==============   --}}
</div><br>
<div class="text-center"><p><strong>This is a Computer Generated Invoice</strong></p></div>
</body>
</html>

