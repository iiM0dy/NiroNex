@extends(backendView('layouts.auth'))

@section('title', 'Password Reset')

@section('content')
<div class="container-xxl">

	<div class="row g-0">
		<div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
			<div style="max-width: 25rem;">
				<div class="text-center mb-5">
					<i class="bi bi-bag-check-fill  text-primary" style="font-size: 90px;"></i>
				</div>
				<div class="mb-5">
					<h2 class="color-900 text-center">A few clicks is all it takes.</h2>
				</div>
				<!-- Image block -->
				<div class="">
					<img src="{!! backendAssets('dist/assets/images/login-img.svg') !!}" alt="login-img">
				</div>
			</div>
		</div>

		<div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
			<div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
				<!-- Form -->
				<form class="row g-1 p-3 p-md-4">
					<div class="col-12 text-center mb-5">
						<img src="{!! backendAssets('dist/assets/images/forgot-password.svg') !!}" class="w240 mb-4" alt="" />
						<h1>Forgot password?</h1>
						<span>Enter the email address you used when you joined and we'll send you instructions to reset your password.</span>
					</div>
					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Email address</label>
							<input type="email" class="form-control form-control-lg" placeholder="name@example.com">
						</div>
					</div>
					<div class="col-12 text-center mt-4">
						<a href="{!! backendRoutePut('auth-two-step') !!}" title="" class="btn btn-lg btn-block btn-light lift text-uppercase">SUBMIT</a>
					</div>
					<div class="col-12 text-center mt-4">
						<span class="text-muted"><a href="{!! backendRoutePut('auth-signin') !!}" class="text-secondary">Back to Sign in</a></span>
					</div>
				</form>
				<!-- End Form -->

			</div>
		</div>
	</div> <!-- End Row -->

</div>
@endsection

@push('styles')
@endpush

@push('custom_styles')
@endpush

@push('scripts')
@endpush

@push('custom_scripts')
@endpush

@push('modals')
@endpush
