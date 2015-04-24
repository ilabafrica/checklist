@section("sidebar")
<?php
	$active = array("","","","","","","","","");
	$key = explode("?",str_replace("/", "?", Request::path()));
	switch ($key[0]) {
		case 'home': $active[0] = "active"; break;
		case 'facility': $active[1] = "active"; break;
		case 'permission': $active[2] = "active"; break;
		case 'role':
		case 'privilege':
		case 'authorization': $active[3] = "active"; break;
		case 'user': 
		case 'facilityType': 
		case 'facilityOwner': 
		case 'title': 
		case 'county': 
		case 'constituency':
		case 'town':$active[4] = "active"; break;
		case 'labLevel': 
		case 'labAffiliation': 
		case 'labType':
		case 'lab':
		case 'auditType':
		case 'section':
		case 'auditField':
		case 'review':
		case 'answer':$active[5] = "active"; break;
		case 'note': 
		case 'assessment':
		case 'question': 
		
	}
?>
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
                                <li><a href="{{ URL::to('lab')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab', 2) }}</a></li>
                                <li><a href="{{ URL::to('labLevel')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-level', 2) }} </a></li>
                                <li><a href="{{ URL::to('labAffiliation')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-affiliation', 2) }} </a></li>
                                <li><a href="{{ URL::to('labType')}}"><i class="fa fa-tag"></i> {{ Lang::choice('messages.lab-type', 2) }} </a></li>

                            </ul>
                        </li>
                        @endif
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

                        @if(Entrust::can('manage-audits'))
                        <li>
                            <a href="{{ URL::to('review')}}"><i class="fa fa-book"></i> {{ Lang::choice('messages.audit', 1) }}</a>
                        </li>
                        @endif
                        @if(Entrust::can('view-reports'))
                        <li>
                            <a href="{{ URL::to('audit')}}"><i class="fa fa-bar-chart-o"></i> {{ Lang::choice('messages.reports', 1) }}</a>
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
