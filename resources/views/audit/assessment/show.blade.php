@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li>
                <a href="{{ url('assessment') }}">{{ Lang::choice('messages.assessment', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.view', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.assessment', 1) }} <span class="panel-btn">
  <a class="btn btn-sm btn-info" href="{{ URL::to("assessment/" . $assessment->id . "/edit") }}" >
    <i class="fa fa-edit"></i><span> {{ Lang::choice('messages.edit-assessment', 1) }}</span>
  </a>
  </span></div>
  <div class="panel-body">
    <div class="panel panel-default">
      <div class="panel-body">
        <h4 class="no-margn view">
          <strong>{{ Lang::choice('messages.name', 1) }}:</strong> <span> {{ $assessment->name }}</span>
        </h4>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.description', 1) }}:</strong> <span> {{ $assessment->description }}</span>
        </h5>
      </div>
    </div>
  </div>
</div>
</div>
@stop