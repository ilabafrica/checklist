@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li>
                <a href="{{ url('country') }}">{{ Lang::choice('messages.country', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.edit-country', 1) }}</li>
        </ol>
    </div>
</div>
@if(Session::has('message'))
<div class="alert alert-info">{{Session::get('message')}}</div>
@endif
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.edit-audit-type', '1') }}</div>
    <div class="panel-body">
        <div class="col-lg-12 main">
            <!-- Begin form --> 
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', '1') }}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            {!! Form::model($country, array('route' => array('country.update', $country->id), 'method' => 'PUT', 'id' => 'form-edit-audit-type', 'class' => 'form-horizontal')) !!}
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
                <div class="form-group">
                    {!! Form::label('name', Lang::choice('messages.name', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', $country->name, array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('code', Lang::choice('messages.code', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('code', $country->code, array('class' => 'form-control', 'rows' => '3')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('capital', Lang::choice('messages.capital', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('capital', $country->capital, array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('partners', Lang::choice('messages.partner', 2)) !!}
                    <div class="form-pane panel panel-default">
                        <div class="container-fluid">
                            <?php 
                                $cnt = 0;
                                $zebra = "";
                            ?>
                            @foreach($partners as $key=>$value)
                                {!! ($cnt%4==0)?"<div class='row $zebra'>":"" !!}
                                <?php
                                    $cnt++;
                                    $zebra = (((int)$cnt/4)%2==1?"row-striped":"");
                                ?>
                                <div class="col-md-3">
                                    <label  class="checkbox-inline">
                                        <input type="checkbox" name="partners[]" value="{{ $value->id}}" 
                                            {{ in_array($value->id, $country->partners->lists('id'))?"checked":"" }} />
                                            {{$value->name }}
                                    </label>
                                </div>
                                {{ ($cnt%4==0)?"</div>":"" }}
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
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
@stop