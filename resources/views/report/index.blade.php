@extends("layout")
@section("content")
<br />
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
            </li>
            <li class="active">{{ Lang::choice('messages.report', 1) }}</li>
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
                <li class="active"><a href="#scores" data-toggle="tab" aria-expanded="true">{!! Lang::choice('messages.audited-score', 1) !!}</a>
                </li>
                <li class=""><a href="#bar" data-toggle="tab" aria-expanded="false">{!! Lang::choice('messages.bar-chart', 1) !!}</a>
                </li>
                <li class=""><a href="#spider" data-toggle="tab" aria-expanded="false">{!! Lang::choice('messages.spider-chart', 1) !!}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="spider" style="padding-top:20px;"></div>
                <div class="tab-pane" id="bar" style="padding-top:20px;"></div>
                <div class="tab-pane fade active in" id="scores" style="padding-top:20px;">
                    <table class="table table-striped table-bordered table-hover ">
                        <thead>
                            <tr><th>{{ Lang::choice('messages.section', 1) }}</th>
                                <th>{{ Lang::choice('messages.label', 1) }}</th>
                                <th>{{ Lang::choice('messages.audited-score', 1) }}</th>
                                <th>{{ Lang::choice('messages.total-points', 1) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $section)
                            <tr>
                                <td>{{ $section->name }}</td>
                                <td>{{ $section->label}}</td>
                                <td>{{ $section->subtotal($review->id)}}</td>
                                <td>{{ $section->total_points }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"><strong>{{ Lang::choice('messages.total-score', 1)  }}</strong></td>
                                <td><strong>{{ $score }}</strong></td>
                                <td><strong>{{ $points }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td class="{!! round($score*100/$points, 2)<55?'warning':'' !!}"><h4>No Stars</h4><p>(0 - 142 pts)</p><p><i>&lt; 55%</i></p></td>
                                <td class="{!! (round($score*100/$points, 2)>=55 && round($score*100/$points, 2)<65)?'warning':'' !!}"><h4>1 Star</h4><p>(143 - 165 pts)</p><p><i>55 - 64%</i></p></td>
                                <td class="{!! (round($score*100/$points, 2)>=65 && round($score*100/$points, 2)<75)?'warning':'' !!}"><h4>2 Stars</h4><p>(166 - 191 pts)</p><p><i>65 - 74%</i></p></td>
                                <td class="{!! (round($score*100/$points, 2)>=75 && round($score*100/$points, 2)<85)?'warning':'' !!}"><h4>3 Stars</h4><p>(192 - 217 pts)</p><p><i>75 - 84%</i></p></td>
                                <td class="{!! (round($score*100/$points, 2)>=85 && round($score*100/$points, 2)<95)?'warning':'' !!}"><h4>4 Stars</h4><p>(218 - 243 pts)</p><p><i>85 - 94%</i></p></td>
                                <td class="{!! round($score*100/$points, 2)>=95?'warning':'' !!}"><h4>5 Stars</h4><p>(244 - 258 pts)</p><p><i>&ge; 95%</i></p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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