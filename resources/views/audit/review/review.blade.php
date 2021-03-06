@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.audit', 1) }}</li>
        </ol>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.audit', 2) }}
        
        @if($id!=NULL)
        <span class="panel-btn">
            @if(Auth::user()->can('create-audit'))
            <a class="btn btn-sm btn-info" href="{{ URL::to("lab") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.create-audit', 1) }}
            </a>
            @endif

            @if(Auth::user()->can('import-data'))
            <a class="btn btn-sm btn-info" href="{{ URL::to("import/".$id) }}" >
                <span class="fa fa-download"></span>
                {{ Lang::choice('messages.import-audit', 1) }}
            </a>
            <a class="btn btn-sm btn-info" href="" onclick="window.history.back();return false;">
                <i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span>
            </a>
            @endif

        </span>
        @endif
       
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

                <table class="table table-striped table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th>{{ Lang::choice('messages.no', 1) }}</th>
                            <th>{{ Lang::choice('messages.assessor', 1) }}</th>
                            <th>{{ Lang::choice('messages.lab', 1) }}</th>
                            <th>{{ Lang::choice('messages.audit', 1) }}</th>
                            <th>{{ Lang::choice('messages.date', 1) }}</th>
                            <th>{{ Lang::choice('messages.status', 1) }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($responses as $response)
                        <tr @if(session()->has('active_review'))
                                {!! (session('active_review') == $response->id)?"class='warning'":"" !!}
                            @endif
                            >
                            <td>{{ $response->id }}</td>
                            <td>{{ $response->user->name }}</td>
                            <td>{{ $response->lab->name }}</td>
                            <td>{{ $response->auditType->name }}</td>
                            <td>{{ $response->created_at }}</td>
                            <td>{!! $response->status==App\Models\Review::COMPLETE?'<span class="label label-success">'.Lang::choice('messages.audit-status', 1).'</span>':'<span class="label label-warning">'.Lang::choice('messages.audit-status', 2).'</span>' !!}</td> 
                            <td>
                              <a href="{{ URL::to("review/" . $response->id) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i><span> {{ Lang::choice('messages.view', 1) }}</span></a>
                              <a href="{{ URL::to("review/" . $response->id . "/edit") }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i><span> {{ Lang::choice('messages.edit', 1) }}</span></a>
                              @if(Entrust::can('complete-audit'))
                              <a href="{{ URL::to("review/" . $response->id . "/complete") }}" class="btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i><span> {{ Lang::choice('messages.mark-audit-complete', 1) }}</span></a>
                              @endif                         
                              <a class="btn btn-sm btn-default" role="button" data-toggle="modal" data-target="#modal-delete-{{ $response->id }}"><span class="fa fa-download"></span>{!! Lang::choice('messages.download-report', 1) !!}</a>
                              <a href="{{ URL::to("report/" . $response->id) }}" class="btn btn-info btn-sm"><i class="fa fa-bar-chart"></i><span> {{ Lang::choice('messages.run-reports', 1) }}</span></a>
                              <!-- Download modal -->
                            <div class="modal fade" id="modal-delete-{{ $response->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                             <div class="modal-dialog">  
                                <div class="modal-content">                     
                                    <div class="modal-header"> 
                                    {!! Lang::choice('messages.export-document',1) !!}            
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times;</button>
                                    </div>           
                                    <div class="modal-body" style="text-align:center"> 
                                        <a class="btn btn-sm btn-info" id="lab" href="{{ URL::to("review/".$response->id."/export") }}">
                                        <span class="fa fa-external-link"  ></span>
                                        {{ Lang::choice('messages.export-audit', 1) }}
                                         </a>
                                         <a class="btn btn-sm btn-info" href="{{ URL::to("review/".$response->id."/pdfexport") }}">
                                        <span class="fa fa-external-link"></span>
                                        {{ Lang::choice('messages.export-audit-pdf', 1) }}
                                       </a>                    
                                    </div> 
                                 </div>                                           
                                </div>
                            </div>
                            <!-- End of download modal -->
                            </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7">{{ Lang::choice('messages.no-records-found', 1) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>            
        </div>
      </div>
</div>
<!-- Download modal -->
<div class="modal fade export-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">                     
            <div class="modal-header">             
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">                    
                    <{!! Lang::choice('messages.export-document',1).' for <strong id="lab"></strong>' !!}
                    </span>
                </h4>
            </div>           
            <div class="modal-body" style="text-align:center">                       
            <<p></p> 
                <a class="btn btn-sm btn-info" id="lab" href="{{ URL::to("review/".$response->id."/export") }}">
                <span class="fa fa-external-link"  ></span>
                {{ Lang::choice('messages.export-audit', 1) }}
                 </a>
                 <a class="btn btn-sm btn-info" href="{{ URL::to("review/".$response->id."/pdfexport") }}">
                <span class="fa fa-external-link"></span>
                {{ Lang::choice('messages.export-audit-pdf', 1) }}
               </a>           
            </div>        
        </div>
    </div>
</div>
{!! session(['SOURCE_URL' => URL::full()]) !!}
@stop
