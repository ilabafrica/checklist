@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.user', 1) }}</li>
        </ol>
    </div>
</div>
@if(Session::has('message'))
<div class="alert alert-info">{{Session::get('message')}}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.user', 2) }} <span class="panel-btn">
        @if(Auth::user()->can('create-user'))
      <a class="btn btn-sm btn-info" href="{{ URL::to("user/create") }}" >
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ trans('messages.create-user') }}
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
                <table class="table table-striped table-bordered table-hover {!! !$users->isEmpty()?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th>{{ Lang::choice('messages.username', 1) }}</th>
                            <th>{{ Lang::choice('messages.email', 1) }}</th>
                            <th>{{ Lang::choice('messages.phone', 1) }}</th>
                            <th>{{ Lang::choice('messages.address', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr @if(session()->has('active_user'))
                                {!! (session('active_user') == $user->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                              <a class="btn btn-success btn-sm {{($user->deleted_at == null) ? '': 'disabled'}}"  href="{{ URL::to("user/" . $user->id) }}"><i class="fa fa-eye"></i><span> View</span></a>

                              <a class="btn btn-info btn-sm {{($user->deleted_at == null) ? '': 'disabled'}}" href="{{ URL::to("user/" . $user->id . "/edit") }}" ><i class="fa fa-edit"></i><span> Edit</span></a>

                              @if($user->deleted_at == null)
                              <button class="btn btn-danger btn-sm" data-toggle="modal" data-target=".confirm-delete-modal" 
                              data-id='{{ URL::to("user/" . $user->id . "/delete") }}'><i class="fa fa-times"></i><span> Disable</span></button>

                              @else
                              <a class="btn btn-success btn-sm" href="{{ URL::to("user/" . $user->id . "/enable") }}" ><i class="fa fa-check"></i><span> Enable</span></a>
                              @endif
                              <button class="btn btn-warning btn-sm {{($user->deleted_at == null) ? '': 'disabled'}}" data-toggle="modal" data-target=".confirm-reset-password-modal" data-id='{{ URL::to("user/" . $user->id . "/reset_password") }}'><i class="fa fa-unlock"></i><span> Reset Password</span></button>

                              <a class="btn btn-info btn-sm {{($user->deleted_at == null) ? '': 'disabled'}}" href="{{ URL::to("authorization") }}" ><i class="fa fa-user"></i><span> Change Role</span></a>
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
<div class="modal fade confirm-delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;</button>
                    <h4 class="modal-title" id="myModalLabel">
                        <span class="glyphicon glyphicon-trash"></span> 
                        {{ trans('messages.confirm-disable-title') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('messages.confirm-disable-message') }}</p>
                    <input type="hidden" id="delete-url" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-delete">
                        Disable</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{ trans('messages.cancel') }}</button>
                </div>
            </div>
        </div>
</div>
<div class="modal fade confirm-reset-password-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;</button>
                    <h4 class="modal-title" id="myModalLabel">
                        <span class="glyphicon glyphicon-trash"></span> 
                        {{ trans('messages.confirm-reset-title') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>{{ trans('messages.confirm-reset-message') }}</p>
                    <p>{{ trans('messages.confirm-disable-irreversible') }}</p>
                    <input type="hidden" id="reset-password-url" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-reset-password">
                        Reset Password</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{ trans('messages.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop