@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
               src="{{asset($user->photo == null ? 'dist/img/Omidjan Zazai.jpeg' : $user->photo)}}"
               alt="User profile picture">
        </div>

        <h3 class="profile-username text-center">{{$user->name}}</h3>

        <p class="text-muted text-center">{{$user->position}}</p>

        <p class="text-muted text-center">{{$user->email}}</p>

        <p class="text-muted text-center">{{$user->phone_number}}</p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="card">
      <div class="card-header p-2">
        <h4 class="d-inline">Info</h4>
        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#update_modal">Update Profile</button>
        <button type="button" class="btn btn-sm btn-primary float-right mr-2" data-toggle="modal" data-target="#password_modal">Change Password</button>
      </div><!-- /.card-header -->
      <div class="card-body">
        <h4 class="card-title"><b>Infromation</b></h4>
        <p class="card-text">{{$user->information}}</p>
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div id="update_modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Your Complete Information</h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('update.profile')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <label for="">Select Your Photo</label>
                    <input type="file" accept="image/*" class="form-control-file" name="photo">
                  </div>
                  <div class="col-xs-12 col-md-12">
                    <label for="">Information About You</label>
                    <textarea class="form-control" name="information" cols="30" rows="8">{{$user->information}}</textarea>
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

  <div id="password_modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Change Password</h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('change-user-password')}}" method="post">
                @csrf

                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <label for="">Old Password</label>
                    <input type="password" class="form-control" oninvalid="InvalidMsg(this);" name="old_password" required>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <label for="">Password</label>
                    <input type="password" class="form-control" oninvalid="InvalidMsg(this);" name="password" required>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" oninvalid="InvalidMsg(this);" name="password_confirmation" required>
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
</div>
@endsection
