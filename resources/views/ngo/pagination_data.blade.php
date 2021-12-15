
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Acronym</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr class="text-center">
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->acronym}}</td>
            <td>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit{{$item->id}}">
                Edit
            </button>

            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_modal{{$item->id}}">
                Delete
            </button>

            <button type="button" class="btn btn-info btn-sm">
                Donors
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
                    <form method="post" action="{{route('ngo.delete', session('sub-menu'))}}" id="delete_form{{$item->id}}">
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
                <h4 class="modal-title">Editing NGO</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                <form action="{{route('ngo.update', session('sub-menu'))}}" id="edit_form{{$item->id}}" method="post">
                    <input type="hidden" form="edit_form{{$item->id}}" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" form="edit_form{{$item->id}}" value="{{$item->id}}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Name</label>
                            <input type="text" name="name" form="edit_form{{$item->id}}" class="form-control" oninvalid="InvalidMsg(this);" value="{{$item->name}}" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Acronym</label>
                            <input type="text" name="acronym" form="edit_form{{$item->id}}" class="form-control" oninvalid="InvalidMsg(this);" value="{{$item->acronym}}" required>
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
