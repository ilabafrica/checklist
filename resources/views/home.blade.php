@extends('layout')
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
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-book"></i> {{ Lang::choice('messages.audits-owned', 2) }} </div>
    <div class="panel-body">
        @if($message!='')
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', '1') }}</span></button>
                {!! HTML::ul($message, array('class'=>'list-unstyled')) !!}
            </div>
        @endif
    	<div class="panel-group" id="accordion">
            <div class="panel panel-info">
            	<div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false"><i class="fa fa-comments"></i> {{ Lang::choice('messages.help', 1) }} </a></div>
                <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        {!! html_entity_decode(Lang::choice('messages.home-help', 1)) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover {!! !$reviews->isEmpty()?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.response-no', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab', 1) }}</th>
                            <th>{{ Lang::choice('messages.audit', 1) }}</th>
                            <th>{{ Lang::choice('messages.date', 1) }}</th>
                            <th>{{ Lang::choice('messages.status', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->lab->name }}</td>
                            <td>{{ $review->auditType->name }}</td>
                            <td>{{ $review->created_at }}</td>
                            <td>{!! $review->status==App\Models\Review::COMPLETE?'<span class="label label-success">'.Lang::choice('messages.audit-status', 1).'</span>':'<span class="label label-warning">'.Lang::choice('messages.audit-status', 2).'</span>' !!}</td>
                            <td>
                              <a href="{{ URL::to("review/" . $review->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {{ Lang::choice('messages.view', 1) }}</span></a>
                              <a href="{{ URL::to("review/" . $review->id . "/edit") }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i><span> {{ Lang::choice('messages.edit', 1) }}</span></a>
                              <a href="{{ URL::to("review/" . $review->id . "/export") }}" class="btn btn-default btn-sm"><i class="fa fa-external-link"></i><span> {{ Lang::choice('messages.export-audit', 1) }}</span></a>
                              <a href="{{ URL::to("report/" . $review->id) }}" class="btn btn-info btn-sm"><i class="fa fa-bar-chart"></i><span> {{ Lang::choice('messages.run-reports', 1) }}</span></a>
                              <a href="{{ URL::to("review/" . $review->id . "/complete") }}" class="btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i><span> {{ Lang::choice('messages.mark-audit-complete', 1) }}</span></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="6">{{ Lang::choice('messages.no-records-found', 1) }}</td>
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
