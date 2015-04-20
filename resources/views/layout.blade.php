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
                <a class="navbar-brand" href="#">{{ Config::get('slipta.name') }}</a>
                <a class="navbar-brand" id="menu-toggle" href="#"><i class="fa fa-exchange"></i></a>
            </div>
            <!-- /.navbar-header -->
            <!-- Audit, Lab - Depending on permissions -->
            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <span class="fa fa-clipboard"></span> {{ Lang::choice('messages.audit', 1) }}  <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('lab.index') }}"><span class="fa fa-clipboard"></span> {{ Lang::choice('messages.new-audit', 1) }}</a>
                        </li>
                        <li><a href="#"><span class="fa fa-search"></span> {{ Lang::choice('messages.search-audit', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#" class="text-success"> {{ Lang::choice('messages.with-selected-audit', 1) }}</a>
                        </li>
                        <li><a href="#"><span class="fa fa-smile-o"></span> {{ Lang::choice('messages.show-owners', 1) }}</a>
                        </li>
                        <li><a href="#"><span class="fa fa-book"></span> {{ Lang::choice('messages.view-audit', 1) }}</a>
                        </li>
                        <li><a href="#"><span class="fa fa-pencil"></span> {{ Lang::choice('messages.edit-audit', 1) }}</a>
                        </li>
                        <li><a href="#"><span class="fa fa-external-link"></span> {{ Lang::choice('messages.export-audit', 1) }}</a>
                        </li>
                        <li><a href="#"><span class="fa fa-trash-o"></span> {{ Lang::choice('messages.delete-audit', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"> {{ Lang::choice('messages.change-audit-state', 1) }}</a>
                        </li>
                        <li><a href="#"><span class="fa fa-check-square-o"></span> {{ Lang::choice('messages.mark-audit-complete', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><span class="fa fa-bar-chart-o"></span> {{ Lang::choice('messages.run-reports', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="#"><span class="fa fa-download"></span> {{ Lang::choice('messages.import-audit', 1) }}</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <span class="fa fa-stack-exchange"></span> {{ Lang::choice('messages.lab', 1) }}  <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('lab.create') }}"><span class="fa fa-tag"></span> {{ Lang::choice('messages.new-lab', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ route('lab.index') }}"><span class="fa fa-send"></span> {{ Lang::choice('messages.select-lab', 1) }}</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <span class="fa fa-user"></span> {{ Lang::choice('messages.user', 1) }}  <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('user.create') }}"><span class="glyphicon glyphicon-user"></span> {{ Lang::choice('messages.new-user', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ route('user.index') }}"><span class="fa fa-search"></span> {{ Lang::choice('messages.find-user', 1) }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- End Audit, Lab -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                {!! HTML::image('images/profiles/'.Auth::user()->image, Lang::choice('messages.no-photo-available', 1), array('class'=>'btn btn-default btn-circle')) !!}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('user/'.Auth::user()->id.'/edit') }}"><span class="glyphicon glyphicon-user"></span> {{ Lang::choice('messages.user-profile', 1) }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/auth/logout') }}"><span class="glyphicon glyphicon-log-out"></span> {{ Lang::choice('messages.sign-out', 1) }}</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="{{ url('home') }}"><i class="fa fa-dashboard fa-fw"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> MFL Catalog<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{ URL::to('facility')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.facility', 2) }}</a></li>
                                <li><a href="{{ URL::to('facilityType')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.facility-type', 2) }} </a></li>
                                <li><a href="{{ URL::to('facilityOwner')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.facility-owner', 2) }} </a></li>
                                <li><a href="{{ URL::to('county')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.county', 2) }} </a></li>
                                <li><a href="{{ URL::to('constituency')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.constituency', 2) }} </a></li>
                                <li><a href="{{ URL::to('town')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.town', 2) }} </a></li>
                                <li><a href="{{ URL::to('title')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.title', 2) }} </a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-stack-exchange"></i> Lab Catalog<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{ URL::to('lab')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab', 2) }}</a></li>
                                <li><a href="{{ URL::to('labLevel')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-level', 2) }} </a></li>
                                <li><a href="{{ URL::to('labAffiliation')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-affiliation', 2) }} </a></li>
                                <li><a href="{{ URL::to('labType')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-type', 2) }} </a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sliders"></i> Audit Configuration<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{ URL::to('auditType')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.audit-type', 2) }}</a></li>
                                <li><a href="{{ URL::to('assessment')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.assessment', 2) }} </a></li>
                                <li><a href="{{ URL::to('section')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.section', 2) }} </a></li>
                                <li><a href="{{ URL::to('note')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.note', 2) }} </a></li>
                                <li><a href="{{ URL::to('answer')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.answer', 2) }} </a></li>
                                <li><a href="{{ URL::to('question')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.question', 2) }} </a></li>
                                
                            </ul>
                        </li>
                        <li>
                            <a href="{{ URL::to('user')}}"><i class="fa fa-users"></i> {{ Lang::choice('messages.user', 2) }}</a>
                        </li>
                        @if(Request::segment(1)=="audit")
                        {{--*/ $response = App\Models\AuditResponse::find(Request::segment(2)) /*--}}
                        {{--*/ $auditType = $response->auditType /*--}}
                        {{--*/ $lab = $response->lab /*--}}
                            @if($auditType->id)
                            <li>
                                <a href="#"><i class="fa fa-clipboard"></i> {!! $auditType->name !!}<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level collapse">
                                @foreach($auditType->auditFieldGroup as $fg)
                                    @if(count($fg->children)!=0)
                                    <li>
                                        <a href="#"><i class="fa fa-folder-open"></i> {!! $fg->name !!}<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level collapse">
                                            @foreach($fg->children as $kid)
                                                @if(count($kid->children)!=0)
                                                <li>
                                                    <a href="#"><i class="fa fa-folder-open"></i> {!! $kid->name !!}<span class="fa arrow"></span></a>
                                                    <ul class="nav nav-third-level collapse">
                                                        @foreach($kid->children as $grand)
                                                            <li>
                                                                <a href="{{ url('/audit/'.$response->id.'/create/'.$grand->id) }}"><i class="fa fa-paperclip"></i> {!! $grand->name !!} </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @else
                                                    <li>
                                                        <a href="{{ url('/audit/'.$response->id.'/create/'.$kid->id) }}"><i class="fa fa-paperclip"></i> {!! $kid->name !!} </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @else
                                        <li>
                                            <a href="{{ url('/audit/'.$response->id.'/create/'.$fg->id) }}"><i class="fa fa-paperclip"></i> {!! $fg->name !!} </a>
                                        </li>
                                    @endif
                                @endforeach
                                </ul>
                            </li>
                            @endif
                        @endif
                        <li>
                            <a href="{{ URL::to('review')}}"><i class="fa fa-book"></i> {{ Lang::choice('messages.audit', 2) }}</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('audit')}}"><i class="fa fa-bar-chart-o"></i> Reports</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-database"></i> Access Controls<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="{{ URL::to('permission')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.permission', 2) }}</a></li>
                                <li><a href="{{ URL::to('role')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.role', 2) }}</a></li>
                                <li><a href="{{ URL::to('privilege')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.privilege', 2) }}</a></li>
                                <li><a href="{{ URL::to('authorization')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.authorization', 2) }}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            @yield('content')
        <hr>
        <p>Copyright &copy; {{ date('Y') }} | <a href="http://www.ilabafrica.ac.ke">@iLabAfrica</a></p>
        </div>
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ URL::asset('admin/js/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('admin/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ URL::asset('admin/js/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('admin/js/sb-admin-2.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('admin/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('admin/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('admin/js/moment.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-datepicker.js') }}"></script>
</body>

</html>
