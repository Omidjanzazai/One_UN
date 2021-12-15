
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Donor</th>
            <th class="text-center">Country</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $country = \App\Models\Country::get();
        @endphp
        @foreach ($data as $item)
        <tr class="text-center">
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->country_name}}</td>
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
                    <form method="post" action="{{route('donor.delete')}}" id="delete_form{{$item->id}}">
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
                <h4 class="modal-title">Editing Donor</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                <form action="{{route('donor.update')}}" id="edit_form{{$item->id}}" method="post">
                    <input type="hidden" form="edit_form{{$item->id}}" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" form="edit_form{{$item->id}}" value="{{$item->id}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Donor Name</label>
                            <input type="text" name="name" form="edit_form{{$item->id}}" class="form-control" oninvalid="InvalidMsg(this);" value="{{$item->name}}" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Country</label>
                            <select class="form-control" name="country_id" form="edit_form{{$item->id}}" required>
                                <option value="">--Select Country--</option>
                                @foreach ($country as $country_item)
                                    <option value="{{$country_item->id}}" {{$country_item->id == $item->country_id ? 'selected' : ''}}>{{$country_item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                        <button class="btn btn-primary" form="edit_form{{$item->id}}" type="submit">Save</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
            </div>
        </tr>
        @endforeach
    </tbody>
</table>
@if($data instanceof \Illuminate\Pagination\LengthAwarePaginator){{$data->links()}}@endif
