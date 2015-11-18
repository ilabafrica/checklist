@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.audit', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.audit', 2) }}
        <span class="panel-btn">
        @if(Auth::user()->can('create-audit'))
         <a class="btn btn-sm btn-info" href="{{ url("lab") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.create-audit', 1) }}
         </a>
        @endif  

        </span>
    </div>

    <div class="panel-body">
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', 1) }}</span></button>
          {!! session('message') !!}
        </div>
        @endif
        <div class="panel-group" id="accordion">
            @forelse($audits as $audit)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <strong><a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$audit->id}}" aria-expanded="false" class="collapsed">{{ $audit->name }}</a></strong>
                    </h5>
                </div>
                <div id="collapse{{$audit->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover no-footer">
                            <tbody>
                                <tr>
                                    <td>{{ Lang::choice('messages.no-of-labs', 1) }}</td><td>{!! $audit->reviews->count() !!}</td>
                                </tr>
                                <tr>
                                    <td>{{ Lang::choice('messages.no-of-assessors', 1) }}</td><td>{!! $audit->reviews->groupBy('user_id')->count() !!}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>
                            <a href="{{ url('lab')}}"class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i><span> {{ Lang::choice('messages.new-audit', 1) }}</span></a>
                            <a href="{{ url('review/assessment/'.$audit->id) }}" class="btn btn-default"><i class="fa fa-book"></i><span> {{ Lang::choice('messages.view-audit-data', 1) }}</span></a>
                            <a href="{{ url('review/summary/'.$audit->id) }}" class="btn btn-success"><i class="fa fa-database"></i><span> {{ Lang::choice('messages.view-summary', 1) }}</span></a>
                        </p>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
@stop