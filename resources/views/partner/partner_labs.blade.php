@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.partner', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.partner', 2) }} <span class="panel-btn">
      <a class="btn btn-sm btn-info"  data-toggle="modal" data-target="#add_partner_labs">
        <span class="glyphicon glyphicon-plus-sign"></span>
            {{ Lang::choice('Add Facility', 1) }}
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
                <table class="table table-striped table-bordered table-hover {!! !$labs->isEmpty()?'search-table':'' !!}">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.name', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab_number', 1) }}</th>
                            <th>{{ Lang::choice('messages.county', 1) }}</th>
                            <th>{{ Lang::choice('messages.subcounty', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($labs as $lab)
                        <tr @if(session()->has('active_partner'))
                                {!! (session('active_partner') == $lab->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $lab->name }}</td>
                            <td>{{ $lab->lab_number }}</td>
                            <td>{{ $lab->county_id }}</td>
                            <td>{{ $lab->subcounty }}</td>
                            <td>
                                <a href="{{ url("lab/" . $lab->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {!! Lang::choice('messages.view', 1) !!}</span></a>                                
                                <!-- <a href="{{ url("partner/" . $lab->id . "/delete") }}" class="btn btn-warning btn-sm"><i class="fa fa-trash-o"></i><span> {!! Lang::choice('messages.delete', 1) !!}</span></a> -->
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="4">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {!! session(['SOURCE_URL' => URL::full()]) !!}
        </div>
      </div>
</div>
<!-- Duplicate Modal-->
<div class="modal fade" id="add_partner_labs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa fa-check-square-o"></i>
                    <span> <strong>Assign a Lab to Partner</strong></span>
                </h4>
            </div>
            {!! Form::open(array('route' => 'add_partner_labs', 'id' => 'form-add-partner', 'class' => 'form-horizontal')) !!}
            <input type="hidden" name="partner_id">>
            <div class="modal-body">                
                <div class="form-group">
                {!! Form::label('labs', Lang::choice('messages.lab', 2)) !!}
                <div class="form-pane panel panel-default">
                    <div class="container-fluid">
                        <?php 
                            $cnt = 0;
                            $zebra = "";
                        ?>
                        @foreach($all_labs as $key=>$value)
                            {!! ($cnt%4==0)?"<div class='row $zebra'>":"" !!}
                            <?php
                                $cnt++;
                                $zebra = (((int)$cnt/4)%2==1?"row-striped":"");
                            ?>
                            <div class="col-md-6">
                                <label  class="checkbox-inline">
                                    <input type="checkbox" name="labs[]" value="{{ $value->id}}" />{{$value->name}}
                                </label>
                            </div>
                            {{ ($cnt%4==0)?"</div>":"" }}
                        @endforeach
                        </div>
                    </div>                  
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                    {!! Form::button("<i class='glyphicon glyphicon-ok-circle'></i> ".Lang::choice('messages.save', 1), 
                        array('class' => 'btn btn-success', 'onclick' => 'submit()')) !!}                   
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times-circle-o"></i><span> Close</span>
                    </button>
                    </div> 
                </div>
            </div>
            {!! Form::close() !!} 
            <!-- End form -->
        </div>
    </div>
</div>
@stop