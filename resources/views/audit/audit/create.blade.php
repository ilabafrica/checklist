@extends("layout")
@section("content")
<br /><br /><br />
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.create-audit', '1') }}</div>
            <div class="panel-body">
                @if($errors->all())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
                </div>
                @endif
                @if($auditFieldGroup->id == 1)
                    <img src="{{ Config::get('slipta.slipta-logo') }}" alt="" height="150px" width="" class="img-responsive center-block">
                    <h1 align="center">{{ Config::get('slipta.slipta') }}</h1>
                    <h2 align="center">{{ Config::get('slipta.slipta-brief') }}</h2>
                @endif
                {!! Form::open(array('route' => 'audit.store', 'id' => 'form-add-audit-field', 'class' => 'form-horizontal')) !!}
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <!-- ./ csrf token -->
                    <!-- Content goes here -->
                    <!-- Begin Fields logic -->
                    <!-- Check if fieldgroup has children -->
                    @if(count($auditFieldGroup->children)>0)
                        @foreach($auditFieldGroup->children as $kids)
                            <!-- Check if children spawn children too -->
                            @if(count($kids->children)>0)
                                @foreach($kids->auditField as $kid)
                                    <!-- Check if kids spawn grand-children -->
                                    @if(count($kid->children)>0)
                                        @foreach($kid->auditField as $grand)
                                            @if($grand->field_type==App\Models\AuditField::HEADING)
                                            <h4>{{ $grand->label }}</h4>
                                            @elseif($grand->field_type==App\Models\AuditField::TEXT)
                                            {!! html_entity_decode($grand->description) !!}
                                            @elseif($grand->field_type==App\Models\AuditField::LABEL)
                                            {{ $grand->label }}
                                            @elseif($grand->field_type==App\Models\AuditField::SUBHEADING)
                                            {{ $grand->label }}
                                            @elseif($grand->field_type==App\Models\AuditField::INSTRUCTION)
                                            <pre>{{ $grand->description }}</pre>
                                            @elseif($grand->field_type==App\Models\AuditField::QUESTION)
                                            <div class="form-group">
                                                {!! Form::label($grand->name, $grand->label, array('class' => 'col-sm-4 control-label')) !!}
                                                <div class="col-sm-8">
                                                    {!! Form::text($grand->name, Input::old($grand->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                                </div>
                                            </div>
                                            @elseif($grand->field_type==App\Models\AuditField::TEXTAREA)
                                            <div class="form-group">
                                                {!! Form::label($grand->name, $grand->label, array('class' => 'col-sm-4 control-label')) !!}
                                                <div class="col-sm-8">
                                                    {!! Form::textarea($grand->name, Input::old($grand->name), 
                                                        array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                            @elseif($grand->field_type==App\Models\AuditField::DATE)
                                            <div class="form-group">
                                                {!! Form::label($grand->name, $grand->label, array('class' => 'col-sm-4 control-label')) !!}
                                                <div class="col-sm-3 form-group input-group date" id="date" style="padding-left:15px;">
                                                    {!! Form::text($grand->name, Input::old($grand->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                </div>
                                            </div>
                                            @elseif($grand->field_type==App\Models\AuditField::SELECT)
                                            <div class="form-group">
                                                {!! Form::label($grand->name, $grand->label, array('class' => 'col-sm-4 control-label')) !!}
                                                <div class="col-sm-8">
                                                    {!! Form::select($grand->name, array(''=>trans('messages.please-select'))+explode(',',$grand->options),'', 
                                                        array('class' => 'form-control', 'id' => $grand->name, 'style'=>'width:auto')) !!}
                                                </div>
                                            </div>
                                            @elseif($grand->field_type==App\Models\AuditField::CHOICE)
                                                @if($grand->textarea==App\Models\AuditField::TXTAREA)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        {{ $grand->label }}
                                                        @if($grand->iso!=NULL)
                                                        <br /><i><small><strong>{{ $grand->iso }}</strong></small></i>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-6">
                                                            @foreach(explode(',',$grand->options) as $option)
                                                                <label class="radio-inline">{!! Form::radio($grand->name, $option, '') !!}{{ $option }}</label>
                                                            @endforeach
                                                            <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                                            <br /><br />
                                                            <div class="col-sm-12">
                                                                {!! Form::textarea($grand->name, Input::old($grand->name), 
                                                                array('class' => 'form-control', 'rows' => '3')) !!}
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                @else
                                                <div class="form-group">
                                                    {!! Form::label($grand->name, $grand->label, array('class' => 'col-sm-4 control-label')) !!}
                                                    <div class="col-sm-8">
                                                        @foreach(explode(',',$grand->options) as $option)
                                                            <label class="radio-inline">{!! Form::radio($grand->name, $option, '') !!}{{ $option }}</label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            @elseif($grand->field_type==App\Models\AuditField::CHECKBOX)
                                            <div class="form-group">
                                                {!! Form::label($grand->name, $grand->label, array('class' => 'col-sm-4 control-label')) !!}
                                                <div class="col-sm-8">
                                                    @foreach(explode(',',$grand->options) as $option)
                                                        <label class="checkbox-inline">{!! Form::checkbox($grand->name, $option, '') !!}{{ $option }}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @elseif($grand->field_type == App\Models\AuditField::MAINQUESTION)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><u>{{ $grand->label }}</u></p>
                                                    <p>{{ $grand->description }}</p>
                                                    <p><i><small>{{ $grand->iso }}</small></i></p>
                                                </div>
                                                <div class="col-md-6">
                                                    @if($grand->options!=NULL)
                                                    <div class="form-group">
                                                        <div class="col-sm-8">
                                                        @foreach(explode(',',$grand->options) as $option)
                                                            <label class="radio-inline">{!! Form::radio($grand->name, $option, '') !!}{{ $option }}</label>
                                                        @endforeach
                                                        <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            {!! Form::text($grand->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                                        </div>
                                                        /{{ $grand->score }}
                                                        <br /><br />
                                                        <div class="col-sm-12">
                                                            {!! Form::textarea($grand->name, Input::old($grand->name), 
                                                            array('class' => 'form-control', 'rows' => '3')) !!}
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="form-group">
                                                        <div class="col-sm-4">
                                                            {!! Form::text($grand->name, 'N', array('class' => 'form-control', 'disabled')) !!}
                                                        </div>
                                                        <div class="col-sm-4">
                                                            {!! Form::text($grand->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                                        </div>
                                                        /{{ $grand->score }}
                                                        <br /><br />
                                                        <div class="col-sm-12">
                                                            {!! Form::textarea($grand->name, Input::old($grand->name), 
                                                            array('class' => 'form-control', 'rows' => '3')) !!}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @elseif($grand->field_type == App\Models\AuditField::SUBQUESTION)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>{{ $grand->description }}</p>
                                                    <p><i><small>{{ $grand->iso }}</small></i></p>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        {{ $grand->score }}
                                                        <br /><br />
                                                        <div class="col-sm-12">
                                                            {!! Form::textarea($grand->name, Input::old($grand->name), 
                                                            array('class' => 'form-control', 'rows' => '3')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @elseif($grand->field_type == App\Models\AuditField::STANDARD)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {!! html_entity_decode($grand->description) !!}
                                                </div>
                                            </div>
                                            @elseif($grand->field_type == App\Models\AuditField::SUBINSTRUCTION)
                                            <div class="row">
                                                <div class="col-md-8">
                                                    {{ $grand->description }}
                                                </div>
                                                <div class="col-md-4" style="text-align:center;">
                                                    @if($grand->options!=NULL)
                                                    {!! html_entity_decode($grand->label."<br />(".$grand->options.")") !!}
                                                    @else
                                                    {!! html_entity_decode($grand->label) !!}
                                                    @endif
                                                </div>
                                            </div>
                                            @elseif($grand->field_type == App\Models\AuditField::MAININSTRUCTION)
                                            <div class="row">
                                                <div class="col-md-8">
                                                    {{ $grand->description }}
                                                </div>
                                                <div class="col-md-4" style="text-align:center;">
                                                    @if($grand->options!=NULL)
                                                    {!! html_entity_decode($grand->label."<br />(".$grand->options.")") !!}
                                                    @else
                                                    {!! html_entity_decode($grand->label) !!}
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    <!-- Display as is -->
                                    @else
                                        @if($kid->field_type==App\Models\AuditField::HEADING)
                                        <h4>{{ $kid->label }}</h4>
                                        @elseif($kid->field_type==App\Models\AuditField::TEXT)
                                        {!! html_entity_decode($kid->description) !!}
                                        @elseif($kid->field_type==App\Models\AuditField::LABEL)
                                        {{ $kid->label }}
                                        @elseif($kid->field_type==App\Models\AuditField::SUBHEADING)
                                        {{ $kid->label }}
                                        @elseif($kid->field_type==App\Models\AuditField::INSTRUCTION)
                                        <pre>{{ $kid->description }}</pre>
                                        @elseif($kid->field_type==App\Models\AuditField::QUESTION)
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                            </div>
                                        </div>
                                        @elseif($kid->field_type==App\Models\AuditField::TEXTAREA)
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                    array('class' => 'form-control', 'rows' => '3')) !!}
                                            </div>
                                        </div>
                                        @elseif($kid->field_type==App\Models\AuditField::DATE)
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-3 form-group input-group date" id="date" style="padding-left:15px;">
                                                {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                        @elseif($kid->field_type==App\Models\AuditField::SELECT)
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::select($kid->name, array(''=>trans('messages.please-select'))+explode(',',$kid->options),'', 
                                                    array('class' => 'form-control', 'id' => $kid->name, 'style'=>'width:auto')) !!}
                                            </div>
                                        </div>
                                        @elseif($kid->field_type==App\Models\AuditField::CHOICE)
                                            @if($kid->textarea==App\Models\AuditField::TXTAREA)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{ $kid->label }}
                                                    @if($kid->iso!=NULL)
                                                    <br /><i><small><strong>{{ $kid->iso }}</strong></small></i>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        @foreach(explode(',',$kid->options) as $option)
                                                            <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                                        @endforeach
                                                        <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                                        <br /><br />
                                                        <div class="col-sm-12">
                                                            {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                            array('class' => 'form-control', 'rows' => '3')) !!}
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            @else
                                            <div class="form-group">
                                                {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                                <div class="col-sm-8">
                                                    @foreach(explode(',',$kid->options) as $option)
                                                        <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        @elseif($kid->field_type==App\Models\AuditField::CHECKBOX)
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                @foreach(explode(',',$kid->options) as $option)
                                                    <label class="checkbox-inline">{!! Form::checkbox($option, $option, '') !!}{{ $option }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @elseif($kid->field_type == App\Models\AuditField::MAINQUESTION)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><u>{{ $kid->label }}</u></p>
                                                <p>{{ $kid->description }}</p>
                                                <p><i><small>{{ $kid->iso }}</small></i></p>
                                            </div>
                                            <div class="col-md-6">
                                                @if($kid->options!=NULL)
                                                <div class="form-group">
                                                    <div class="col-sm-8">
                                                    @foreach(explode(',',$kid->options) as $option)
                                                        <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                                    @endforeach
                                                    <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        {!! Form::text($kid->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                                    </div>
                                                    /{{ $kid->score }}
                                                    <br /><br />
                                                    <div class="col-sm-12">
                                                        {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                        array('class' => 'form-control', 'rows' => '3')) !!}
                                                    </div>
                                                </div>
                                                @else
                                                <div class="form-group">
                                                    <div class="col-sm-4">
                                                        {!! Form::text($kid->name, 'N', array('class' => 'form-control', 'disabled')) !!}
                                                    </div>
                                                    <div class="col-sm-4">
                                                        {!! Form::text($kid->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                                    </div>
                                                    /{{ $kid->score }}
                                                    <br /><br />
                                                    <div class="col-sm-12">
                                                        {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                        array('class' => 'form-control', 'rows' => '3')) !!}
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @elseif($kid->field_type == App\Models\AuditField::SUBQUESTION)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>{{ $kid->description }}</p>
                                                <p><i><small>{{ $kid->iso }}</small></i></p>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    {{ $kid->score }}
                                                    <br /><br />
                                                    <div class="col-sm-12">
                                                        {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                        array('class' => 'form-control', 'rows' => '3')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @elseif($kid->field_type == App\Models\AuditField::STANDARD)
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! html_entity_decode($kid->description) !!}
                                            </div>
                                        </div>
                                        @elseif($kid->field_type == App\Models\AuditField::SUBINSTRUCTION)
                                        <div class="row">
                                            <div class="col-md-8">
                                                {{ $kid->description }}
                                            </div>
                                            <div class="col-md-4" style="text-align:center;">
                                                @if($kid->options!=NULL)
                                                {!! html_entity_decode($kid->label."<br />(".$kid->options.")") !!}
                                                @else
                                                {!! html_entity_decode($kid->label) !!}
                                                @endif
                                            </div>
                                        </div>
                                        @elseif($kid->field_type == App\Models\AuditField::MAININSTRUCTION)
                                        <div class="row">
                                            <div class="col-md-8">
                                                {{ $kid->description }}
                                            </div>
                                            <div class="col-md-4" style="text-align:center;">
                                                @if($kid->options!=NULL)
                                                {!! html_entity_decode($kid->label."<br />(".$kid->options.")") !!}
                                                @else
                                                {!! html_entity_decode($kid->label) !!}
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                @endforeach
                            <!-- Display as is if not -->
                            @else
                                @foreach($kids->auditField as $kid)
                                    @if($kid->field_type==App\Models\AuditField::HEADING)
                                    <h4>{{ $kid->label }}</h4>
                                    @elseif($kid->field_type==App\Models\AuditField::TEXT)
                                    {!! html_entity_decode($kid->description) !!}
                                    @elseif($kid->field_type==App\Models\AuditField::LABEL)
                                    {{ $kid->label }}
                                    @elseif($kid->field_type==App\Models\AuditField::SUBHEADING)
                                    {{ $kid->label }}
                                    @elseif($kid->field_type==App\Models\AuditField::INSTRUCTION)
                                    <pre>{{ $kid->description }}</pre>
                                    @elseif($kid->field_type==App\Models\AuditField::QUESTION)
                                    <div class="form-group">
                                        {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                        </div>
                                    </div>
                                    @elseif($kid->field_type==App\Models\AuditField::TEXTAREA)
                                    <div class="form-group">
                                        {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                array('class' => 'form-control', 'rows' => '3')) !!}
                                        </div>
                                    </div>
                                    @elseif($kid->field_type==App\Models\AuditField::DATE)
                                    <div class="form-group">
                                        {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                        <div class="col-sm-3 form-group input-group date" id="date" style="padding-left:15px;">
                                            {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                    </div>
                                    @elseif($kid->field_type==App\Models\AuditField::SELECT)
                                    <div class="form-group">
                                        {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::select($kid->name, array(''=>trans('messages.please-select'))+explode(',',$kid->options),'', 
                                                array('class' => 'form-control', 'id' => $kid->name, 'style'=>'width:auto')) !!}
                                        </div>
                                    </div>
                                    @elseif($kid->field_type==App\Models\AuditField::CHOICE)
                                        @if($kid->textarea==App\Models\AuditField::TXTAREA)
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ $kid->label }}
                                                @if($kid->iso!=NULL)
                                                <br /><i><small><strong>{{ $kid->iso }}</strong></small></i>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    @foreach(explode(',',$kid->options) as $option)
                                                        <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                                    @endforeach
                                                    <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                                    <br /><br />
                                                    <div class="col-sm-12">
                                                        {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                        array('class' => 'form-control', 'rows' => '3')) !!}
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                @foreach(explode(',',$kid->options) as $option)
                                                    <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    @elseif($kid->field_type==App\Models\AuditField::CHECKBOX)
                                    <div class="form-group">
                                        {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                        <div class="col-sm-8">
                                            @foreach(explode(',',$kid->options) as $option)
                                                <label class="checkbox-inline">{!! Form::checkbox($option, $option, '') !!}{{ $option }}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @elseif($kid->field_type == App\Models\AuditField::MAINQUESTION)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><u>{{ $kid->label }}</u></p>
                                            <p>{{ $kid->description }}</p>
                                            <p><i><small>{{ $kid->iso }}</small></i></p>
                                        </div>
                                        <div class="col-md-6">
                                            @if($kid->options!=NULL)
                                            <div class="form-group">
                                                <div class="col-sm-8">
                                                @foreach(explode(',',$kid->options) as $option)
                                                    <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                                @endforeach
                                                <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    {!! Form::text($kid->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                                </div>
                                                /{{ $kid->score }}
                                                <br /><br />
                                                <div class="col-sm-12">
                                                    {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                    array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                            @else
                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                    {!! Form::text($kid->name, 'N', array('class' => 'form-control', 'disabled')) !!}
                                                </div>
                                                <div class="col-sm-4">
                                                    {!! Form::text($kid->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                                </div>
                                                /{{ $kid->score }}
                                                <br /><br />
                                                <div class="col-sm-12">
                                                    {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                    array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @elseif($kid->field_type == App\Models\AuditField::SUBQUESTION)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>{{ $kid->description }}</p>
                                            <p><i><small>{{ $kid->iso }}</small></i></p>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                {{ $kid->score }}
                                                <br /><br />
                                                <div class="col-sm-12">
                                                    {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                    array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($kid->field_type == App\Models\AuditField::STANDARD)
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!! html_entity_decode($kid->description) !!}
                                        </div>
                                    </div>
                                    @elseif($kid->field_type == App\Models\AuditField::SUBINSTRUCTION)
                                    <div class="row">
                                        <div class="col-md-8">
                                            {{ $kid->description }}
                                        </div>
                                        <div class="col-md-4" style="text-align:center;">
                                            @if($kid->options!=NULL)
                                            {!! html_entity_decode($kid->label."<br />(".$kid->options.")") !!}
                                            @else
                                            {!! html_entity_decode($kid->label) !!}
                                            @endif
                                        </div>
                                    </div>
                                    @elseif($kid->field_type == App\Models\AuditField::MAININSTRUCTION)
                                    <div class="row">
                                        <div class="col-md-8">
                                            {{ $kid->description }}
                                        </div>
                                        <div class="col-md-4" style="text-align:center;">
                                            @if($kid->options!=NULL)
                                            {!! html_entity_decode($kid->label."<br />(".$kid->options.")") !!}
                                            @else
                                            {!! html_entity_decode($kid->label) !!}
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    <!-- If not, display as is -->
                    @else
                        @foreach($auditFieldGroup->auditField as $kid)
                            @if($kid->field_type==App\Models\AuditField::HEADING)
                            <h4>{{ $kid->label }}</h4>
                            @elseif($kid->field_type==App\Models\AuditField::TEXT)
                            {!! html_entity_decode($kid->description) !!}
                            @elseif($kid->field_type==App\Models\AuditField::LABEL)
                            {{ $kid->label }}
                            @elseif($kid->field_type==App\Models\AuditField::SUBHEADING)
                            {{ $kid->label }}
                            @elseif($kid->field_type==App\Models\AuditField::INSTRUCTION)
                            <pre>{{ $kid->description }}</pre>
                            @elseif($kid->field_type==App\Models\AuditField::QUESTION)
                            <div class="form-group">
                                {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                </div>
                            </div>
                            @elseif($kid->field_type==App\Models\AuditField::TEXTAREA)
                            <div class="form-group">
                                {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::textarea($kid->name, Input::old($kid->name), 
                                        array('class' => 'form-control', 'rows' => '3')) !!}
                                </div>
                            </div>
                            @elseif($kid->field_type==App\Models\AuditField::DATE)
                            <div class="form-group">
                                {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-3 form-group input-group date" id="date" style="padding-left:15px;">
                                    {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control', 'style'=>'width:auto')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            @elseif($kid->field_type==App\Models\AuditField::SELECT)
                            <div class="form-group">
                                {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    {!! Form::select($kid->name, array(''=>trans('messages.please-select'))+explode(',',$kid->options),'', 
                                        array('class' => 'form-control', 'id' => $kid->name, 'style'=>'width:auto')) !!}
                                </div>
                            </div>
                            @elseif($kid->field_type==App\Models\AuditField::CHOICE)
                                @if($kid->textarea==App\Models\AuditField::TXTAREA)
                                <div class="row">
                                    <div class="col-md-6">
                                        {{ $kid->label }}
                                        @if($kid->iso!=NULL)
                                        <br /><i><small><strong>{{ $kid->iso }}</strong></small></i>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            @foreach(explode(',',$kid->options) as $option)
                                                <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                            @endforeach
                                            <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                            <br /><br />
                                            <div class="col-sm-12">
                                                {!! Form::textarea($kid->name, Input::old($kid->name), 
                                                array('class' => 'form-control', 'rows' => '3')) !!}
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                @else
                                <div class="form-group">
                                    {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                    <div class="col-sm-8">
                                        @foreach(explode(',',$kid->options) as $option)
                                            <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @elseif($kid->field_type==App\Models\AuditField::CHECKBOX)
                            <div class="form-group">
                                {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    @foreach(explode(',',$kid->options) as $option)
                                        <label class="checkbox-inline">{!! Form::checkbox($option, $option, '') !!}{{ $option }}</label>
                                    @endforeach
                                </div>
                            </div>
                            @elseif($kid->field_type == App\Models\AuditField::MAINQUESTION)
                            <div class="row">
                                <div class="col-md-6">
                                    <p><u>{{ $kid->label }}</u></p>
                                    <p>{{ $kid->description }}</p>
                                    <p><i><small>{{ $kid->iso }}</small></i></p>
                                </div>
                                <div class="col-md-6">
                                    @if($kid->options!=NULL)
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                        @foreach(explode(',',$kid->options) as $option)
                                            <label class="radio-inline">{!! Form::radio($kid->name, $option, '') !!}{{ $option }}</label>
                                        @endforeach
                                        <label class="checkbox-inline"><input type="checkbox">Non-compliant</label>
                                        </div>
                                        <div class="col-sm-2">
                                            {!! Form::text($kid->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                        </div>
                                        /{{ $kid->score }}
                                        <br /><br />
                                        <div class="col-sm-12">
                                            {!! Form::textarea($kid->name, Input::old($kid->name), 
                                            array('class' => 'form-control', 'rows' => '3')) !!}
                                        </div>
                                    </div>
                                    @else
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            {!! Form::text($kid->name, 'N', array('class' => 'form-control', 'disabled')) !!}
                                        </div>
                                        <div class="col-sm-4">
                                            {!! Form::text($kid->name, '0', array('class' => 'form-control', 'disabled')) !!}
                                        </div>
                                        /{{ $kid->score }}
                                        <br /><br />
                                        <div class="col-sm-12">
                                            {!! Form::textarea($kid->name, Input::old($kid->name), 
                                            array('class' => 'form-control', 'rows' => '3')) !!}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @elseif($kid->field_type == App\Models\AuditField::SUBQUESTION)
                            <div class="row">
                                <div class="col-md-6">
                                    <p>{{ $kid->description }}</p>
                                    <p><i><small>{{ $kid->iso }}</small></i></p>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        {{ $kid->score }}
                                        <br /><br />
                                        <div class="col-sm-12">
                                            {!! Form::textarea($kid->name, Input::old($kid->name), 
                                            array('class' => 'form-control', 'rows' => '3')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($kid->field_type == App\Models\AuditField::STANDARD)
                            <div class="row">
                                <div class="col-md-12">
                                    {!! html_entity_decode($kid->description) !!}
                                </div>
                            </div>
                            @elseif($kid->field_type == App\Models\AuditField::SUBINSTRUCTION)
                            <div class="row">
                                <div class="col-md-8">
                                    {{ $kid->description }}
                                </div>
                                <div class="col-md-4" style="text-align:center;">
                                    @if($kid->options!=NULL)
                                    {!! html_entity_decode($kid->label."<br />(".$kid->options.")") !!}
                                    @else
                                    {!! html_entity_decode($kid->label) !!}
                                    @endif
                                </div>
                            </div>
                            @elseif($kid->field_type == App\Models\AuditField::MAININSTRUCTION)
                            <div class="row">
                                <div class="col-md-8">
                                    {{ $kid->description }}
                                </div>
                                <div class="col-md-4" style="text-align:center;">
                                    @if($kid->options!=NULL)
                                    {!! html_entity_decode($kid->label."<br />(".$kid->options.")") !!}
                                    @else
                                    {!! html_entity_decode($kid->label) !!}
                                    @endif
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                    <!-- End Fields Logic -->
                    <!-- Content ends here -->
                    <div class="form-group">
                        <div class="col-sm-offset-7 col-sm-5">
                        {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
                              array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
                              {!! Form::button("<i class='fa fa-arrow-circle-o-right'></i> ".'Save and Continue', 
                              array('class' => 'btn btn-info', 'onclick' => 'reset()')) !!}
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