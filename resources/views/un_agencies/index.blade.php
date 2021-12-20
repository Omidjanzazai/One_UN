@extends('layouts.master')

@section('content')
<form action="{{route('un_agencies.filter')}}" class="my-2" id="fillter_form" method="get">
	<div class="row">
		<div class="col-lg-6">
			<label>Value</label>
			<input type="text" class="form-control" name="value">
		</div>
		<div class="col-lg-3">
			<label>Search By</label>
            <select class="form-control" name="search_by">
                <option>Name</option>
                <option>Acronym</option>
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
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_modal"> <i class="icon icon-plus"></i>New Agency</button>
    </div>
    <div id="add_modal" tabindex="-1" role="dialog" class="modal fade">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <h4 class="modal-title"><i class="icon icon-plus"></i>Agency Details</h4>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{route('un_agencies.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" oninvalid="InvalidMsg(this);" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Acronym</label>
                            <input type="text" name="acronym" class="form-control" oninvalid="InvalidMsg(this);" required>
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
            @include('un_agencies.pagination_data')
		</div>
	</div>
</div>

<div id="donors_modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-primary">
        <h4 class="modal-title">Donors</h4>
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Country</th>
                        </tr>
                    </thead>
                    <tbody id="donor_details">
                        <tr>
                            <td colspan="3" style="color: coral;">This agency dont has any donor.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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

		$(document).on('click', '.donors', function(event){
            var id = $(this).attr('record_id');
            
            $.ajax({
                url:'{{route("un_agencies.donors")}}',
                data:{'id':id},
                beforeSend:function()
                {
                    $('.loader').show();
                },
                success:function(data)
                {
                    if (data != '') {
                        $('#donor_details').html(data);
                    }
                    $('#donors_modal').modal('show');
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
