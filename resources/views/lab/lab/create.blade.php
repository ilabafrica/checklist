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
                <a href="{{ url('lab') }}">{{ Lang::choice('messages.lab', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.create-lab', 1) }}</li>
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
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{Lang::choice('messages.close', 1)}}</span></button>
                {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
            </div>
            @endif
            {!! Form::open(array('route' => 'lab.store', 'id' => 'form-add-lab', 'class' => 'form-horizontal')) !!}

                <!-- lab id when a match is found-->
                <input type="hidden" name="lab_id" id="lab_id">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- ./ csrf token -->


                
                <div class="form-group">
                    {!! Form::label('name', Lang::choice('messages.lab-name', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', Input::old('name'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('lab_number', Lang::choice('messages.lab-number', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('lab_number', Input::old('lab_number'), array('class' => 'form-control', 'placeholder' => 'e.g facility MFL')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('lab_type_id', Lang::choice('messages.lab-type', 1), array('class' => 'col-sm-4 control-label')) !!}
			    <div class="col-sm-8">
                        {!! Form::select('lab_type', array(''=>trans('messages.select-lab-type'))+$labTypes->toArray(),'', 
                            array('class' => 'form-control', 'id' => 'lab_type')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('lab_level_id', Lang::choice('messages.lab-level', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('lab_level', array(''=>trans('messages.select-lab-level'))+$labLevels->toArray(),'', 
                            array('class' => 'form-control', 'id' => 'lab_level')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('lab_affiliation_id', Lang::choice('messages.lab-affiliation', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('lab_affiliation', array(''=>trans('messages.select-lab-affiliation'))+$labAffiliations->toArray(),'', 
                            array('class' => 'form-control', 'id' => 'lab_affiliation')) !!}
                    </div>
                </div>               
                <div class="form-group">
                    {!! Form::label('address', Lang::choice('messages.physical-address', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('address', Input::old('address'), array('class' => 'form-control')) !!}
                    </div>
                </div>                
                <div class="form-group">
                    {!! Form::label('postal_address', Lang::choice('messages.postal-address', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('postal_address', Input::old('postal_address'), array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('county_id', Lang::choice('messages.county', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::select('county_id', array(''=>trans('messages.select'))+$counties->toArray(),'', array('class' => 'form-control', 'id' => 'county_id')) !!}
                    </div>
                </div>               
                <div class="form-group">
                    {!! Form::label('subcounty', Lang::choice('messages.subcounty', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('subcounty', Input::old('subcounty'), array('class' => 'form-control')) !!}
                    </div>
                </div>                
                <div class="form-group">
                    {!! Form::label('telephone', Lang::choice('messages.phone', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('telephone', Input::old('telephone'), array('class' => 'form-control')) !!}
                    </div>
                </div>                
                <div class="form-group">
                    {!! Form::label('email', Lang::choice('messages.email', 1), array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!! Form::text('email', Input::old('email'), array('class' => 'form-control')) !!}
                    </div>
                </div>           
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                    {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
                          array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
                    {!! Form::button("<i class='glyphicon glyphicon-remove-circle'></i> ".Lang::choice('messages.reset', 1), 
                          array('class' => 'btn btn-default', 'onclick' => 'reset()')) !!}
                    <a href="#" class="btn btn-s-md btn-warning"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
                    </div>
                </div>
            {!! Form::close() !!} 
            <!-- End form -->
        </div>
        <div class="col-sm-6">
            <div class="panel-group" id="accordion">
                <div class="panel panel-info">
                    <div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false"><i class="fa fa-comments"></i> {{ Lang::choice('messages.help', 1) }} </a></div>
                    <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                        <div class="panel-body">
                            {!! html_entity_decode(Lang::choice('messages.create-lab-help', 1)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@stop
