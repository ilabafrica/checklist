@extends('layout')
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
        </ol>
    </div>
</div>
<!-- Begin form --> 
@if($errors->all())
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', 1) }}</span></button>
    {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
</div>
@endif
{!! Form::open(array('route' => 'review.start', 'id' => 'form-add-review', 'class' => 'form-horizontal')) !!}
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <!-- ./ csrf token -->
    <!-- Hidden field for lab -->
    {!! Form::hidden('lab_id', $lab->id, array('id' => 'lab_id')) !!}
    <!-- Hidden field for audit type -->
    {!! Form::hidden('audit_type_id', '1', array('id' => 'audit_type_id')) !!}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ Lang::choice('messages.selected-lab', 1) }}
            </div>
            <div class="panel-body">
                {!! $lab->facility->name !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ Lang::choice('messages.selected-audit', 1) }}
            </div>
            <div class="panel-body">
                {!! App\Models\AuditType::find(1)->name !!}
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-book"></i> {{ Lang::choice('messages.new-audit-in-selected-lab', 1) }} </div>
    <div class="panel-body">
    	<div class="panel-group" id="accordion">
            <div class="panel panel-info">
            	<div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false"><i class="fa fa-comments"></i> {{ Lang::choice('messages.help', 1) }} </a></div>
                <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                    <div class="panel-body">
                        <h5>Continue to create a new audit in the currently chosen lab.</h5>
                        <h5>If you want a different lab, from the menu above choose Labs-->Select a lab and find the lab, <i>or</i> Create a new lab.</h5>
                        <ol>
                            <li><strong>Choose a lab:</strong> The chosen lab is shown above</li>
                            <li><strong>Choose Audit type:</strong></li>
                            <li>Type in the actual Audit Start and End dates</li>
                            <li><strong>Click Start</strong></li>
                        </ol>
                        <p><small>All required data from the currently chosen lab is automatically added to the current audit.</small></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="btn-group btn-toggle" data-toggle="buttons" style="margin-left:15px;">
                    @foreach($auditTypes as $auditType)
                        <label class="btn btn-outline btn-default btn-lg">
                            {!! Form::radio('auditType', $auditType->id, false, array('class' => 'btn btn-outline btn-danger btn-lg', 'id' => 'auditType')) !!}<i class='fa fa-clipboard'></i> {!! $auditType->name !!}
                        </label>
                    @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8">
                    {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.start-audit', 1), 
                        array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
                    <a href="#" class="btn btn-s-md btn-warning"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
{!! Form::close() !!}
@stop
