@extends("layout")
@section("content")
<br /><br /><br />
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
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.question', 2) }} <span class="panel-btn">
              <a class="btn btn-sm btn-info" href="{{ URL::to("question/create") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                    {{ Lang::choice('messages.create-question', 1) }}
                  </a>
                </span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover search-table">
                                <thead>
                                    <tr>
                                        <th>{{ Lang::choice('messages.name', 1) }}</th>
                                        <th>{{ Lang::choice('messages.description', 1) }}</th>
                                        <th>{{ Lang::choice('messages.section', 1) }}</th>
                                        <th>{{ Lang::choice('messages.parent', 1) }}</th>
                                        <th>{{ Lang::choice('messages.required', 1) }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($questions as $question)
                                    <tr>
                                        <td>{{ $question->name }}</td>
                                        <td>{{ $question->description }}</td>
                                        <td>{{ $question->description }}</td>
                                        <td>{{ $question->description }}</td>
                                        <td>{{ $question->required }}</td>
                                        <td>
                                          <a href="{{ URL::to("question/" . $question->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> View</span></a>
                                          <a href="{{ URL::to("question/" . $question->id . "/edit") }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i><span> Edit</span></a>
                                          <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> Delete</span></a>
                                          <button class="btn btn-sm btn-danger delete-item-link"
                                            data-toggle="modal" data-target=".confirm-delete-modal" 
                                            data-id='{{ URL::to("question/" . $question->id . "/delete") }}'>
                                            <span class="glyphicon glyphicon-trash"></span></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                      <td colspan="3">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ Session::put('SOURCE_URL', URL::full()) }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop