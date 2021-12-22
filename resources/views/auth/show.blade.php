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
						<th class="text-center">Phone</th>
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
							<td class="text-center" style="vertical-align: middle;">{{$user->phone_number}}</td>
							<td class="text-center" style="vertical-align: middle;">{{$user->email}}</td>
							<td class="text-center" style="vertical-align: middle;">{{$user->user_type}}</td>
							<td class="text-center" style="vertical-align: middle;">

								<button type="button" class="btn btn-sm btn-danger mb-2" data-toggle="modal" data-target="#delete_modal{{$user->id}}">
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
											<input type="hidden" form="delete_form{{$user->id}}" name="id" value="{{$user->id}}">
					
											<div class="modal-footer" style="justify-content: center;">
												<button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
												<button class="btn btn-danger" form="delete_form{{$user->id}}" type="submit">Delete</button>
											</div>
										  </form>
										</div>
									  </div>
									</div>
								</div>

								<a href="{{route('user-info', $user->id)}}" class="btn btn-sm btn-info mb-2">
									<i class="fa fa-info-circle"></i> Info
								</a>
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
