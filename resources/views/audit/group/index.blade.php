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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.audit-field-group', 2) }} <span class="panel-btn">
      <a class="btn btn-sm btn-info" href="{{ URL::to("auditFieldGroup/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ Lang::choice('messages.create-audit-field-group', 1) }}
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
                            <th>{{ Lang::choice('messages.description', 1) }}</th>
                            <th>{{ Lang::choice('messages.parent', 1) }}</th>
                            <th>{{ Lang::choice('messages.audit-type', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditFieldGroups as $auditFieldGroup)
                        <tr>
                            <td>{{ $auditFieldGroup->name }}</td>
                            <td>{{ $auditFieldGroup->description }}</td>
                            <td>{{ $auditFieldGroup->parent_id }}</td>
                            <td>{{ $auditFieldGroup->auditType->name }}</td>
                            <td>
                              <a href="{{ URL::to("auditFieldGroup/" . $auditFieldGroup->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> View</span></a>
                              <a href="{{ URL::to("auditFieldGroup/" . $auditFieldGroup->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> Edit</span></a>
                              <a href="{{ URL::to("auditFieldGroup/" . $auditFieldGroup->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> Delete</span></a>
                              
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="5">{{ Lang::choice('messages.no-records-found', 1) }}</td>
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