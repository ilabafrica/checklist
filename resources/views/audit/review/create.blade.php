@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li>
                <a href="{{ url('review') }}">{{ Lang::choice('messages.audit', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.create-audit', 1) }}</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="btn-group btn-breadcrumb">
            <a href="#" class="btn btn-sm btn-default" style="margin-bottom:5px;"><i class="fa fa-home"></i> {!! $audit->name !!}</a>
            @foreach($audit->sections as $section)
                @if($section->order!=0)
                    <a href="{{ URL::to('review/create/'.$review->id.'/'.$section->id) }}" class="btn btn-sm {{ Request::segment(4)==$section->id?'btn-danger':'btn-default' }} btn-default" style="margin-bottom:5px;"><div>{!! $section->name !!}</div></a>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-tags"></i> {{ Lang::choice('messages.new-audit', '1') }}
                <span class="panel-btn">
                    <button type="button" class="btn btn-sm btn-info"><span class="fa fa-stack-exchange"></span> {{ Lang::choice('messages.selected-lab', 1) }}{!! $lab->name !!} </button>
                    <button type="button" class="btn btn-sm btn-info"><span class="fa fa-clipboard"></span> {{ Lang::choice('messages.selected-audit', 1) }}{!! $audit->name !!} </button>
                </span>
            </div>
            <div class="panel-body">
                @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', 1) }}</span></button>
                  {!! session('error') !!}
                </div>
                @endif
                @if($page->id == App\Models\AuditType::find($audit->id)->sections->first()['id'])
                    <img src="{{ Config::get('slipta.slipta-logo') }}" alt="" height="150px" width="" class="img-responsive center-block">
                    <h1 align="center">{{ Config::get('slipta.slipta') }}</h1>
                    <h2 align="center">{{ Config::get('slipta.slipta-brief') }}</h2>
                @endif
                <!-- Begin form logic -->
                {!! Form::open(array('route' => 'review.store', 'id' => 'form-add-review', 'class' => 'form-horizontal formular')) !!}
                    <!-- CSRF Token -->
                    <input type="hidden" id="_token" name="_token" value="{{{ csrf_token() }}}" />
                    <!-- ./ csrf token -->
                    <!-- Hidden fields for audit_type_id -->
                    {!! Form::hidden('audit_type_id', $audit->id, array('id' => 'audit_type_id')) !!}
                    <!-- Hidden fields for lab_id -->
                    {!! Form::hidden('lab_id', $lab->id, array('id' => 'lab_id')) !!}
                    <!-- Hidden fields for review id -->
                    {!! Form::hidden('review_id', $review->id, array('id' => 'review_id')) !!}
                    <!-- Hidden fields for section id -->
                    {!! Form::hidden('section_id', $page->id, array('id' => 'section_id')) !!}
                    <!-- Display pages that do not necessariry have form fields -->
                    @if(!count($page->questions)>0 && count($page->notes)>0)
                        @foreach($page->notes as $note)
                            <hr><h4>{!! $note->name !!}</h4><hr>{!! html_entity_decode($note->description) !!}
                        @endforeach
                    @elseif(!count($page->questions)>0 && !count($page->notes)>0)
                        @if($page->name == 'SLMTA Info')
                            <u><h4>{{ $page->label }}</h4></u>
                            <div class="form-group">
                                {!! Form::label('official-slmta', Lang::choice('messages.official-slmta', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <label class="checkbox-inline">{!! Form::checkbox('official_slmta', 1, '') !!}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('audit-start-date', Lang::choice('messages.audit-start-date', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6 form-group input-group input-append date datepicker" style="padding-left:15px;">
                                    {!! Form::text('audit_start_date', Input::old('audit_start_date'), array('class' => 'form-control')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('audit-end-date', Lang::choice('messages.audit-end-date', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6 form-group input-group input-append date datepicker" style="padding-left:15px;">
                                    {!! Form::text('audit_end_date', Input::old('audit_end_date'), array('class' => 'form-control')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('assessors', Lang::choice('messages.names-affiliations-of-auditors', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <?php 
                                                $cnt = 0;
                                                $zebra = "";
                                            ?>
                                            @foreach($assessors as $key=>$value)
                                                {!! ($cnt%4==0)?"<div class='row $zebra'>":"" !!}
                                                <?php
                                                    $cnt++;
                                                    $zebra = (((int)$cnt/4)%2==1?"row-striped":"");
                                                ?>
                                                <div class="col-md-6">
                                                    <label  class="checkbox-inline">
                                                        <input type="checkbox" name="assessors[]" value="{{ $value->id}}" />{{ $value->name }}
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
                                {!! Form::label('assessment_id', Lang::choice('messages.slmta-audit-type', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::select('assessment_id', array(''=>trans('messages.select'))+$assessments,'', 
                                        array('class' => 'form-control', 'id' => 'assessment_id')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tests-before-slmta', Lang::choice('messages.tests-before-slmta', 1), array('class' => 'col-sm-4 control-label', 'id' => 'tests-before-slmta')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('tests_before_slmta', Input::old('tests_before_slmta'), array('class' => 'form-control', 'id' => 'tests_before_slmta')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('tests-this-year', Lang::choice('messages.tests-this-year', 1), array('class' => 'col-sm-4 control-label', 'id' => 'tests-this-year')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('tests_this_year', Input::old('tests_this_year'), array('class' => 'form-control', 'id' => 'tests_this_year')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('cohort-id', Lang::choice('messages.cohort-id', 1), array('class' => 'col-sm-4 control-label', 'id' => 'cohort-id')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('cohort_id', Input::old('cohort_id'), array('class' => 'form-control', 'id' => 'cohort_id')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('slmta-lab-type', Lang::choice('messages.slmta-lab-type', 1), array('class' => 'col-sm-4 control-label', 'id' => 'slmta-lab-type')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->labType->name !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('baseline-audit-date', Lang::choice('messages.baseline-audit-date', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6 form-group input-group input-append date datepicker" style="padding-left:15px;">
                                    {!! Form::text('baseline_audit_date', Input::old('baseline_audit_date'), array('class' => 'form-control')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('slmta-workshop-date', Lang::choice('messages.slmta-workshop-date', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6 form-group input-group input-append date datepicker" style="padding-left:15px;">
                                    {!! Form::text('slmta_workshop_date', Input::old('slmta_workshop_date'), array('class' => 'form-control')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('exit-audit-date', Lang::choice('messages.exit-audit-date', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6 form-group input-group input-append date datepicker" style="padding-left:15px;">
                                    {!! Form::text('exit_audit_date', Input::old('exit_audit_date'), array('class' => 'form-control')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('baseline-score', Lang::choice('messages.baseline-score', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('baseline_score', Input::old('baseline_score'), array('class' => 'form-control', 'id' => 'baseline_score')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('baseline-stars', Lang::choice('messages.baseline-stars', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::select('baseline_stars', array(''=>trans('messages.select'))+$stars,'', 
                                        array('class' => 'form-control', 'id' => 'baseline_stars')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('exit-score', Lang::choice('messages.exit-score', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('exit_score', Input::old('exit_score'), array('class' => 'form-control', 'id' => 'baseline_score')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('exit-stars', Lang::choice('messages.exit-stars', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::select('exit_stars', array(''=>trans('messages.select'))+$stars,'', 
                                        array('class' => 'form-control', 'id' => 'exit_stars')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('last-audit-date', Lang::choice('messages.last-audit-date', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6 form-group input-group input-append date datepicker" style="padding-left:15px;">
                                    {!! Form::text('last_audit_date', Input::old('last_audit_date'), array('class' => 'form-control')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('last-audit-score', Lang::choice('messages.last-audit-score', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('last_audit_score', Input::old('last_audit_score'), array('class' => 'form-control', 'id' => 'last_audit_score')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('prior-audit-status', Lang::choice('messages.prior-audit-status', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::select('prior_audit_status', array(''=>trans('messages.select'))+$stars,'', 
                                        array('class' => 'form-control', 'id' => 'prior_audit_status')) !!}
                                </div>
                            </div>
                        @elseif($page->name == 'Lab Info')
                            <u><h4>{{ $page->label }}</h4></u>
                            <div class="form-group">
                                {!! Form::label('lab-name', Lang::choice('messages.lab-name', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->name !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-number', Lang::choice('messages.lab-number', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->lab_number !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-address', Lang::choice('messages.lab-address', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->address !!} - {!! $lab->postal_code !!}</p>
                                    <p class="text-primary inline">{!! $lab->city !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-telephone', Lang::choice('messages.lab-telephone', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->phone !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-fax', Lang::choice('messages.lab-fax', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->fax !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-email', Lang::choice('messages.lab-email', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->email !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-head', Lang::choice('messages.lab-head', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('head', Input::old('head'), array('class' => 'form-control', 'id' => 'head')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-head-telephone-personal', Lang::choice('messages.lab-head-telephone-personal', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('head_personal_telephone', Input::old('head_personal_telephone'), array('class' => 'form-control', 'id' => 'head_personal_telephone')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-head-telephone-work', Lang::choice('messages.lab-head-telephone-work', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('head_work_telephone', Input::old('head_work_telephone'), array('class' => 'form-control', 'id' => 'head_work_telephone')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-level', Lang::choice('messages.lab-level', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->labLevel->name !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-affiliation', Lang::choice('messages.lab-affiliation', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->labAffiliation->name !!}</p>
                                </div>
                            </div>
                        @elseif($page->name == 'Staffing Summary')
                            <u><h4>{{ $page->label }}</h4></u>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="text-muted inline">{!! Lang::choice('messages.profession', 1) !!}</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted inline">{!! Lang::choice('messages.fulltime-employees', 1) !!}</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="text-muted inline">{!! Lang::choice('messages.adequate', 1) !!}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.degree', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('degree_staff', Input::old('degree_staff'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('degree_staff_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('degree_staff_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('degree_staff_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.diploma', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('diploma_staff', Input::old('diploma_staff'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('diploma_staff_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('diploma_staff_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('diploma_staff_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.certificate', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('certificate_staff', Input::old('certificate_staff'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('certificate_staff_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('certificate_staff_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('certificate_staff_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.microscopist', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('microscopist', Input::old('microscopist'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('microscopist_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('microscopist_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('microscopist_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.data-clerk', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('data_clerk', Input::old('data_clerk'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('data_clerk_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('data_clerk_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('data_clerk_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.phlebotomist', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('phlebotomist', Input::old('phlebotomist'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('phlebotomist_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('phlebotomist_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('phlebotomist_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.cleaner', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('cleaner', Input::old('cleaner'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('cleaner_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('cleaner_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('cleaner_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <p>{!! Lang::choice('messages.cleaner-dedicated', 1) !!}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="radio-inline">{!! Form::radio('cleaner_dedicated', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('cleaner_dedicated', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <p>{!! Lang::choice('messages.cleaner-trained', 1) !!}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="radio-inline">{!! Form::radio('cleaner_trained', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('cleaner_trained', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.driver', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('driver', Input::old('driver'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('driver_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('driver_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('driver_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <p>{!! Lang::choice('messages.driver-dedicated', 1) !!}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="radio-inline">{!! Form::radio('driver_dedicated', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('driver_dedicated', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <p>{!! Lang::choice('messages.cleaner-trained', 1) !!}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="radio-inline">{!! Form::radio('driver_trained', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('driver_trained', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <strong><p>{!! Lang::choice('messages.other', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            {!! Form::text('other_staff', Input::old('other_staff'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('other_staff_adequate', App\Models\Answer::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('other_staff_adequate', App\Models\Answer::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('other_staff_adequate', App\Models\Answer::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <small><i>{!! Lang::choice('messages.staff-note', 1) !!}</i></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($page->name == 'Summary')
                            <h4>{{ $page->label }}</h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">{!! Lang::choice('messages.commendations', 1) !!}</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <?php
                                                        $summary = '';
                                                        foreach($audit->sections as $part)
                                                        {
                                                            if(count(array_intersect($questions, $part->questions->lists('id')))>0)
                                                            {
                                                                $summary.="\n".$part->label."\n";
                                                                foreach($notes as $note)
                                                                {
                                                                    if(in_array(App\Models\ReviewQuestion::find($note->review_question_id)->question_id, $part->questions->lists('id')))
                                                                    {
                                                                        $summary.="\n".$note->note;
                                                                    }
                                                                }
                                                            $summary.="\n";
                                                            }
                                                        }
                                                    ?>
                                                    {!! Form::textarea('commendations', html_entity_decode($summary), array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">{!! Lang::choice('messages.challenges', 1) !!}</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::textarea('challenges', Input::old('pt_description'), array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">{!! Lang::choice('messages.recommendations', 1) !!}</div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::textarea('recommendations', Input::old('pt_description'), array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($page->name == 'Action Plan')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong>{!! Lang::choice('messages.action-plan', 1) !!}</strong></div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td>{!! Lang::choice('messages.follow-up-actions', 1) !!}</td>
                                                            <td>{!! Lang::choice('messages.responsible-persons', 1) !!}</td>
                                                            <td>{!! Lang::choice('messages.timeline', 1) !!}</td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>    
                                                    <tbody id="action_plan_{{$review->id}}">
                                                        <tr>
                                                            <td>{!! Form::textarea('action_'.$review->id, '', array('class' => 'form-control', 'rows' => '3', 'id' => 'action_'.$review->id)) !!}</td>
                                                            <td>{!! Form::textarea('person_'.$review->id, '', array('class' => 'form-control', 'rows' => '3', 'id' => 'persons_'.$review->id)) !!}</td>
                                                            <td>{!! Form::textarea('timeline_'.$review->id, '', array('class' => 'form-control', 'rows' => '3', 'id' => 'timeline_'.$review->id)) !!}</td>
                                                            <td>
                                                                <a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="saveActionPlan('{{$review->id}}')"><i class="fa fa-save"></i> {{ Lang::choice('messages.save', 1) }}</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Hidden field for audit data -->
                        {!! Form::hidden('assessment_data', 1, array('id' => 'assessment_data')) !!}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        {!! Lang::choice('messages.general-note', 1) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>{{ $page->label }}</h4>
                        @if(count($page->questions)>0)
                            @foreach($page->questions as $question)
                                @if($question->score != 0)
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <strong><u>{{ $question->title }}</u><br />{{ $question->description }}</strong><br /><i><small>{{ $question->info }}</small></i>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        @if(count($question->children)>0)
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    {!! Form::text('answer_'.$question->id, '', array('class' => 'form-control', 'id' => 'answer_'.$question->id, 'readonly')) !!}
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group input-group"><input type="text" name="points_{{$question->id}}" id="points_{{$question->id}}" class="form-control page_{{$page->id}}" oninput="sub_total('page_{{$page->id}}')" readonly><span class="input-group-addon">/{!! $question->score !!}</span></div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="row">
                                                                <div class="col-sm-8">
                                                                @foreach($question->answers as $answer)
                                                                    <label class="radio-inline">{!! Form::radio('radio_'.$question->id, $answer->id, '', ['class' => 'validate[required] radio  radio_'.$question->id, 'id' => 'radio_'.$question->id, 'onclick' => "scoreMain('radio_$question->id', '$question->score')"]) !!}{{ $answer->name }}</label>
                                                                @endforeach
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group input-group"><input type="text" name="points_{{$question->id}}" id="points_{{$question->id}}" class="form-control page_{{$page->id}}" oninput="sub_total('page_{{$page->id}}')" readonly><span class="input-group-addon">/{!! $question->score !!}</span></div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            {!! Form::textarea('text_'.$question->id, Input::old('text_'.$question->id), array('class' => 'form-control', 'id' => 'text_'.$question->id, 'rows' => '3')) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(count($question->children)>0)
                                        @foreach($question->children as $kid)
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    {!! $kid->title!=NULL?'<strong><u>'.$kid->title.'</u></strong><br />':'' !!}{!! $kid->description !!}<br /><i><small>{{ $kid->info }}</small></i>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                @foreach($kid->answers as $answer)
                                                                    <label class="radio-inline">{!! Form::radio('radio_'.$kid->id, $answer->id, '', ['class' => 'validate[required] radio radio_'.$question->id, 'id' => 'radio_'.$kid->id, 'onclick' => "noteChange('radio_$question->id', '$question->score')"]) !!}{{ $answer->name }}</label>
                                                                @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    {{--*/ $kid->title!=NULL?$title = $kid->title:$title = substr($kid->description, 0, 2) /*--}}
                                                                    {!! Form::textarea('text_'.$kid->id, $kid->note($review->id)?$kid->note($review->id)->note:'', array('class' => 'form-control area_'.$question->id, 'onchange' => "notes('area_$question->id')", 'data-title' => $title, 'rows' => '3', 'id' => 'text_'.$kid->id)) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(count($kid->notes)>0)
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            @foreach($kid->notes as $note)
                                                            {!! $note->description !!}
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if(count($question->notes)>0)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    @foreach($question->notes as $note)
                                                    {!! $note->description !!}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-danger">
                                        <div class="panel-body">
                                            <div class="col-sm-9">
                                                <strong>{{ $page->name }} : {{ $page->label }} {!! Lang::choice('messages.sub-total', 1) !!}</strong>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group input-group"><input type="text" name="subtotal_{{$page->id}}" id="subtotal_{{$page->id}}" class="form-control" readonly><span class="input-group-addon">/{!! $page->total_points !!}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-6">
                        @if(($page->order == 0 && $page->total_points == 0) || ($page->total_points == 0 && count($page->notes)>0))
                            @if(count($page->next())==0)
                                <a href="{{ url('review/assessment/'.$review->id) }}" class="btn btn-s-md btn-default"><i class="fa fa-arrow-circle-o-right"></i> {{ Lang::choice('messages.next', 1) }}</a>
                            @else
                                <a href="{{ url('review/create/'.$review->id.'/'.$page->next()[0]->id) }}" class="btn btn-s-md btn-default"><i class="fa fa-arrow-circle-o-right"></i> {{ Lang::choice('messages.next', 1) }}</a>
                            @endif
                        @else
                        {!! Form::submit(Lang::choice('messages.save', 1), 
                              array('class' => 'btn btn-success', 'id' => 'save', 'name' =>Lang::choice('messages.save', 1))) !!}
                        {!! Form::submit(Lang::choice('messages.save-and-continue', 1), 
                              array('class' => 'btn btn-info',  'id' => 'continue', 'name' =>Lang::choice('messages.save-and-continue', 1))) !!}
                        @endif
                        <a href="#" class="btn btn-s-md btn-warning"><i class="glyphicon glyphicon-ban-circle"></i> {{ Lang::choice('messages.cancel', 1) }}</a>
                        </div>
                    </div>
                {!! Form::close() !!}
                    <!-- End form logic -->                    
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready( function() {
        jQuery("#form-edit-review").validationEngine({promptPosition:"topLeft", scroll:true});
        // binds form submission and fields to the validation engine
        $('#save').click(function(e){
            e.preventDefault();
            if(!$("#form-add-review").validationEngine('validate'))
                return false;
            else
                $("#form-add-review").submit();
        });
        $('#continue').click(function(e){
            e.preventDefault();
            if(!$("#form-add-review").validationEngine('validate'))
                return false;
            else
                $("#form-add-review").submit();
        });
        //jQuery("#form-edit-review").validationEngine();
    });
</script>
@stop