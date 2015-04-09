@extends('layout')
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
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Selected Lab
            </div>
            <div class="panel-body">
                {!! $lab->facility->name !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Selected Audit
            </div>
            <div class="panel-body">
                Panel Footer
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
            <div class="col-sm-12">
            @foreach($auditTypes as $auditType)
                <a href="{{ url('/audit/'.$lab->id.'/'.$auditType->id.'/'.$auditType->auditFieldGroup->first()['id']) }}" class="btn btn-outline btn-primary btn-lg">{!! $auditType->name !!}</a>
            @endforeach
            </div>
            {{ Session::put('SOURCE_URL', URL::full()) }}
        </div>
      </div>
</div>
@stop
