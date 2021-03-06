@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li>
                <a href="{{ url('review') }}">{{ Lang::choice('messages.audit', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.mark-audit-complete', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.response', 1) }} <span class="panel-btn">
    <a class="btn btn-sm btn-info" href="" onclick="window.history.back();return false;">
        <i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span>
    </a>
    </span></div>
    <div class="panel-body">
    <p>Click on the Section Buttons to continue filling in the review</p>
        @foreach($categories as $section)
            <div class="row" style="padding-top:5px;">
                <div class="col-sm-1" style="padding-top:5px;padding-right:10px;"><a href="{{ URL::to('review/'.$review->id.'/edit/'.$section->id) }}" class="btn btn-default btn-xs">{!! $section->name !!}</a></div>
                    <div class="col-sm-11">
                        <div class="row">
                        @foreach($section->questions as $question)
                            @if($question->score>0)
                                @if($question->qas($review->id) && count($question->id) == count($question->qas($review->id)))
                                <div class="col-sm-1" style="padding-top:5px;margin-right:5px;"><button type="button" class="btn btn-outline btn-xs btn-success">{!! ($question->title?substr($question->title, 0, 4):substr($question->description, 0, 4)).': '.substr(Lang::choice('messages.audit-status', 1), 0, 3) !!}</button></div>
                                @elseif($question->complete($review->id) && count($question->children) == count($question->complete($review->id)))
                                <div class="col-sm-1" style="padding-top:5px;margin-right:5px;"><button type="button" class="btn btn-outline btn-xs btn-success">{!! ($question->title?substr($question->title, 0, 4):substr($question->description, 0, 4)).': '.substr(Lang::choice('messages.audit-status', 1), 0, 3) !!}</button></div>
                                @else
                                <div class="col-sm-1" style="padding-top:5px;margin-right:5px;"><button type="button" class="btn btn-outline btn-xs btn-danger">{!! ($question->title?substr($question->title, 0, 4):substr($question->description, 0, 4)).': '.substr(Lang::choice('messages.audit-status', 2), 0, 3) !!}</button></div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop