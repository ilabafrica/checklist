@section("sidebar")
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
        <a href="#"><i class="fa fa-stack-exchange"></i> {{ Lang::choice('messages.lab-catalog', 1) }}<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li><a href="{{ URL::to('lab')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab', 2) }}</a></li>
            <li><a href="{{ URL::to('labLevel')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-level', 2) }} </a></li>
            <li><a href="{{ URL::to('labAffiliation')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-affiliation', 2) }} </a></li>
            <li><a href="{{ URL::to('labType')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-type', 2) }} </a></li>
            <li><a href="{{ URL::to('country')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.country', 2) }}</a></li>
        </ul>
    </li>
    @if(Entrust::can('manage-audit-config'))
    <li>
        <a href="#"><i class="fa fa-sliders"></i> {{ Lang::choice('messages.audit-config', 1) }}<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li><a href="{{ URL::to('auditType')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.audit-type', 2) }}</a></li>
            <li><a href="{{ URL::to('assessment')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.assessment', 2) }} </a></li>
            <li><a href="{{ URL::to('section')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.section', 2) }} </a></li>
            <li><a href="{{ URL::to('note')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.note', 2) }} </a></li>
            <li><a href="{{ URL::to('answer')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.answer', 2) }} </a></li>
            <li><a href="{{ URL::to('question')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.question', 2) }} </a></li>
            
        </ul>
    </li>
    @endif

    @if(Entrust::can('manage-users'))
    <li>
        <a href="{{ URL::to('user')}}"><i class="fa fa-users"></i> {{ Lang::choice('messages.user', 2) }}</a>
    </li>
    @endif
    
    @if(Entrust::can('manage-audits'))
    <li>
        <a href="{{ URL::to('review')}}"><i class="fa fa-book"></i> {{ Lang::choice('messages.audit', 1) }}</a>
    </li>
    @endif
    @if(Entrust::can('view-reports'))
    <li>
        <a href="{{ route('review.report') }}"><i class="fa fa-bar-chart-o"></i> {{ Lang::choice('messages.reports', 1) }}</a>
    </li>
    @endif
    @if(Entrust::can('manage-access-controls'))
    <li>
        <a href="#"><i class="fa fa-database"></i> {{ Lang::choice('messages.access-controls', 1) }}<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="{{ URL::to('permission')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.permission', 2) }}</a></li>
            <li><a href="{{ URL::to('role')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.role', 2) }}</a></li>
            <li><a href="{{ URL::to('privilege')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.privilege', 2) }}</a></li>
            <li><a href="{{ URL::to('authorization')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.authorization', 2) }}</a></li>
        </ul>
    </li>
    @endif
</ul>
@show
