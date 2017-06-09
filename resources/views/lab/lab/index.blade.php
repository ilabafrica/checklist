@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.lab', 1) }}</li>
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
        @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', 1) }}</span></button>
          {!! session('message') !!}
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover {!! (!$labs->isEmpty())?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th>{{ Lang::choice('messages.county', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab-level', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab-affiliation', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab-type', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labs as $lab)
                        <tr @if(session()->has('active_lab'))
                                {!! (session('active_lab') == $lab->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $lab->name }}</td>
                            @if ($lab->county)
                            <td>{{ $lab->county->name }}</td>
                            @else
                            <td> No County Selected</td>
                            @endif

                            <td>{{ $lab->labLevel->name}}</td>
                            <td>{{ $lab->labAffiliation->name }}</td>
                            <td>{{ $lab->labType->name}}</td>
                            <td>
                              <a href="{{ URL::to("lab/" . $lab->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {{Lang::choice('messages.view', 1)}}</span></a>
                              @if(Entrust::can('edit-lab'))
                              <a href="{{ URL::to("lab/" . $lab->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> {{Lang::choice('messages.edit', 1)}}</span></a>
                              @endif
                              @if(Entrust::can('manage-labs'))
                              <a href="{{ URL::to("lab/" . $lab->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> {{Lang::choice('messages.delete', 1)}}</span></a>
                              @endif
                              @if(Entrust::can('create-audit'))
                              <button class="btn btn-default btn-sm start-data-item-link" data-toggle="modal" data-target=".start-data-modal" data-lab="{{{ $lab->name }}}" data-id="{!! $lab->id !!}"><i class="fa fa-folder-open"></i><span> {!! Lang::choice('messages.start-audit', 1) !!}</span></button>
                              <!-- <a href="{{ URL::to("lab/" . $lab->id ."/select") }}" class="btn btn-default btn-sm"><i class="fa fa-folder-open"></i><span> {{Lang::choice('messages.start-audit', 1)}}</span></a> -->
                              @endif
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
        </div>
    </div>
</div>
<!-- Duplicate Modal-->
<div class="modal fade start-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        {!! Form::open(array('route' => 'review.start', 'id' => 'form-start-data', 'class' => 'form-inline', 'method' => 'POST')) !!}
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <!-- Lab -->
            <input type="hidden" name="lab_id" id="lab_id">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa fa-check-square-o"></i><span> 
                    {!! trans('messages.confirm-assessment').' for <strong id="lab"></strong>' !!}
                    </span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-10">
                        <div class="input-group" align="center">
                        <div id="radioBtn" class="btn-group">
                            @foreach($auditTypes as $audit_type)
                                <a class="btn btn-primary {{ $auditType->id == $audit_type->id?'active':'notActive'}}" data-toggle="checklist" data-title="{{{ $audit_type->id }}}" name="checklist" {{$audit_type->id != 1?'disabled':''}}>{!! $audit_type->name !!} </a>
                            @endforeach
                        </div>
                        <input type="hidden" name="checklist" id="checklist">
                    </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-start" onclick="submit()">
                    <i class="fa fa-thumbs-o-up"></i><span> {{ trans('messages.start-audit') }}</span>
                </button>
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times-circle-o"></i><span> {{ trans('messages.cancel') }}</span>
                </button>
            </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>
{!! session(['SOURCE_URL' => URL::full()]) !!}
@stop