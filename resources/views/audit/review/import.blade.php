@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li class="active">
                <a href="#"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.import-audit', 1) }} <span class="panel-btn">
    <a class="btn btn-sm btn-info" href="" onclick="window.history.back();return false;">
        <i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span>
    </a>
    </span></div>
    <div class="panel-body">
        <div class="col-lg-6 main">
            <!-- Begin form --> 
            @if($message!='')
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', '1') }}</span></button>
                {!! HTML::ul($message, array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            {!! Form::open(array('route' => 'excel.import', 'id' => 'form-add-excel', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')) !!}
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
                <!-- Hidden fields for audit_type_id -->
                {!! Form::hidden('audit_type_id', $audit->id, array('id' => 'audit_type_id')) !!}
                <div class="form-group">
                    {!! Form::label('name', Lang::choice('messages.file-input', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::file(Lang::choice('messages.excel', 1), null, ['class' => 'form-control', 'id' => Lang::choice('messages.excel', 1)]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                    {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.upload', 1), 
                        array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
                    {!! Form::button("<i class='glyphicon glyphicon-remove-circle'></i> ".'Reset', 
                        array('class' => 'btn btn-default', 'onclick' => 'reset()')) !!}
                    <a href="#" class="btn btn-s-md btn-warning" onclick="window.history.back();return false;"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
                    </div>
                </div>
            {!! Form::close() !!} 
            <!-- End form -->
        </div>
    </div>
</div>
@stop