@extends('layouts.master')

@section('content')
<style>
  fieldset
  {
      border: 1px solid #ddd !important;
      min-width: 0;
      width: 100%;
      padding: 10px;
      position: relative;
      border-radius:6px;
      background-color:#f3f3f3;
      margin-top:10px;
      padding-left:10px!important;
  }

  legend
  {
      font-size:14px;
      font-weight:bold;
      margin-bottom: 0px;
      width: 55%;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px 5px 5px 10px;
      color:white;
      background-color:#3B3F51;
      opacity: 0.8;
  }
</style>
<div class="card">
	<div class="card-header">
    <b style="font-size: 24px;">{{session('sub-menu')}}</b>
    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_modal"> <i class="icon icon-plus"></i>New Job</button>
  </div>
  <div id="add_modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title"><i class="icon icon-plus"></i>Job Details</h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('user.jobs.store')}}" method="post">
                @csrf
                <div class="row">
                  <div class="col-lg-12">
                    <label>Name</label>
                    <input type="text" class="form-control" oninvalid="InvalidMsg(this);" name="name" required>
                  </div>

                  <div class="col-xs-12 col-md-6">
                    <fieldset>
                      <legend>
                        Access Domains
                      </legend>
                      <div class="form-group" >
                        <div class="col-md-12">
                          <ul>
                            @foreach($domains as $d)
                              <li>{{$d->domain}}</li>
                              @foreach($access_domains as $a_d)
                                @if($a_d->domain == $d->domain)
                                  <ul>
                                    <li>
                                      <input type="checkbox" value="{{$a_d->id}}" name="access_domain[]" id="add_domain{{$a_d->id}}" >
                                      <label for="add_domain{{$a_d->id}}">{{$a_d->item}}</label>
                                    </li>
                                  </ul>
                                @endif
                              @endforeach
                            @endforeach
                          </ul>

                          {{-- <select class="form-control" oninvalid="InvalidMsg(this);" name="access_domain[]" multiple style="height: 357px;" required>
                            @foreach($domains as $d)
                              <optgroup label="{{$d->domain}}">
                                @foreach($access_domains as $a_d)
                                @if($a_d->domain == $d->domain)
                                  <option value="{{$a_d->id}}">{{$a_d->item}}</option>
                                  @endif
                                @endforeach
                              </optgroup>
                            @endforeach
                          </select> --}}
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <fieldset>
                      <legend>
                      Roles
                      </legend>
                      <div class="form-group" >
                        <div class="col-md-12">
                          <ul>
                            @foreach($roles as $role)
                              <li>
                                <input type="checkbox" value="{{$role->id}}" name="role[]" id="add_role{{$role->id}}" >
                                <label for="add_role{{$role->id}}">{{$role->role}}</label>
                              </li>
                            @endforeach
                          </ul>

                          {{-- <select class="form-control" oninvalid="InvalidMsg(this);" multiple style="height: 357px;" name="role[]" required>
                            @foreach($roles as $role)
                              <option value="{{$role->id}}">{{$role->role}}</option>
                            @endforeach
                          </select> --}}
                        </div>
                      </div>
                    </fieldset>
                  </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Name</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
          @php
              $x = 1;
          @endphp
          @foreach ($jobs as $item)
					<tr class="text-center">
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit{{$item->id}}">
                Edit
              </button>
          
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_modal{{$item->id}}">
                Delete
              </button>
            </td>

            <div id="delete_modal{{$item->id}}" tabindex="-1" role="dialog" class="modal fade">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h4 class="modal-title">Are You Sure?</h4>
                  <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{route('user.jobs.delete')}}" id="delete_form{{$item->id}}">
                  <input type="hidden" form="delete_form{{$item->id}}" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" form="delete_form{{$item->id}}" name="_method" value="DELETE">
                  <input type="hidden" form="delete_form{{$item->id}}" name="id" value="{{$item->id}}">
      
                  <div class="modal-footer" style="justify-content: center;">
                    <button class="btn btn-default" data-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-danger" form="delete_form{{$item->id}}" type="submit">Delete</button>
                  </div>
                  </form>
                </div>
                </div>
              </div>
            </div>

            <div id="edit{{$item->id}}" tabindex="-1" role="dialog" class="modal fade">
              <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h4 class="modal-title">Editing Job</h4>
                  <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{route('user.jobs.update')}}" id="edit_form{{$item->id}}" method="post">
                    @csrf
                    <input type="hidden" name="id" form="edit_form{{$item->id}}" value="{{$item->id}}">
                    <div class="row">
                      <div class="col-lg-12">
                        <label>Name</label>
                        <input type="text" class="form-control" oninvalid="InvalidMsg(this);" name="name" value="{{$item->name}}" required>
                      </div>
                      <div class="col-xs-12 col-md-6">
                        <fieldset>
                          <legend>
                          Access Domains
                          </legend>
                          <div class="form-group">
                            <div class="col-md-12">
                              <ul>
                                @foreach($domains as $d)
                                  <li>{{$d->domain}}</li>
                                  @foreach($access_domains as $a_d)
                                    @if($a_d->domain == $d->domain)
                                      <ul>
                                        <li>
                                          <input type="checkbox" value="{{$a_d->id}}" name="access_domain[]" {{$item->hasAccessDomain($a_d->item)? "checked": ''}} id="edit_domain{{$x.$a_d->id}}">
                                          <label for="edit_domain{{$x.$a_d->id}}">{{$a_d->item}}</label>
                                        </li>
                                      </ul>
                                    @endif
                                  @endforeach
                                @endforeach
                              </ul>
                              
                              {{-- <select class="form-control" form="edit_form{{$item->id}}" oninvalid="InvalidMsg(this);" name="access_domain[]" multiple style="height: 357px;">
                                @foreach($domains as $d)
                                  @php $c=0; @endphp
                                  <optgroup label="{{$d->domain}}">
                                    @foreach($access_domains as $a_d)
                                      @if($a_d->domain == $d->domain)
                                        <option value="{{$a_d->id}}" {{$item->hasAccessDomain($a_d->item)? "selected": ''}}>{{$a_d->item}}</option>
                                        @php $c++; @endphp
                                      @endif
                                    @endforeach
                                  </optgroup>
                                @endforeach
                              </select> --}}
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <div class="col-xs-12 col-md-6">
                        <fieldset>
                          <legend>
                          Roles
                          </legend>
                          <div class="form-group" >
                            <div class="col-md-12">
                              <ul>
                                @foreach($roles as $role)
                                  <li>
                                    <input type="checkbox" value="{{$role->id}}" name="role[]" {{$item->hasRole($role->role) ? 'checked' : ''}} id="edit_role{{$x.$role->id}}" >
                                    <label for="edit_role{{$x.$role->id}}">{{$role->role}}</label>
                                  </li>
                                @endforeach
                              </ul>

                              {{-- <select class="form-control" form="edit_form{{$item->id}}" oninvalid="InvalidMsg(this);" multiple style="height: 357px;" name="role[]">
                                @foreach($roles as $role)
                                  <option value="{{$role->id}}" {{$item->hasRole($role->role)?'selected':''}}>{{$role->role}}</option>
                                @endforeach
                              </select> --}}
                            </div>
                          </div>
                        </fieldset>
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
          </tr>
          @php
            $x++;
          @endphp
          @endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@section('script')
    
@endsection
