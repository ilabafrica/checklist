@extends("layout")
@section("content")
<br /><br /><br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', '1') }}
            </li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.edit-audit-field', '1') }}</div>
    <div class="panel-body">
        <div class="col-lg-8 main">
            <!-- Begin form --> 
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            {!! Form::model($auditField, array('route' => array('auditField.update', $auditField->id), 
        'method' => 'PUT', 'id' => 'form-edit-audit-type', 'class' => 'form-horizontal')) !!}
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
                <div class="form-group">
                    {!! Form::label('field-type', Lang::choice('messages.field-type', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('field_type', array(''=>trans('messages.select-field-type'))+$fieldTypes,
                            old('fieldType') ? old('fieldType') : $fieldType, 
                            array('class' => 'form-control', 'id' => 'field_type')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('name', Lang::choice('messages.name', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('label', Lang::choice('messages.label', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('label', Input::old('label'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('name', Lang::choice('messages.description', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('description', Input::old('description'), 
                            array('class' => 'form-control', 'rows' => '3')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('comment', Lang::choice('messages.comment', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('comment', Input::old('comment'), 
                            array('class' => 'form-control', 'rows' => '3')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('options', Lang::choice('messages.option', 2), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('options', Input::old('options'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('parent_id', Lang::choice('messages.parent', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('parent_id', array(''=>trans('messages.select-parent'))+$parents,
                            old('parent') ? old('parent') : $parent, 
                            array('class' => 'form-control', 'id' => 'parent_id')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('audit_field_group_id', Lang::choice('messages.audit-field-group', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('audit_field_group_id', array(''=>trans('messages.select-audit-field-group'))+$auditFieldGroups,
                            old('auditFieldGroup') ? old('auditFieldGroup') : $auditFieldGroup, 
                            array('class' => 'form-control', 'id' => 'audit_field_group_id')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('score', Lang::choice('messages.score', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('score', Input::old('score'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('iso', Lang::choice('messages.iso', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('iso', Input::old('iso'), 
                            array('class' => 'form-control', 'rows' => '3')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <label class="checkbox-inline">
                            {!! Form::checkbox("required", '1', '') !!}{{ Lang::choice('messages.required', 1) }}
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <label class="checkbox-inline">
                            {!! Form::checkbox("textarea", '1', '') !!}{{ Lang::choice('messages.text-area', 1) }}
                        </label>
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