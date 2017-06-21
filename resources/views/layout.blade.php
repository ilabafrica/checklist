<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ Config::get('slipta.name') }}</title>

    <!-- Font awesome css -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ URL::asset('admin/css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('admin/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/css/dataTables.bootstrap.css') }}" />
    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/css/datepicker.css') }}" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="{{ URL::asset('admin/js/jquery.min.js') }}"></script>

    <!-- Posabsolute jQuery Validation -->
    <link href="{{ URL::asset('admin/css/validationEngine.jquery.css') }}" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{!! url('home') !!}">{{ Config::get('slipta.name') }}</a>
                <a class="navbar-brand" id="menu-toggle" href="{!! url('home') !!}"><i class="fa fa-exchange"></i></a>
            </div>
            <!-- /.navbar-header -->
            <!-- Audit, Lab - Depending on permissions -->
            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown">
                    @if(Auth::user()->can('manage-audits'))
                    <a href="{!! route('review.index') !!}" role="button" aria-expanded="false">
                        <span class="fa fa-clipboard"></span> {{ Lang::choice('messages.audit', 2) }}
                    </a>
                    @endif
                </li>
                <li class="dropdown">
                   
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <span class="fa fa-stack-exchange"></span> {{ Lang::choice('messages.lab', 1) }}  <span class="caret"></span>
                    </a>
                   
                    <ul class="dropdown-menu">
                        @if(Auth::user()->can('manage-labs'))
                        <li><a href="{!! route('lab.create') !!}"><span class="fa fa-tag"></span> {{ Lang::choice('messages.new-lab', 1) }}</a>
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li><a href="{!! route('lab.index') !!}"><span class="fa fa-send"></span> {{ Lang::choice('messages.select-lab', 1) }}</a>
                        </li>
                    </ul>
                </li>
                @if(Auth::user()->can('manage-users'))
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <span class="fa fa-user"></span> {{ Lang::choice('messages.user', 1) }}  <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{!! route('user.create') !!}"><span class="glyphicon glyphicon-user"></span> {{ Lang::choice('messages.new-user', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{!! route('user.index') !!}"><span class="fa fa-search"></span> {{ Lang::choice('messages.find-user', 1) }}</a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="dropdown">
                    <a href="{!! route('review.report') !!}" role="button" aria-expanded="false">
                        <span class="fa fa-bar-chart"></span> {{ Lang::choice('messages.report', 2) }}
                    </a>
                </li>
            </ul>
            <!-- End Audit, Lab -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                {!! HTML::image('img/profiles/default.png', Lang::choice('messages.no-photo-available', 1), array('class'=>'btn btn-default btn-circle')) !!}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{!! url('user/'.Auth::user()->id.'/edit') !!}"><span class="glyphicon glyphicon-user"></span> {{ Lang::choice('messages.user-profile', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{!! url('/auth/logout') !!}"><span class="glyphicon glyphicon-log-out"></span> {{ Lang::choice('messages.sign-out', 1) }}</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
        <div class="navbar-default sidebar" role="navigation">

           @include("sidebar")
        </div>
         <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            @yield('content')
        <hr>
        <p>{!! date('Y') !!} {!! Lang::choice('messages.compiled-by', 1) !!}</p>
        </div>
    </div>
    <!-- /#wrapper -->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('admin/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ URL::asset('admin/js/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="{{ URL::asset('admin/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('admin/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('admin/js/moment.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-datepicker.js') }}"></script>
    <!-- Posabsolute jQuery validation -->
    <script src="{{ URL::asset('admin/js/jquery.validationEngine-en.js') }}"></script>
    <script src="{{ URL::asset('admin/js/jquery.validationEngine.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sb-admin-2.js') }}"></script>
</body>

</html>
