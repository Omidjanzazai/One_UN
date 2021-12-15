@extends('layouts.master')

@section('content')
@php
    $country = \App\Models\Country::get();
@endphp
<form action="{{route('ministry.filter')}}" class="my-2" id="fillter_form" method="get">
	<div class="row">
		<div class="col-lg-4">
			<label>Ministry Name</label>
			<input type="text" class="form-control" name="name">
		</div>
        <div class="col-lg-4">
            <label>Acronym</label>
            <input type="text" class="form-control" name="acronym">
        </div>
        <div class="col-lg-4">
            <label>Sector</label>
            <input type="text" class="form-control" name="sector">
        </div>
		<div class="col-lg-4">
			<label>Country</label>
            <select class="form-control" name="country_id">
                <option value="">--Select Country--</option>
                @foreach ($country as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
		</div>
		<div class="col-lg-3">
			<label> </label>
			<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
		</div>
	</div>
</form>

<div class="card">
	<div class="card-header">
        <b style="font-size: 24px;">{{session('sub-menu')}}</b>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_modal"> <i class="icon icon-plus"></i>New Ministry</button>
    </div>
    <div id="add_modal" tabindex="-1" role="dialog" class="modal fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <h4 class="modal-title"><i class="icon icon-plus"></i>Ministry Details</h4>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{route('ministry.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Ministry Name</label>
                            <input type="text" name="name" class="form-control" oninvalid="InvalidMsg(this);" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Acronym</label>
                            <input type="text" name="acronym" class="form-control" oninvalid="InvalidMsg(this);" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Sector <small style="color: coral;">for multiple sectors sperate via comma(,)</small></label>
                            <input type="text" name="sector" class="form-control" oninvalid="InvalidMsg(this);" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Country</label>
                            <select class="form-control" name="country_id">
                                <option value="">--Select Country--</option>
                                @foreach ($country as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
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
		<div class="table-responsive" id="table-data">
            @include('ministry.pagination_data')
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
		$(document).on('submit', '#fillter_form', function(event){
			event.preventDefault();

			var url = $(this).attr('action');
			$.ajax({
				url:url,
				type:'get',
                data:$(this).serialize(),
				dataType:'html',
				beforeSend:function ()
                {
					$('.loader').show();
				},
				success:function (data)
                {
                    $('.table-responsive').html(data);
                    $('.loader').hide();
				},
				error: function()
				{
					alert('There Is Problem on Processing Your Request Please Contact Database Administrator!');
					$('.loader').hide();
				}
			});
		});

		$(document).on('click', '.pagination a', function(event){
            event.preventDefault(); 
            var url = $(this).attr('href');
            
            $.ajax({
                url:url,
                beforeSend:function()
                {
                    $('.loader').show();
                },
                success:function(data)
                {
                    $('#table-data').html(data);
                    $('.loader').hide();
                },
                error:function()
                {
                    alert('There Is Problem on Processing Your Request Please Contact Database Administrator!');
                    $('.loader').hide();
                }
            });
        });
    });
</script>
@endsection
