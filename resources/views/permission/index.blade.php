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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.permission', '2') }} <span class="panel-btn">
      <!-- <a class="btn btn-sm btn-info" href="{{ URL::to("permission/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
          {{ Lang::choice('messages.create-permission', '1') }}
          </a>-->
        </span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', '1') }}</th>
                            <th>{{ Lang::choice('messages.description', '1') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td>
                              <a href="{{ URL::to("permission/" . $permission->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> View</span></a>
                              <a href="{{ URL::to("permission/" . $permission->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> Edit</span></a>
                            <!-- <a href="{{URL::to("permission/" . $permission->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> Delete</span></a>-->
                              
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="3">No records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
      </div>
</div>
@stop