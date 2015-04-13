@extends("layout")
@section("content")
<br />
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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.response', 2) }}</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover search-table">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.response-no', 1) }}</th>
                            <th>{{ Lang::choice('messages.assessor', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab', 1) }}</th>
                            <th>{{ Lang::choice('messages.audit', 1) }}</th>
                            <th>{{ Lang::choice('messages.date', 1) }}</th>
                            <th>{{ Lang::choice('messages.status', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($responses as $response)
                        <tr>
                            <td>{{ $response->id }}</td>
                            <td>{{ $response->user->name }}</td>
                            <td>{{ $response->lab->facility->name }}</td>
                            <td>{{ $response->auditType->name }}</td>
                            <td>{{ $response->created_at }}</td>
                            <td>{{ $response->status==App\Models\AuditResponse::COMPLETE?Lang::choice('messages.audit-status', 1):Lang::choice('messages.audit-status', 2) }}</td>
                            <td>
                              <a href="{{ URL::to("response/" . $response->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {{ Lang::choice('messages.view', 1) }}</span></a>
                              <a href="{{ URL::to("response/" . $response->id . "/edit") }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i><span> {{ Lang::choice('messages.edit', 1) }}</span></a>
                              <a href="{{ URL::to("response/" . $response->id . "/edit") }}" class="btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i><span> {{ Lang::choice('messages.mark-audit-complete', 1) }}</span></a>
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