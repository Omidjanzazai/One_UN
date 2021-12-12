@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-body">
		<form class="form-horizontal" role="form" method="POST" action="{{route('user-store')}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<fieldset>
						<legend>
							User Information
						</legend>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
									<div class="col-md-12">
										<label for="name" class="control-label">Full Name</label>
										<input id="name" type="text" oninvalid="InvalidMsg(this);" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
										@if ($errors->has('name'))
											<span class="help-block">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
									<div class="col-md-12">
										<label for="email" class=" control-label">Email Address</label>
										<input id="email" type="email" oninvalid="InvalidMsg(this);" class="form-control" name="email" value="{{ old('email') }}" required>
										@if ($errors->has('email'))
											<span class="help-block">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<div class="col-md-12">
										<label for="password" class="control-label">Password</label>
										<input id="password" type="password" oninvalid="InvalidMsg(this);" class="form-control" name="password" required>
											@if ($errors->has('password'))
												<span class="help-block">
													<strong>{{ $errors->first('password') }}</strong>
												</span>
											@endif
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<div class="col-md-12">
										<label for="password-confirm" class="control-label">Confirm Password</label>
										<input id="password-confirm" type="password" oninvalid="InvalidMsg(this);" class="form-control" name="password_confirmation" required>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<div class="col-md-12">
										@php
											$jobs = \App\Models\Jobs::where('type', 1)->get();
										@endphp
										<label for="user_type">User Type</label>
										<select class="form-control" oninvalid="InvalidMsg(this);" name="user_type" id="user_type" required>
											<option value="">--Select User Type--</option>
											@foreach ($jobs as $item)
												<option value="{{$item->id}}">{{$item->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-right">
					<br>
					<div class="form-group">
						<button type="submit" class="btn btn-primary " style="margin-left: 15px; margin-right: 15px;">
						Register
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
