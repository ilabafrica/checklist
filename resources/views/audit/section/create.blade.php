@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
            </li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.create-section', '1') }}</div>
    <div class="panel-body">
        <div class="col-lg-10 main">
            <!-- Begin form --> 
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            {!! Form::open(array('route' => 'section.store', 'id' => 'form-add-section', 'class' => 'form-horizontal')) !!}
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
                    {!! Form::label('parent_id', Lang::choice('messages.parent', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('parent_id', array(''=>trans('messages.select-parent'))+$parents,'', 
                            array('class' => 'form-control', 'id' => 'parent_id')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('audit_type_id', Lang::choice('messages.audit-type', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('audit_type_id', array(''=>trans('messages.select-audit-type'))+$auditTypes,'', 
                            array('class' => 'form-control', 'id' => 'audit_type_id')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('points', Lang::choice('messages.point', 2), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('total_points', Input::old('total_points'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('order', Lang::choice('messages.order', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('order', array(''=>trans('messages.select-order'))+$parents,'', 
                            array('class' => 'form-control', 'id' => 'order')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('note', Lang::choice('messages.select-note', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php 
                                    $cnt = 0;
                                    $zebra = "";
                                ?>
                            @foreach($notes as $key=>$value)
                                {!! ($cnt%4==0)?"<div class='row $zebra'>":"" !!}
                                <?php
                                    $cnt++;
                                    $zebra = (((int)$cnt/4)%2==1?"row-striped":"");
                                ?>
                                <div class="col-md-6">
                                    <label  class="checkbox-inline">
                                        <input type="checkbox" name="notes[]" value="{{ $value->id}}" />{{ $value->name }}
                                    </label>
                                </div>
                                {!! ($cnt%4==0)?"</div>":"" !!}
                            @endforeach
                            </div>
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