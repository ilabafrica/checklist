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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.audit-type', 2) }}</div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover search-table">
                <thead>
                    <tr>
                        <th>{{ Lang::choice('messages.response-no', 1) }}</th>
                        <th>{{ Lang::choice('messages.assessor', 1) }}</th>
                        <th>{{ Lang::choice('messages.date', 1) }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                        <td><a href="{{ URL::to("result") }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i><span> {{ Lang::choice('messages.view', 1) }}</span></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
</div>
@stop