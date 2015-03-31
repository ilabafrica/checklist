@extends("layout")
@section("content")
<br /><br /><br />
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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.create-audit-type', '1') }}</div>
    <div class="panel-body">
    <div class="row">
        
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Default Panel
                </div>
                <div class="panel-body">
                    <p>
                        <ul id="tree2">
                            <li><a href="#">{{ $auditType->name }}</a>

                                <ul>
                                    @foreach($auditFieldGroups as $group)
                                        @if(count($group->auditField())>0 && count($group->children)>0)
                                        <li>{{ $group->name }}
                                            <ul>
                                                @foreach($group->children as $child)
                                                    @if(count($child->children)>0)
                                                    <li>{{ $child->name }}
                                                        <ul>
                                                            @foreach($child->children as $grand)
                                                                <li>{{ $grand->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                    @else    
                                                    <li>{{ $child->name }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        @else
                                        <li>{{ $group->name }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Success Panel
                </div>
                <div class="panel-body">
                    @foreach($auditFieldGroups as $grp)
                        @if($errors->all())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                            {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
                        </div>
                        @endif
                        {!! Form::open(array('route' => 'auditField.store', 'id' => 'form-add-audit-field', 'class' => 'form-horizontal')) !!}
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <!-- ./ csrf token -->
                            <!-- Content goes here -->
                            @foreach($grp->children as $kids)
                                <b>{{ $kids->name }}</b><br />
                                @foreach($kids->auditField as $kid)
                                    {{ $kid->name }}<br />
                                    @if($kid->field_type==App\Models\AuditField::HEADING)
                                        <h4>{{ $kid->label }}</h4>
                                    @elseif($kid->field_type==App\Models\AuditField::TEXT)
                                        {{ $kid->description }}
                                    @elseif($kid->field_type==App\Models\AuditField::LABEL)
                                        {{ $kid->label }}
                                    @elseif($kid->field_type==App\Models\AuditField::SUBHEADING)
                                        {{ $kid->label }}
                                    @elseif($kid->field_type==App\Models\AuditField::INSTRUCTION)
                                        {{ $kid->description }}
                                    @elseif($kid->field_type==App\Models\AuditField::QUESTION)
                                    <div class="form-group">
                                        {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control')) !!}
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
                                            <div class="col-sm-offset-6 col-sm-7 form-group input-group date" id="date">
                                                {!! Form::text($kid->name, Input::old($kid->name), array('class' => 'form-control')) !!}
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                        </div>
                                    @elseif($kid->field_type==App\Models\AuditField::SELECT)
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                                {!! Form::select($kid->name, array(''=>trans('messages.please-select'))+array(implode(', ',[$kid->options])),'', 
                                                    array('class' => 'form-control', 'id' => $kid->name)) !!}
                                            </div>
                                        </div>
                                    @elseif($kid->field_type==App\Models\AuditField::CHOICE)
                                        <div class="form-group">
                                            {!! Form::label($kid->name, $kid->label, array('class' => 'col-sm-4 control-label')) !!}
                                            <div class="col-sm-8">
                                            @foreach(explode(',',$kid->options) as $option)
                                                <label class="radio-inline">{!! Form::radio($option, $option, '') !!}{{ $option }}</label>
                                            @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Check if has include table -->
                                    @if($kid->table == App\Models\AuditField::TABLE)
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">{{ $kid->label }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($kid->children)>0)
                                                        @foreach($kid->children as $grand)
                                                            @if($grand->field_type == App\Models\AuditField::MAINQUESTION)
                                                            <tr>
                                                                <td>
                                                                    <p><u>{{ $grand->label }}</u></p>
                                                                    <p>{{ $grand->description }}</p>
                                                                    <p><i><small>{{ $grand->iso }}</small></i></p>
                                                                </td>
                                                                <td>{{ $grand->score }}</td>
                                                            </tr>
                                                            @elseif($grand->field_type == App\Models\AuditField::SUBQUESTION)
                                                            <tr>
                                                                <td>
                                                                    <p>{{ $grand->description }}</p>
                                                                    <p><i><small>{{ $grand->iso }}</small></i></p>
                                                                </td>
                                                                <td>{{ $grand->score }}</td>
                                                            </tr>
                                                            @elseif($grand->field_type == App\Models\AuditField::INSTRUCTION)
                                                            <tr>
                                                                <td rowspan="2">{{ $grand->label }}</td>
                                                                <td>
                                                                    <p><b>{{ $grand->description }}</b></p>
                                                                </td>
                                                                <td>{{ $grand->score }}</td>
                                                            </tr>
                                                            @elseif($grand->field_type==App\Models\AuditField::CHOICE)
                                                            <tr>
                                                                <td>{{ $grand->label }}</td>
                                                                <td>{{ $grand->label }}</td>
                                                            </tr>
                                                            @elseif($grand->field_type == App\Models\AuditField::STANDARD)
                                                            <tr>
                                                                <td colspan="2"><i><small>{{ $grand->description }}</small></i></td>
                                                            </tr>
                                                            @endif
                                                            @if(count($grand->children)>0)
                                                                @foreach($grand->children as $node)
                                                                <tr>
                                                                    <td>{{ $node->description }}</td>
                                                                    <td><b>{{ $node->label }}</b></td>
                                                                </tr>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach
                            <!-- Content ends here -->
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-9">
                                {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
                                      array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
                                      {!! Form::button("<i class='fa fa-arrow-circle-o-right'></i> ".'Save and Continue', 
                                      array('class' => 'btn btn-info', 'onclick' => 'reset()')) !!}
                                <a href="#" class="btn btn-s-md btn-warning"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
                                </div>
                            </div>
                        {!! Form::close() !!} 
                    <!-- End form -->

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop