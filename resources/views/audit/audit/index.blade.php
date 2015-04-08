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
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.audit', 2) }}</div>
    <div class="panel-body">
        <div class="panel-group" id="accordion">
            @forelse($auditTypes as $auditType)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$auditType->id}}" aria-expanded="false" class="collapsed">{{ $auditType->name }}</a>
                    </h4>
                </div>
                <div id="collapse{{$auditType->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="panel-body">
                    <div class="col-lg-6">
                        <table class="table table-striped table-bordered table-hover no-footer">
                            <tbody>
                                <tr>
                                    <td>No. of Labs</td><td>7</td>
                                </tr>
                                <tr>
                                    <td>No. of Assessors</td><td>9</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>
                            <a href="{{ URL::to("audit/".$auditType->id."/1") }}" class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i><span> New Audit</span></a>
                            <a href="{{ URL::to("/response") }}" class="btn btn-default"><i class="fa fa-book"></i><span> View Audit Data</span></a>
                            <a href="{{ URL::to("/result") }}" class="btn btn-success"><i class="fa fa-database"></i><span> View Summary</span></a>
                        </p>
                    </div>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
@stop