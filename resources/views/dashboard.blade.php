@extends('layout')
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
    <div class="panel-heading "><i class="fa fa-book"></i> Assessment Analytics </div>
    <div class="panel-body">
            
    	<div class="panel-group" id="accordion">
            <div class="panel panel-info">
            	<div class="panel-heading">General Assessment Comparison</div>                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::select('section', array(''=>trans('Select'))+$sections,'', array('class' => 'form-control', 'id' => 'section')) !!}
                        </div>
                        <div class="col-sm-4">
                                {!! Form::select('assessments', array(''=>trans('Select'))+$assessments,'', array('class' => 'form-control', 'id' => 'assessments')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">           
                            <div id="general-pie" style="height: 400px"></div>                
                        </div>
                        <div class="col-sm-4">
                            <div id="general-line" style="height: 400px"></div>                
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading"> Lab Performance</div>                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::select('lab', array(''=>trans('Select'))+$labs,'', array('class' => 'form-control', 'id' => 'lab')) !!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::select('section', array(''=>trans('Select'))+$sections,'', array('class' => 'form-control', 'id' => 'section')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div id="overall-lab-perform" style="height: 400px"></div>                
                        </div>
                        <div class="col-sm-4">
                            <div id="section-lab-perfom" style="height: 400px"></div>                
                        </div>
                    </div>
                </div>
            </div>            
            <div class="panel panel-success">
                <div class="panel-heading"> Lab Comparison</div>                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::label('lab_1', Lang::choice('messages.lab', 2), array('class' => 'col-sm-4 control-label')) !!}
                            {!! Form::select('lab_1', array(''=>trans('Select'))+$labs,'', array('class' => 'form-control', 'id' => 'lab_1')) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('lab_1', Lang::choice('messages.lab', 2), array('class' => 'col-sm-4 control-label')) !!}
                            {!! Form::select('lab_1', array(''=>trans('Select'))+$labs,'', array('class' => 'form-control', 'id' => 'lab_1')) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('assessment', Lang::choice('messages.assessment', 2), array('class' => 'col-sm-4 control-label')) !!}
                            {!! Form::select('assessments', array(''=>trans('Select'))+$assessments,'', array('class' => 'form-control', 'id' => 'assessments')) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('section', Lang::choice('messages.section', 2), array('class' => 'col-sm-4 control-label')) !!}
                            {!! Form::select('section', array(''=>trans('Select'))+$sections,'', array('class' => 'form-control', 'id' => 'section')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div id="lab-comparison" style="height: 400px"></div>                
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('admin/js/highcharts.js') }}"></script>
<script src="{{ URL::asset('admin/js/highcharts-more.js') }}"></script>
<script src="{{ URL::asset('admin/js/exporting.js') }}"></script>
<script type="text/javascript">
    $(function () { 
        $('#general-pie').highcharts( {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'General Performance of all Labs'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'Assessments',
                colorByPoint: true,
                data: [{
                    name: 'Baseline',
                    y: 34
                }, {
                    name: 'Midterm',
                    y: 20
                }, {
                    name: 'Exit',
                    y: 16
                }, {
                    name: 'Surveillance',
                    y: 30
                }]
            }]

        });

        $('#general-line').highcharts( {
            chart: {
                type: 'line'
            },
            title: {
                text: 'General Performance of all Labs'
            },
            xAxis: {
                categories: ['Baseline', 'Midterm', 'Exit', 'Surveillance']
            },
            series: [{
                data: [140, 210, 225, 250],
                name: 'Scores'
            }]

        });

        $('#overall-lab-perform').highcharts( {
            title: {
                text: 'Overall Lab Performance on all Assessements'
            },
            xAxis: {
                categories: ['Baseline', 'Midterm', 'Exit', 'Surveillance']
            },
            series: [{
                data: [140, 210, 225, 250],
                name: 'Scores'
            }]

        });

        $('#section-lab-perfom').highcharts( {
            title: {
                text: 'Lab Performance per Section on each Assessment'
            },
            xAxis: {
                categories: ['Baseline', 'Midterm', 'Exit', 'Surveillance']
            },
            series: [{
                data: [140, 210, 225, 250],
                name: 'Scores'
            }]

        });

        $('#lab-comparison').highcharts( {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Comparison of two Labs Performance per Assessment'
            },
            xAxis: {
                categories: ['Baseline', 'Midterm', 'Exit', 'Surveillance']
            },
            series: [{
                data: [140, 210, 225, 250],
                name: 'Scores'
            }]

        });

    });
</script>
@stop
