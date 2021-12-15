@extends('layouts.master')

@section('content')
@php
    $country = \App\Models\Country::get();
@endphp
<form action="{{route('village.filter')}}" class="my-2" id="fillter_form" method="get">
	<div class="row">
		<div class="col-lg-4">
			<label>Village Name</label>
			<input type="text" class="form-control" name="name">
		</div>
		<div class="col-lg-4">
			<label>Country</label>
            <select class="form-control country_id" name="country_id" special_id="fillter">
                <option value="">--Select Country--</option>
                @foreach ($country as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            </select>
		</div>
        <div class="col-lg-4">
            <label>Provinces</label>
            <select class="form-control province_id" name="province_id" id="province_id_fillter" special_id="fillter">
                <option value="">--Select Province--</option>
            </select>
        </div>
        <div class="col-lg-4">
            <label>Districts</label>
            <select class="form-control" name="district_id" id="district_id_fillter">
                <option value="">--Select District--</option>
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
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_modal"> <i class="icon icon-plus"></i>New Village</button>
    </div>
    <div id="add_modal" tabindex="-1" role="dialog" class="modal fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <h4 class="modal-title"><i class="icon icon-plus"></i>Village Details</h4>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{route('village.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Country</label>
                            <select class="form-control country_id" name="country_id" special_id="0" required>
                                <option value="">--Select Country--</option>
                                @foreach ($country as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Provinces</label>
                            <select class="form-control province_id" name="province_id" id="province_id_0" special_id="0" required>
                                <option value="">--Select Province--</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Districts</label>
                            <select class="form-control" name="district_id" id="district_id_0" required>
                                <option value="">--Select District--</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Village Name</label>
                            <input type="text" name="name" class="form-control" oninvalid="InvalidMsg(this);" required>
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
            @include('configuration.village.pagination_data')
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

		$(document).on('change', '.country_id', function(event){
            var country_id = $(this).val();
            var special_id = $(this).attr('special_id');
            
            $.ajax({
                url:'{{route("country.provinces")}}',
                data:{'country_id':country_id},
				type:'get',
                beforeSend:function()
                {
                    $('#province_id_'+special_id).html('<option value="">--Loading--</option>');
                    $('.loader').show();
                },
                success:function(data)
                {
                    $('#province_id_'+special_id).html(data);
                    $('.loader').hide();
                },
                error:function()
                {
                    alert('There Is Problem on Processing Your Request Please Contact Database Administrator!');
                    $('#province_id_'+special_id).html('<option value="">--Select Province--</option>');
                    $('.loader').hide();
                }
            });
        });

		$(document).on('change', '.province_id', function(event){
            var province_id = $(this).val();
            var special_id = $(this).attr('special_id');
            
            $.ajax({
                url:'{{route("province.districts")}}',
                data:{'province_id':province_id},
				type:'get',
                beforeSend:function()
                {
                    $('#district_id_'+special_id).html('<option value="">--Loading--</option>');
                    $('.loader').show();
                },
                success:function(data)
                {
                    $('#district_id_'+special_id).html(data);
                    $('.loader').hide();
                },
                error:function()
                {
                    alert('There Is Problem on Processing Your Request Please Contact Database Administrator!');
                    $('#district_id_'+special_id).html('<option value="">--Select District--</option>');
                    $('.loader').hide();
                }
            });
        });
    });
</script>
@endsection
