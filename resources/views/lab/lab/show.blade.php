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
  <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.lab', 1) }} <span class="panel-btn">
  @if(Auth::user()->can('edit-lab'))
  <a class="btn btn-sm btn-info" href="{{ URL::to("lab/" . $lab->id . "/edit") }}" >
    <i class="fa fa-edit"></i><span>{{ Lang::choice('messages.edit-lab', 1) }}</span>
  </a>
  @endif
  </span></div>
  <div class="panel-body">
    <div class="panel panel-default">
      <div class="panel-body">
        <h4 class="no-margn view">
          <strong>{{ Lang::choice('messages.facility', 1) }}:</strong> <span> {{ $lab->facility->name }}</span>
        </h4>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.lab-level', 1) }}:</strong> <span> {{ $lab->labLevel->name }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.lab-affiliation', 1) }}:</strong> <span> {{ $lab->labAffiliation->name }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.lab-type', 1) }}:</strong> <span> {{ $lab->labType->name }}</span>
        </h5>
      </div>
  </div>
</div>
@stop