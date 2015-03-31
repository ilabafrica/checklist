@extends("layout")
@section("content")
<br /><br /><br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}
            </li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.create-lab', '1') }}</div>
    <div class="panel-body">
        <div class="col-lg-6 main">
            <!-- Begin form --> 
            @if($errors->all())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            {!! Form::model($lab, array('route' => array('lab.update', $lab->id), 
        'method' => 'PUT', 'id' => 'form-edit-lab', 'class' => 'form-horizontal')) !!}
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->
                <div class="form-group">
                    {!! Form::label('facility_id', Lang::choice('messages.facility', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('facility_id', array(''=>trans('messages.select-facility'))+$facilities,
                            old('facility') ? old('facility') : $facility, 
                            array('class' => 'form-control', 'id' => 'facility_id')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('lab_level_id', Lang::choice('messages.lab-level', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('lab_level_id', array(''=>trans('messages.select-lab-level'))+$labLevels,
                            old('labLevel') ? old('labLevel') : $labLevel, 
                            array('class' => 'form-control', 'id' => 'lab_level_id')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('lab_affiliation_id', Lang::choice('messages.lab-level', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('lab_affiliation_id', array(''=>trans('messages.select-lab-affiliation'))+$labAffiliations,
                            old('labAffiliation') ? old('labAffiliation') : $labAffiliation, 
                            array('class' => 'form-control', 'id' => 'lab_affiliation_id')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('lab_type_id', Lang::choice('messages.lab-level', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('lab_type_id', array(''=>trans('messages.select-lab-type'))+$labTypes,
                            old('labType') ? old('labType') : $labType, 
                            array('class' => 'form-control', 'id' => 'lab_type_id')) !!}
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