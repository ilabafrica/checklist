@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.country', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.country', 2) }} 
        <span class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ url("country/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.create-country', 1) }}
            </a>
        </span>
        <span class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ url("country/partners") }}" >
                <i class="fa fa-camera-retro"></i><span> {!! Lang::choice('messages.partner', 2) !!}</span>
            </a>
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
                <table class="table table-striped table-bordered table-hover {!! !$countries->isEmpty()?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th>{{ Lang::choice('messages.code', 1) }}</th>
                            <th>{{ Lang::choice('messages.capital', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($countries as $country)
                        <tr @if(session()->has('active_country'))
                                {!! (session('active_country') == $country->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $country->name }}</td>
                            <td>{{ $country->code }}</td>
                            <td>{{ $country->capital }}</td>
                            <td>
                                <a href="{{ url("country/" . $country->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {!! Lang::choice('messages.view', 1) !!}</span></a>
                                <a href="{{ url("country/" . $country->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> {!! Lang::choice('messages.edit', 1) !!}</span></a>
                                <a href="{{ url("country/" . $country->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> {!! Lang::choice('messages.delete', 1) !!}</span></a>
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