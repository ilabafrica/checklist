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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.authorization', '2') }}
        <span class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::to("user/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.create-user', '1') }}
            </a>
        </span> 
        <span class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::to("role/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.create-role', '1') }}
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
                {!! Form::open(array('route' => 'authorization.store', 'id' => 'form-add-authorization', 'class' => 'form-horizontal')) !!}
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.user',2) }}</th>
                            <th colspan="{{ count($roles)}}">{{ Lang::choice('messages.role',2) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            @forelse($roles as $role)
                                <td>{{$role->name}}</td>
                            @empty
                                <td>{{ trans('messages.no-roles-found')}}</td>
                            @endforelse
                        </tr>
                        @forelse($users as $userKey=>$user)
                            <tr>
                                <td>{{$user->name}}</td>
                                @forelse($roles as $roleKey=>$role)
                                <td>
                                    @if ($role == App\Models\Role::getAdminRole() && $user == App\Models\User::getAdminUser())
                                        <span class="glyphicon glyphicon-lock"></span>
                                        {!! Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name),
                                        array('style'=>'display:none')) !!}
                                    @else
                                        @if($role->id == App\Models\Role::idByName('Country Admin'))
                                            {!! Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name), array('onclick' => "country('$user->id')")) !!}
                                            @if($user->id != App\Models\User::getAdminUser()->id)
                                                <br />
                                                <div class="nchi{!! $user->id !!}" <?php if(!$user->hasRole('Country Admin')){ ?>style="display:none" <?php } ?>>
                                                    <div class="form-group">
                                                        <div class="col-sm-8">
                                                            {!! Form::select('country'.$user->id, array(''=>trans('messages.select-country'))+$countries, ($user->tier && $user->hasRole('Country Admin'))?$user->tier->tier:'', 
                                                                array('class' => 'form-control', 'id' => 'country'.$user->id)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @elseif($role->id == App\Models\Role::idByName('Partner Admin'))
                                            {!! Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name), array('onclick' => "partner('$user->id')")) !!}
                                            @if($user->id != App\Models\User::getAdminUser()->id)
                                                <br />
                                                <div class="form-group partner{!! $user->id !!}" <?php if(!$user->hasRole('Partner Admin')){ ?>style="display:none"<?php } ?>>
                                                    <div class="col-sm-8">
                                                        {!! Form::select('country_'.$user->id, array(''=>trans('messages.select-country'))+$countries, 
                                                            ($user->tier&& $user->hasRole('Partner Admin'))?App\Models\Partner::find($user->tier->tier)->country->id:'', 
                                                            array('class' => 'form-control', 'id' => 'country_'.$user->id, 'onchange' => "load('$user->id')")) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group partner{!! $user->id !!}" <?php if(!$user->hasRole('Partner Admin')){ ?>style="display:none"<?php } ?>>
                                                    <div class="col-sm-8">
                                                        {!! Form::select('partner'.$user->id, array(''=>trans('messages.select-partner'))+$partners, 
                                                            ($user->tier&& $user->hasRole('Partner Admin'))?$user->tier->tier:'', 
                                                            array('class' => 'form-control', 'id' => 'partner'.$user->id)) !!}
                                                    </div>
                                                </div>
                                            @endif
                                        @elseif($role->id == App\Models\Role::idByName('Lab In-charge'))
                                            {!! Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name), array('onclick' => "lab('$user->id')")) !!}
                                            @if($user->id != App\Models\User::getAdminUser()->id)
                                            <br />
                                            <div class="laboratory{!! $user->id !!}" <?php if(!$user->hasRole('Lab In-charge')){ ?>style="display:none" <?php } ?>>
                                                <div class="form-group">
                                                    <div class="col-sm-8">
                                                        {!! Form::select('lab'.$user->id, array(''=>trans('messages.select'))+$labs, ($user->tier && $user->hasRole('Lab In-charge'))?$user->tier->tier:'', 
                                                            array('class' => 'form-control', 'id' => 'lab'.$user->id)) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @else
                                            {!! Form::checkbox('userRoles['.$userKey.']['.$roleKey.']', '1', $user->hasRole($role->name)) !!}
                                        @endif
                                    @endif
                                </td>
                                @empty
                                    <td>[-]</td>
                                @endforelse
                            </tr>
                        @empty
                        <tr><td colspan="2">{{ trans('messages.no-users-found')}}</td></tr>
                        @endforelse 
                    </tbody>
                </table>
                <div class="form-group">
                    <div class="col-sm-offset-8">
                    {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
                          array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
                          {!! Form::button("<i class='glyphicon glyphicon-remove-circle'></i> ".'Reset', 
                          array('class' => 'btn btn-default', 'onclick' => 'reset()')) !!}
                    <a href="#" class="btn btn-s-md btn-warning"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
                    </div>
                </div>
                {!! Form::close() !!} 
            <!-- End form -->
            </div>
            
        </div>
      </div>
</div>
@stop