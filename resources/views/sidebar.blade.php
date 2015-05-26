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
        <a href="{!! url('home') !!}"><i class="fa fa-dashboard fa-fw"></i> {{ Lang::choice('messages.dashboard', 1) }}</a>
    </li>
     @if(Entrust::can('manage-facilities'))
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> {{ Lang::choice('messages.mfl-catalog', 1) }}<span class="fa arrow"></span></a>
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
                        @endif
    @if(Entrust::can('manage-labs'))
    <li>
        <a href="#"><i class="fa fa-stack-exchange"></i> {{ Lang::choice('messages.lab-catalog', 1) }}<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li><a href="{!! url('lab') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab', 2) }}</a></li>
            <li><a href="{!! url('labLevel') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-level', 2) }} </a></li>
            <li><a href="{!! url('labAffiliation') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-affiliation', 2) }} </a></li>
            <li><a href="{!! url('labType') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-type', 2) }} </a></li>
            
        </ul>
    </li>
    @endif
    @if(Entrust::can('manage-audit-config'))
    <li>
        <a href="#"><i class="fa fa-sliders"></i> {{ Lang::choice('messages.audit-config', 1) }}<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li><a href="{!! url('auditType') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.audit-type', 2) }}</a></li>
            <li><a href="{!! url('assessment') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.assessment', 2) }} </a></li>
            <li><a href="{!! url('section') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.section', 2) }} </a></li>
            <li><a href="{!! url('note') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.note', 2) }} </a></li>
            <li><a href="{!! url('answer') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.answer', 2) }} </a></li>
            <li><a href="{!! url('question') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.question', 2) }} </a></li>
            
        </ul>
    </li>
    @endif

    @if(Entrust::can('manage-users'))
    <li>
        <a href="{!! url('user') !!}"><i class="fa fa-users"></i> {{ Lang::choice('messages.user', 2) }}</a>
    </li>
    @endif
    
    @if(Entrust::can('manage-audits'))
    <li>
        <a href="{!! url('review') !!}"><i class="fa fa-book"></i> {{ Lang::choice('messages.audit', 1) }}</a>
    </li>
    @endif
    @if(Entrust::can('view-reports'))
    <li>
        <a href="{!! route('review.report') !!}"><i class="fa fa-bar-chart-o"></i> {{ Lang::choice('messages.reports', 1) }}</a>
    </li>
    @endif
    @if(Entrust::can('manage-access-controls'))
    <li>
        <a href="#"><i class="fa fa-database"></i> {{ Lang::choice('messages.access-controls', 1) }}<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="{!! url('permission') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.permission', 2) }}</a></li>
            <li><a href="{!! url('role') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.role', 2) }}</a></li>
            <li><a href="{!! url('privilege') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.privilege', 2) }}</a></li>
            <li><a href="{!! url('authorization') !!}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.authorization', 2) }}</a></li>
        </ul>
    </li>
    @endif
</ul>
@show
