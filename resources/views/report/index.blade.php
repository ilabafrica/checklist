@extends("layout")
@section("content")
<br />
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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.audit', 2) }}
        <span class="panel-btn">
            <a class="btn btn-sm btn-info" href="{{ URL::to("lab") }}" >
                <span class="glyphicon glyphicon-plus-sign"></span>
                {{ Lang::choice('messages.create-audit', 1) }}
            </a>
            <a class="btn btn-sm btn-info" href="{{ URL::to("review/".$review->id."/export") }}" >
                <span class="fa fa-external-link"></span>
                {{ Lang::choice('messages.export-audit', 1) }}
            </a>
            <a class="btn btn-sm btn-info" href="{{ URL::to("review/".$review->id."/non-compliance") }}" >
                <span class="fa fa-puzzle-piece"></span>
                {{ Lang::choice('messages.non-compliance-report', 1) }}
            </a>
            <a class="btn btn-sm btn-info" href="" onclick="window.history.back();return false;">
                <i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span>
            </a>
        </span>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs default">
                <li class="active"><a href="#bar" data-toggle="tab" aria-expanded="true">{!! Lang::choice('messages.bar-chart', 1) !!}</a>
                </li>
                <li class=""><a href="#spider" data-toggle="tab" aria-expanded="false">{!! Lang::choice('messages.spider-chart', 1) !!}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="spider" style="padding-top:20px;"></div>
                <div class="tab-pane fade active in" id="bar" style="padding-top:20px;"></div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- <script src="{{ URL::asset('admin/js/highcharts.js') }}"></script>
<script src="{{ URL::asset('admin/js/highcharts-more.js') }}"></script>
<script src="{{ URL::asset('admin/js/exporting.js') }}"></script> -->

<script src="{{ URL::asset('fusioncharts/fusioncharts.js') }}"></script>
<script src="{{ URL::asset('fusioncharts/themes/fusioncharts.theme.ocean.js') }}"></script>

<script type="text/javascript">
/* Return bar chart */
FusionCharts.ready(function(){
    var revenueChart = new FusionCharts(<?php echo $options ?>);
  revenueChart.render("bar");
});
/* Return spider chart */
FusionCharts.ready(function(){
    var revenueChart = new FusionCharts(<?php echo $spider ?>);
  revenueChart.render("spider");
});
</script>
@stop