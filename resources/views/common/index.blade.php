@extends('custom-logins.app-index')
@section('content')
<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-pic-mobile">
				<img src="{{asset('assets/images/scpwd-trans.png')}}" alt="IMG">
			</div>
			<div class="login100-pic">
				<div class="logo">
					<img src="{{asset('assets/images/scpwd-trans.png')}}" alt="IMG">
				</div>
				<div class="js-tilt" data-tilt>
					<img src="{{asset('assets/images/geek.png')}}" alt="IMG">
				</div>
			</div>

			<div class="login100-form validate-form">
				<span class="login100-form-title">
					Partner Management System
				</span>

					
				<div class="container-login100-form-btn">
					<button class="login100-form-btn" onclick="location.href='{{route('partner.login')}}'">
						Training Partner
					</button>
				</div>
				<div class="container-login100-form-btn" onclick="location.href='{{route('center.login')}}'">
					<button class="login100-form-btn">
						Traiing Center
					</button>
				</div>
				<div class="container-login100-form-btn" onclick="location.href='{{route('agency.login')}}'">
					<button class="login100-form-btn">
						Assessment Agency
					</button>
				</div>
				<div class="container-login100-form-btn" onclick="location.href='{{route('assessor.login')}}'">
					<button class="login100-form-btn">
						Assessor
					</button>
				</div>

				<div class="text-center p-t-12">
					<a href="#TermsModal" class="custom-btn txt2" data-toggle="modal" data-target="#TermsModal">Terms & Conditions</a>
				</div>

				<div class="text-center p-t-25">
					<button class="custom-btn txt2" onclick="location.href='{{route('partner.register')}}'">
						Training Partner Registration
						<i class="zmdi zmdi-long-arrow-right m-l-5" aria-hidden="true"></i>
					</button>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
@section('modal')
    <div class="modal fade" id="TermsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="TermsModalLabel">Company Terms & Conditions</h4>
                </div>
                <div class="modal-body">
                    {{Config::get('constants.declaration')}}
                </div>
            </div>
        </div>
    </div>
@stop