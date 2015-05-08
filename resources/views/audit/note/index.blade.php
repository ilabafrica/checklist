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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.note', 2) }} <span class="panel-btn">
      <a class="btn btn-sm btn-info" href="{{ URL::to("note/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ Lang::choice('messages.create-note', 1) }}
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
                <table class="table table-striped table-bordered table-hover {!! !$notes->isEmpty()?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th>{{ Lang::choice('messages.description', 1) }}</th>
                            <th>{{ Lang::choice('messages.audit-type', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                        <tr @if(session()->has('active_note'))
                                {!! (session('active_note') == $note->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $note->name }}</td>
                            <td>{!! html_entity_decode($note->description) !!}</td>
                            <td>{{ $note->auditType->name }}</td>
                            <td>
                              <a href="{{ URL::to("note/" . $note->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> View</span></a>
                              <a href="{{ URL::to("note/" . $note->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> Edit</span></a>
                              <a href="{{ URL::to("note/" . $note->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> Delete</span></a>
                             
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