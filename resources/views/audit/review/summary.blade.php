@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li>
                <a href="{{ url('review') }}">{{ Lang::choice('messages.audit', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.summary', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.response', 1) }} <span class="panel-btn">
    <a class="btn btn-sm btn-info" href="" onclick="window.history.back();return false;">
        <i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span>
    </a>
    <a class="btn btn-sm btn-info" href="{{ URL::to('review/summary/'.$audit->id.'/export') }}" >
        <i class="fa fa-hdd-o"></i><span> {{ Lang::choice('messages.download-summary', 1) }}</span>
    </a>
    </span></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
            <!---------------------------------------------BEGINNING  OF QUESTIONS------------------------------------------------------------ -->
                <table class="table table-striped table-bordered table-hover search-table">
                    <thead>
                        <tr>
                            <th>{!! Lang::choice('messages.count', 1) !!}</th>
                            <th>{!! Lang::choice('messages.user', 1) !!}</th>
                            <th>{!! Lang::choice('messages.total-audits', 1) !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                        <tr>
                            <td>{!! $user->id !!}</td>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->reviews->count() !!}</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            <!---------------------------------------------END OF QUESTIONS------------------------------------------------------------ -->
            </div>
        </div>
    </div>
</div>
@stop