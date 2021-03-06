@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.question', 1) }}</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">

    @if(Session::has('message'))
    <div class="alert alert-info">{{Session::get('message')}}</div>
    @endif
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.question', 2) }} <span class="panel-btn">
              <a class="btn btn-sm btn-info" href="{{ URL::to("question/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                    {{ Lang::choice('messages.create-question', 1) }}
                  </a>
                </span>
            </div>
            <div class="panel-body">
                @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">{{ Lang::choice('messages.close', 1) }}</span></button>
                  {!! session('message') !!}
                </div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped table-bordered table-hover {!! !$questions->isEmpty()?'search-table':'' !!}">
                            <thead>
                                <tr>
                                    <th>{{ Lang::choice('messages.name', 1) }}</th>
                                    <th>{{ Lang::choice('messages.label', 1) }}</th>
                                    <th>{{ Lang::choice('messages.description', 1) }}</th>
                                    <th>{{ Lang::choice('messages.section', 1) }}</th>
                                    <th>{{ Lang::choice('messages.required', 1) }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questions as $question)
                                <tr @if(session()->has('active_question'))
                                        {!! (session('active_question') == $question->id)?"class='warning'":"" !!}
                                    @endif
                                    >
                                    <td>{{ $question->name }}</td>
                                    <td>{{ $question->title }}</td>
                                    <td>{{ $question->description }}</td>
                                    <td>{{ $question->section->name }}</td>
                                    <td>{{ $question->required==App\Models\Question::REQUIRED?Lang::choice('messages.yes', 1):Lang::choice('messages.no', 1) }}</td>
                                    <td>
                                      <a href="{{ URL::to("question/" . $question->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {{ Lang::choice('messages.view', 1) }}</span></a>
                                      <a href="{{ URL::to("question/" . $question->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> {{ Lang::choice('messages.edit', 1) }}</span></a>
                                      <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> {{ Lang::choice('messages.delete', 1) }}</span></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                  <td colspan="6">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {!! session(['SOURCE_URL' => URL::full()]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop