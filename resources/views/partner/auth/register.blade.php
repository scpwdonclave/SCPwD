@extends('custom-logins.app')
 @section('content')
   <div class="wrap-login100 p-l-40 p-r-40 p-t-45 p-b-20">
     <form method="POST" id="form_partner_login" action="{{ route('partner.register') }}" class="login100-form" enctype="multipart/form-data">
     
       @csrf  
       <span class="login100-form-title p-b-10"> <img class="login-logo" onclick="location.href='{{route('index')}}'" src="{{ asset('assets/images/scpwd-logo.png') }}" alt="" srcset="" /> </span>
       <span class="login100-form-title m-b-10">Training Partner Registration</span>
         @if(Session::has('message'))
             <p class="alert {{ Session::get('alert-class', 'alert-info') }} text-center">{{ Session::get('message') }}</p>
         @endif
       <div class="wrap-input100 m-b-5">
           <div class="form-group">
               <input type="text" class="input100" name="spoc_name" value="{{ old('spoc_name') }}" placeholder="SPOC Name" required>                                
           </div>
         @if ($errors->has('spoc_name'))
         <span class="invalid-feedback" style="display:block" role="alert">
           <strong>{{ $errors->first('spoc_name') }}</strong>
         </span>
         @endif
       </div>
       
       <div class="wrap-input100 m-b-5">
           <div class="form-group">
               <input type="email" class="input100" name="email" value="{{ old('email') }}" placeholder="SPOC Email" required>                                
           </div>
         @if ($errors->has('email'))
         <span class="invalid-feedback" style="display:block" role="alert">
           <strong>{{ $errors->first('email') }}</strong>
         </span>
         @endif
       </div>
 
       <div class="wrap-input100 m-b-5">
           <div class="form-group">
               <input type="number" class="input100" name="spoc_mobile" value="{{ old('spoc_mobile') }}" placeholder="SPOC Mobile" required>                                
           </div>
         @if ($errors->has('spoc_mobile'))
         <span class="invalid-feedback" style="display:block" role="alert">
           <strong>{{ $errors->first('spoc_mobile') }}</strong>
         </span>
         @endif
       </div>
       
       <div class="wrap-input100 m-b-5">
           <div class="form-group">
               <label class="d-flex justify-content-center" style="color:#4b2354;font-weight:bold">Incorporation certifiate</label>                                                            
               <input id="incorp_doc" type="file" class="input100" name="incorp_doc" required>
               <span id="incorp_doc_error"  style="color:red;"></span>                                                            
           </div>
         @if ($errors->has('incorp_doc'))
         <span class="invalid-feedback" style="display:block" role="alert">
           <strong>{{ $errors->first('incorp_doc') }}</strong>
         </span>
         @endif
       </div>
 
         <div class="container-login100-form-btn">
           <button type="submit" class="login100-form-btn">Register</button>
         </div>
 
         <div class="d-flex justify-content-around p-t-30 p-b-20">
           <a href="{{ route('partner.login') }}" class="txt2 hov1"> Training Partner Login </a>
         </div>
       
     </form>
   </div>
 @endsection
 
 @section('page-script')
 
 <script>
     $(function(){
         /* Start File Type Validation for jpg,jpeg,png,pdf */         
         
             var _URL = window.URL || window.webkitURL;
             $("[type='file']").change(function(e) {
                 
             var image, file;
             for (var i = this.files.length - 1; i >= 0; i--) {
             if ((file = this.files[i])) {
                     image = new Image();
                     var fileType = file["type"];
                     var ValidImageTypes = ["image/jpg", "image/jpeg", "image/png", "application/pdf"];
                     if ($.inArray(fileType, ValidImageTypes) < 0) {
                         $("#"+e.currentTarget.id).val('');
                         $("#" + e.currentTarget.id + "_error").text('Supported jpg, jpeg, png, pdf');
                     } else {
                         $("#" + e.currentTarget.id + "_error").text('');
                     }
                     image.src = _URL.createObjectURL(file);
                 }
             }
             });
         
         /* End File Type Validation for jpg,jpeg,png,pdf */
 
     });
 </script>
 
 @endsection