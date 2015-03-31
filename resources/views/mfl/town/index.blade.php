@extends("layout")
@section("content")
<br /><br /><br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <a href="#"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.town', 2) }} <span class="panel-btn">
      <a class="btn btn-sm btn-info" href="{{ URL::to("town/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ trans('messages.create-town') }}
          </a>
        </span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover search-table">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th>{{ Lang::choice('messages.constituency', 1) }}</th>
                            <th>{{ Lang::choice('messages.postal-code', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($towns as $town)
                        <tr>
                            <td>{{ $town->name }}</td>
                            <td>{{ $town->constituency_id }}</td>
                            <td>{{ $town->postal_code }}</td>
                            <td>
                              <a href="{{ URL::to("town/" . $town->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> View</span></a>
                              <a href="{{ URL::to("town/" . $town->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> Edit</span></a>
                              <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> Delete</span></a>
                              <button class="btn btn-sm btn-danger delete-item-link"
                                data-toggle="modal" data-target=".confirm-delete-modal" 
                                data-id='{{ URL::to("town/" . $town->id . "/delete") }}'>
                                <span class="glyphicon glyphicon-trash"></span></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="3">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ Session::put('SOURCE_URL', URL::full()) }}
        </div>
      </div>
</div>
@stop