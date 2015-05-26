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
@if(Session::has('message'))
<div class="alert alert-info">{{Session::get('message')}}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.lab', 2) }} <span class="panel-btn">
      @if(Auth::user()->can('create-lab'))
      <a class="btn btn-sm btn-info" href="{{ URL::to("lab/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ trans('messages.create-lab') }}
      </a>
       @endif   
        </span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover search-table">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.facility', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab-level', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab-affiliation', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab-type', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labs as $lab)
                        <tr>
                            <td>{{ $lab->facility->name }}</td>
                            <td>{{ $lab->labLevel->name }}</td>
                            <td>{{ $lab->labAffiliation->name }}</td>
                            <td>{{ $lab->labType->name}}</td>
                            <td>
                              <a href="{{ URL::to("lab/" . $lab->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {{Lang::choice('messages.view', 1)}}</span></a>
                              <a href="{{ URL::to("lab/" . $lab->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> {{Lang::choice('messages.edit', 1)}}</span></a>
                              <a href="{{ URL::to("lab/" . $lab->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> {{Lang::choice('messages.delete', 1)}}</span></a>
                              <a href="{{ URL::to("lab/" . $lab->id ."/select") }}" class="btn btn-default btn-sm"><i class="fa fa-folder-open"></i><span> {{Lang::choice('messages.start-audit', 1)}}</span></a>
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