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
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.facility-type', 1) }}:</strong> <span> {{ $lab->facility->facilityType->name}}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.facility-owner', 1) }}:</strong> <span> {{ $lab->facility->facilityOwner->name }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.address', 1) }}:</strong> <span> {{ $lab->facility->address }}</span>
        </h5>
        <hr>
         <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.nearest-town', 1) }}:</strong> <span> {{ $lab->facility->nearest_town }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.constituency', 1) }}:</strong> <span> {{ $lab->facility->constituency->name }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.landline', 1) }}:</strong> <span> {{ $lab->facility->landline }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.mobile', 1) }}:</strong> <span> {{ $lab->facility->mobile }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.email', 1) }}:</strong> <span> {{ $lab->facility->email }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.in-charge', 1) }}:</strong> <span> {{ $lab->facility->in_charge }}</span>
        </h5>
        <hr>
        <h5 class="no-margn">
          <strong>{{ Lang::choice('messages.operational-status', 1) }}:</strong> <span> {{ $lab->facility->operational_status== App\Models\Facility::OPERATIONAL? Lang::choice('messages.yes', 1):Lang::choice('messages.no', 1) }}</span>
        </h5>
      </div>
  </div>
</div>
</div>
@stop