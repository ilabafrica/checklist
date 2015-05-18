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
                            <th>{{ Lang::choice('messages.country', 1) }}</th>
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
                            <td>{{ $lab->country->name }}</td>
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
                              <a href="{{ URL::to("lab/" . $lab->id ."/select") }}" class="btn btn-default btn-sm"><i class="fa fa-folder-open"></i><span> {{Lang::choice('messages.start-audit', 1)}}</span></a>
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
            {!! session(['SOURCE_URL' => URL::full()]) !!}
        </div>
      </div>
</div>
@stop