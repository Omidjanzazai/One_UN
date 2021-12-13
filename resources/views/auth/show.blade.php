@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		<b style="font-size: 24px;">{{session('sub-menu')}}</b>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Name</th>
						<th class="text-center">Email Address</th>
						<th class="text-center">User Type</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					@php $count = 1; @endphp
					@foreach($users as $user)
						@if ($user->id != Auth::user()->id)
						<tr>
							<td class="text-center" style="vertical-align: middle;">{{$count}}</td>
							<td class="text-center" style="vertical-align: middle;">{{$user->name}}</td>
							<td class="text-center" style="vertical-align: middle;">{{$user->email}}</td>
							<td class="text-center" style="vertical-align: middle;">{{$user->user_type}}</td>
							<td class="text-center" style="vertical-align: middle;">
								<a data-toggle="modal" href="#reset_password{{$user->id}}" class="btn btn-danger mb-2">
									Reset Password
								</a>

								<div id="reset_password{{$user->id}}" tabindex="-1" role="dialog" class="modal fade">
									<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header bg-primary">
											<h4 class="modal-title">Reseting User Password</h4>
											<button type="button" class="close" data-dismiss="modal">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="{{route('change-password')}}"  method="post">
												{{csrf_field()}}
												<input type="hidden" value="{{$user->email}}" name="email">
												<div class="row">
													<div class="col-lg-12" style="padding: 0 30px 0 30px ;">
														<div class="form-group">
															<label for="">New Password</label>
															<input type="password" oninvalid="InvalidMsg(this);" class="form-control" name="password" required>
														</div>
													</div>
												</div>

												<div class="modal-footer">
													<button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
													<button class="btn btn-primary" type="submit">Save</button>
												</div>
											</form>
										</div>
									</div>
									</div>
								</div>

								<a data-toggle="modal" href="#permission{{$user->id}}" class="btn btn-info mb-2">
									Change User Type
								</a>
								
								<div id="permission{{$user->id}}" tabindex="-1" role="dialog" class="modal fade">
									<div class="modal-dialog modal-md">
									<div class="modal-content">
										<div class="modal-header bg-primary">
											<h4 class="modal-title">Change User Type</h4>
											<button type="button" class="close" data-dismiss="modal">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="{{route('change-permission')}}" class="change-permission" method="post">
												{{csrf_field()}}
												<input type="hidden" name="email" value="{{$user->email}}">
												<div class="row">
													<div class="col-lg-12">
														<div class="form-group">
															@php
																$jobs = \App\Models\Jobs::where('type', 1)->get();
															@endphp
															<label for="user_type">User Type</label>
															<select class="form-control" name="user_type" id="user_type" required>
																<option value="">--Select User Type--</option>
																@foreach ($jobs as $item)
																	<option value="{{$item->id}}" {{$user->job_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
													
												<div class="modal-footer">
													<button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
													<button class="btn btn-primary" type="submit">Save</button>
												</div>
											</form>
										</div>
									</div>
									</div>
								</div>

								<button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#delete_modal{{$user->id}}">
									<i class="fa fa-trash"></i> Delete
								</button>

								<div id="delete_modal{{$user->id}}" tabindex="-1" role="dialog" class="modal fade">
									<div class="modal-dialog modal-sm">
									  <div class="modal-content">
										<div class="modal-header bg-primary">
											<h4 class="modal-title">Are You Sure?</h4>
											<button type="button" class="close" data-dismiss="modal">
											  <span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
										  <form method="post" action="{{route('user-delete',['email'=>$user->email])}}" id="delete_form{{$user->id}}">
											<input type="hidden" form="delete_form{{$user->id}}" name="_token" value="{{ csrf_token() }}">
											<input type="hidden" form="delete_form{{$user->id}}" name="_method" value="DELETE">
					
											<div class="modal-footer" style="justify-content: center;">
												<button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
												<button class="btn btn-danger" form="delete_form{{$user->id}}" type="submit">Delete</button>
											</div>
										  </form>
										</div>
									  </div>
									</div>
								</div>
							</td>
						</tr>
						@php $count++; @endphp
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
