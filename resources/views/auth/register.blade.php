@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">Register</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					{!! Form::open(array('route' => 'registerSave', 'id' => 'form-add-user', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'files' => 'true')) !!}
						<div class="col-lg-6 main">
			            <!-- Begin form --> 
			           
			                <!-- CSRF Token -->
			                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
			                <!-- ./ csrf token -->
			                <div class="form-group">
			                    {!! Form::label('name', Lang::choice('messages.name', 1), array('class' => 'col-sm-4 control-label')) !!}
			                    <div class="col-sm-8">
			                        {!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
			                    </div>
			                </div>
			                <div class="form-group">
			                    {!! Form::label('gender', Lang::choice('messages.gender', 1), array('class' => 'col-sm-4 control-label')) !!}
			                    <div class="col-sm-8">
			                        <label class="radio-inline">{!! Form::radio('gender', App\Models\User::MALE, true) !!}{{ Lang::choice('messages.sex', 1) }}</label>
			                        <label class="radio-inline">{!! Form::radio("gender", App\Models\User::FEMALE, false) !!}{{ Lang::choice('messages.sex', 2) }}</label>
			                    </div>
			                </div>
			                <div class="form-group">
			                    {!! Form::label('email', Lang::choice('messages.email', 1), array('class' => 'col-sm-4 control-label')) !!}
			                    <div class="col-sm-8">
			                        {!! Form::text('email', Input::old('email'), array('class' => 'form-control')) !!}
			                    </div>
			                </div>
			                <div class="form-group">
			                    {!! Form::label('phone', Lang::choice('messages.phone', 1), array('class' => 'col-sm-4 control-label')) !!}
			                    <div class="col-sm-8">
			                        {!! Form::text('phone', Input::old('phone'), array('class' => 'form-control')) !!}
			                    </div>
			                </div>
			                <div class="form-group">
			                    {!! Form::label('address', Lang::choice('messages.address', 1), array('class' => 'col-sm-4 control-label')) !!}
			                    <div class="col-sm-8">
			                        {!! Form::textarea('address', Input::old('description'), 
			                            array('class' => 'form-control', 'rows' => '3')) !!}
			                    </div>
			                </div>
			                <div class="form-group">
			                    {!! Form::label('username', Lang::choice('messages.username', 1), array('class' => 'col-sm-4 control-label')) !!}
			                    <div class="col-sm-8">
			                        {!! Form::text('username', Input::old('username'), array('class' => 'form-control')) !!}
			                    </div>
			                </div>
		                  	<div class="col-md-8 ">
				                <div class="form-group">
				                    {!! Form::label('user_role', Lang::choice('messages.role', 1), array('class' => 'col-sm-4 control-label')) !!}
				                    <div class="col-sm-8">
				                        {!! Form::select('user_role', array(''=>trans('messages.select'))+$roles,'', array('class' => 'form-control', 'id' => 'user_role')) !!}
				                    </div>
				                </div> 
				            </div>
			               <!--  <div class="form-group">
			                    <div class="col-sm-offset-4 col-sm-8">
			                        <label class="checkbox-inline">
			                            {!! Form::checkbox("default_password", '1', '', array('onclick' => 'toggle(".pword", this)')) !!}{{ Lang::choice('messages.use-default-password', 1) }}
			                        </label>
			                    </div>
			                </div> -->
			               <!--  <div class="pword">
				                <div class="form-group">
				                    {!! Form::label('password', Lang::choice('messages.password', 1), array('class' => 'col-sm-4 control-label')) !!}
				                    <div class="col-sm-8">
				                        {!! Form::password('password', array('class' => 'form-control')) !!}
				                    </div>
				                </div>
				                <div class="form-group">
				                    {!! Form::label('password_confirmation', Lang::choice('messages.password', 2), array('class' => 'col-sm-4 control-label')) !!}
				                    <div class="col-sm-8">
				                        {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
				                    </div>
				                </div>
			                </div> -->
			                <div class="form-group">
			                    <div class="col-sm-offset-4 col-sm-8">
			                    {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
			                          array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
			                          {!! Form::button("<i class='glyphicon glyphicon-remove-circle'></i> ".'Reset', 
			                          array('class' => 'btn btn-default', 'onclick' => 'reset()')) !!}
			                    <a href="#" class="btn btn-s-md btn-warning"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
			                    </div>
			                </div>
					        </div>
					        <div class="col-md-6">
					        <div class="row">	
					            </div>
					            <div class="row">
					                <div class="col-md-8 col-sm-offset-3">
					                    <div class="thumbnail">
					                        {!! HTML::image('images/profiles/default.png', Lang::choice('messages.no-photo-available', 1), array('class'=>'img-responsive img-thumbnail user-image')) !!}
					                    </div>
					                </div>
					                <div class="col-md-8 col-sm-offset-1">
					                    <div class="form-group">
					                        <label>{{ Lang::choice('messages.profile-photo', 1) }}</label>
					                        {!! Form::file(Lang::choice('messages.photo', 1), null, ['class' => 'form-control']) !!}
					                    </div>
					                </div>
					            </div>
					        </div>
        {!! Form::close() !!} 
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
