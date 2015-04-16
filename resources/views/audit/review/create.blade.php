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
                    <!-- Display pages that do not necessariry have form fields -->
                    @if(!count($page->questions)>0 && count($page->notes)>0)
                        @foreach($page->notes as $note)
                            <hr><h4>{!! $note->name !!}</h4><hr>{!! html_entity_decode($note->description) !!}
                        @endforeach
                    @elseif(!count($page->questions)>0 && !count($page->notes)>0)
                        {{ $page->id }}
                    @endif
                    <div class="form-group">
                        <div class="col-sm-offset-7 col-sm-5">
                        @if($page->id == App\Models\AuditType::find($audit->id)->sections->first()['id'])
                        <a href="{{ url('review/create/1/3') }}" class="btn btn-s-md btn-default"><i class="fa fa-arrow-circle-o-right"></i> {{ Lang::choice('messages.next', 1) }}</a>
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