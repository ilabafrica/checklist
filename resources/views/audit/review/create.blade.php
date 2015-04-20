@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li class="active">
                <a href="#"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-tags"></i> {{ Lang::choice('messages.new-audit', '1') }}
                <span class="panel-btn">
                    <button type="button" class="btn btn-sm btn-info"><span class="fa fa-stack-exchange"></span> {{ Lang::choice('messages.selected-lab', 1) }}{!! $lab->facility->name !!} </button>
                    <button type="button" class="btn btn-sm btn-info"><span class="fa fa-clipboard"></span> {{ Lang::choice('messages.selected-audit', 1) }}{!! $audit->name !!} </button>
                </span>
            </div>
            <div class="panel-body">
                @if($errors->all())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    {!! HTML::ul($errors->all(), array('class'=>'list-unstyled')) !!}
                </div>
                @endif
                @if($page->id == App\Models\AuditType::find($audit->id)->sections->first()['id'])
                    <img src="{{ Config::get('slipta.slipta-logo') }}" alt="" height="150px" width="" class="img-responsive center-block">
                    <h1 align="center">{{ Config::get('slipta.slipta') }}</h1>
                    <h2 align="center">{{ Config::get('slipta.slipta-brief') }}</h2>
                @endif
                <!-- Begin form logic -->
                {!! Form::open(array('route' => 'review.store', 'id' => 'form-add-review', 'class' => 'form-horizontal')) !!}
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
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
                                    <p class="text-primary inline">{!! $lab->facility->name !!}</p>
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
                                    <p class="text-primary inline">{!! $lab->facility->address !!} - {!! $lab->facility->town->postal_code !!}</p>
                                    <p class="text-primary inline">{!! $lab->facility->town->name !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-telephone', Lang::choice('messages.lab-telephone', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->facility->mobile !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-fax', Lang::choice('messages.lab-fax', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->facility->fax !!}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('lab-email', Lang::choice('messages.lab-email', 1), array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-6">
                                    <p class="text-primary inline">{!! $lab->facility->email !!}</p>
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
                                            <label class="radio-inline">{!! Form::radio('degree_staff_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('degree_staff_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('degree_staff_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('diploma_staff_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('diploma_staff_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('diploma_staff_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('certificate_staff_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('certificate_staff_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('certificate_staff_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('microscopist_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('microscopist_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('microscopist_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('data_clerk_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('data_clerk_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('data_clerk_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('phlebotomist_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('phlebotomist_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('phlebotomist_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('cleaner_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('cleaner_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('cleaner_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                                    <label class="radio-inline">{!! Form::radio('cleaner_dedicated', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('cleaner_dedicated', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
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
                                                    <label class="radio-inline">{!! Form::radio('cleaner_trained', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('cleaner_trained', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('driver_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('driver_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('driver_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                                                    <label class="radio-inline">{!! Form::radio('driver_dedicated', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('driver_dedicated', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
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
                                                    <label class="radio-inline">{!! Form::radio('driver_trained', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                                    <label class="radio-inline">{!! Form::radio('driver_trained', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
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
                                            <label class="radio-inline">{!! Form::radio('other_staff_adequate', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('other_staff_adequate', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('other_staff_adequate', App\Models\Review::INSUFFICIENT, '') !!}{{ Lang::choice('messages.insufficient-data', 1) }}</label>
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
                        @elseif($page->name == 'Org Structure')
                            <u><h4>{{ $page->label }}</h4></u>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            {!! Lang::choice('messages.org-structure-note', 1) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <strong><p>{!! Lang::choice('messages.sufficient-space', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('sufficient_space', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('sufficient_space', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <strong><p>{!! Lang::choice('messages.equipment', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('equipment', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('equipment', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <strong><p>{!! Lang::choice('messages.supplies', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('supplies', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('supplies', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <strong><p>{!! Lang::choice('messages.personnel', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('personnel', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('personnel', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <strong><p>{!! Lang::choice('messages.infrastructure', 1) !!}</p></strong>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('infrastructure', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('infrastructure', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <strong><p>{!! Lang::choice('messages.other-specify', 1) !!}</p></strong>
                                        </div>
                                        <div class="col-sm-6" >
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {!! Form::textarea('other_description', Input::old('other_description'), array('class' => 'form-control', 'rows' => '3')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="radio-inline">{!! Form::radio('other', App\Models\Review::YES, '') !!}{{ Lang::choice('messages.yes', 1) }}</label>
                                            <label class="radio-inline">{!! Form::radio('other', App\Models\Review::NO, '') !!}{{ Lang::choice('messages.no', 1) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
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
                                                            <div class="form-group input-group"><input type="text" name="audited_points_{{$question->id}}" class="form-control" disabled><span class="input-group-addon">/{!! $question->score !!}</span></div>
                                                        @else
                                                            @foreach($question->answers as $answer)
                                                                <label class="radio-inline">{!! Form::radio('radio_'.$question->id, $answer->id, '') !!}{{ $answer->name }}</label>
                                                            @endforeach
                                                        @endif
                                                        <label class="checkbox-inline">{!! Form::checkbox('check_'.$question->id, 1, '') !!}{{ Lang::choice('messages.non-compliant', 1) }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            {!! Form::textarea('text_'.$question->id, Input::old('text_'.$question->id), array('class' => 'form-control', 'rows' => '3')) !!}
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
                                                    {{ $kid->description }}<br /><i><small>{{ $kid->info }}</small></i>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                @foreach($kid->answers as $answer)
                                                                    <label class="radio-inline">{!! Form::radio('radio_'.$kid->id, $answer->id, '', array('class'=>'radiocc')) !!}{{ $answer->name }}</label>
                                                                @endforeach
                                                                <label class="checkbox-inline">{!! Form::checkbox('check_'.$kid->id, 1, '') !!}{{ Lang::choice('messages.non-compliant', 1) }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    {!! Form::textarea('text_'.$kid->id, Input::old('text_'.$kid->id), array('class' => 'form-control', 'rows' => '3')) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                        @endif
                    @endif
                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-6">
                        @if(($page->order == 0 && $page->total_points == 0) || ($page->total_points == 0 && count($page->notes)>0))
                        <a href="{{ url('review/create/'.$review->id.'/'.$page->next()->first()->id) }}" class="btn btn-s-md btn-default"><i class="fa fa-arrow-circle-o-right"></i> {{ Lang::choice('messages.next', 1) }}</a>
                        @else
                        {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
                              array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}
                        {!! Form::button("<i class='fa fa-arrow-circle-o-right'></i> ".'Save and Continue', 
                              array('class' => 'btn btn-info', 'onclick' => 'reset()')) !!}
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
@stop