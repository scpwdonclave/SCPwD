@extends('custom-logins.app-index')
@section('content')
  <div class="testimonials">
		<div class="card" onclick="location.href='{{route('partner.login')}}'">
			<div class="layer"></div>
			<div class="content">
				<p>A Portal For Training Partners. Manage your Training Centers, Trainers, Candidates, Batches</p>
				<div class="image">
					<img src="https://picsum.photos/200">
				</div>
				<div class="details">
					<h2>
						Training Partners<br><span>Login to SCPwD</span>
					</h2>
				</div>
			</div>
		</div>

		<div class="card" onclick="location.href='{{route('center.login')}}'">
			<div class="layer"></div>
			<div class="content">
				<p>A Portal For Training Centers. Login to Manage Candidates, view Batches and Stats</p>
				<div class="image">
					<img src="https://picsum.photos/200">
				</div>
				<div class="details">
					<h2>
						Training Centers<br><span>Login to SCPwD</span>
					</h2>
				</div>
			</div>
		</div>
		
		<div class="card" onclick="location.href='{{route('agency.login')}}'">
			<div class="layer"></div>
			<div class="content">
				<p>A Portal For Assessment Agencies. Login to Manage Assessors, Batchs view Stats</p>
				<div class="image">
					<img src="https://picsum.photos/200">
				</div>
				<div class="details">
					<h2>
						Assessment Agencies<br><span>Login to SCPwD</span>
					</h2>
				</div>
			</div>
		</div>
		<div class="card" onclick="location.href='{{route('assessor.login')}}'">
			<div class="layer"></div>
			<div class="content">
				<p>A Portal For Assessors. Login To Manage Batchs and assessments view Stats</p>
				<div class="image">
					<img src="https://picsum.photos/200">
				</div>
				<div class="details">
					<h2>
						Assessors<br><span>Login to SCPwD</span>
					</h2>
				</div>
			</div>
		</div>
	</div>
@endsection