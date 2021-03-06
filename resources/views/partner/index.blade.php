@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.partner', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.partner', 2) }} <span class="panel-btn">
      <a class="btn btn-sm btn-info" href="{{ url("partner/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ Lang::choice('messages.create-partner', 1) }}
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
                <table class="table table-striped table-bordered table-hover {!! !$partners->isEmpty()?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th>{{ Lang::choice('messages.head', 1) }}</th>
                            <th>{{ Lang::choice('messages.address', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $partner)
                        <tr @if(session()->has('active_partner'))
                                {!! (session('active_partner') == $partner->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $partner->name }}</td>
                            <td>{{ $partner->head }}</td>
                            <td>{{ $partner->contact }}</td>
                            <td>
                                <a href="{{ url("partner/" . $partner->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {!! Lang::choice('messages.view', 1) !!}</span></a>
                                <a href="{{ url("partner/" . $partner->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> {!! Lang::choice('messages.edit', 1) !!}</span></a>
                                <a href="{{ url("partner/" . $partner->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> {!! Lang::choice('messages.delete', 1) !!}</span></a>
                                <a href="{{ url("partner/" . $partner->id . "/labs") }}" class="btn btn-primary btn-sm"><i class="fa fa-trash-o"></i><span> {!! Lang::choice('messages.lab', 1) !!}</span></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4">{{ Lang::choice('messages.no-records-found', 1) }}</td>
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