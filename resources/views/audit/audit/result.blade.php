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
    <div class="panel-heading">
        <i class="fa fa-tags"></i> {{ Lang::choice('messages.audit-type', 2) }}
        <span class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::to("auditType/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.back', 1) }}
            </a>
        </span>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover search-table">
                <thead>
                    <tr>
                        <th>{{ Lang::choice('messages.no', 1) }}</th>
                        <th>{{ Lang::choice('messages.question', 1) }}</th>
                        <th>{{ Lang::choice('messages.response', 1) }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                        <td><a href="{{ URL::to("response") }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i><span> {{ Lang::choice('messages.view', 1) }}</span></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
</div>
@stop