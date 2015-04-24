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
    <div class="panel-heading"><i class="fa fa-tags"></i> {{ Lang::choice('messages.response', 1) }} <span class="panel-btn">
    <a class="btn btn-sm btn-info" href="{{ URL::to('review/'.$review->id.'/edit') }}" >
        <i class="fa fa-edit"></i><span> {{ Lang::choice('messages.edit-audit', 1) }}</span>
    </a>
    <a class="btn btn-sm btn-info" href="" >
        <i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span>
    </a>
    </span></div>
    <div class="panel-body">
        <!---------------------------------------------BEGINNING  OF QUESTIONS------------------------------------------------------------ -->

                      @foreach($audit->sections as $section)
                        @if(count($section->children)==0)
                            @if(count($section->notes)>0)
                                @if($section->id == $audit->sections->first()->id)
                                  <img src="{{ Config::get('slipta.slipta-logo') }}" alt="" height="150px" width="" class="img-responsive center-block">
                                  <h1 align="center">{{ Config::get('slipta.slipta') }}</h1>
                                  <h2 align="center">{{ Config::get('slipta.slipta-brief') }}</h2>
                                @endif
                                @foreach($section->notes as $note)
                                  <hr><h4>{!! $note->name !!}</h4><hr>{!! html_entity_decode($note->description) !!}
                                @endforeach
                            @elseif($section->name == Lang::choice('messages.slmta-info', 1))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                          <tr>
                                            <td>{!! Lang::choice('messages.official-slmta', 1) !!}</td>
                                            <td>{!! $review->slmta()->official_slmta == App\Models\Review::OFFICIAL?Lang::choice('messages.yes', 1):Lang::choice('messages.no', 1) !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.audit-start-date', 1) !!}</td>
                                            <td>{!! $review->slmta()->audit_start_date !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.audit-end-date', 1) !!}</td>
                                            <td>{!! $review->slmta()->audit_end_date !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.names-affiliations-of-auditors', 1) !!}</td>
                                            <td>{!! implode(", ", $review->assessors->lists('name')) !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.slmta-audit-type', 1) !!}</td>
                                            <td>{!! $review->assessment($review->slmta()->assessment_id)->name !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.tests-before-slmta', 1) !!}</td>
                                            <td>{!! $review->slmta()->tests_before_slmta !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.tests-this-year', 1) !!}</td>
                                            <td>{!! $review->slmta()->tests_this_year !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.cohort-id', 1) !!}</td>
                                            <td>{!! $review->slmta()->cohort_id !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.slmta-lab-type', 1) !!}</td>
                                            <td>{!! $review->lab->labType->name !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.baseline-audit-date', 1) !!}</td>
                                            <td>{!! $review->slmta()->baseline_audit_date !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.slmta-workshop-date', 1) !!}</td>
                                            <td>{!! $review->slmta()->slmta_workshop_date !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.exit-audit-date', 1) !!}</td>
                                            <td>{!! $review->slmta()->exit_audit_date !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.baseline-score', 1) !!}</td>
                                            <td>{!! $review->slmta()->baseline_score !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.baseline-stars', 1) !!}</td>
                                            <td>{!! $review->stars($review->slmta()->baseline_stars_obtained) !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.exit-score', 1) !!}</td>
                                            <td>{!! $review->slmta()->exit_score !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.exit-stars', 1) !!}</td>
                                            <td>{!! $review->stars($review->slmta()->exit_stars_obtained) !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.last-audit-date', 1) !!}</td>
                                            <td>{!! $review->slmta()->last_audit_date !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.last-audit-score', 1) !!}</td>
                                            <td>{!! $review->slmta()->last_audit_score !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.prior-audit-status', 1) !!}</td>
                                            <td>{!! $review->stars($review->slmta()->prior_audit_status) !!}</td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section->name == Lang::choice('messages.lab-info', 1))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-name', 1) !!}</td>
                                                <td>{!! $review->lab->facility->name !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-number', 1) !!}</td>
                                                <td>{!! $review->lab->id !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-address', 1) !!}</td>
                                                <td>{!! $review->lab->facility->address.'-'.$review->lab->facility->town->postal_code.', '.$review->lab->facility->town->name !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-telephone', 1) !!}</td>
                                                <td>{!! $review->lab->facility->telephone !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-fax', 1) !!}</td>
                                                <td>{!! $review->lab->facility->fax !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-email', 1) !!}</td>
                                                <td>{!! $review->lab->facility->email !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-head', 1) !!}</td>
                                                <td>{!! $review->laboratory()->head !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-head-telephone-personal', 1) !!}</td>
                                                <td>{!! $review->laboratory()->head_personal_telephone !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-head-telephone-work', 1) !!}</td>
                                                <td>{!! $review->laboratory()->head_work_telephone !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-level', 1) !!}</td>
                                                <td>{!! $review->lab->labLevel->name !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-affiliation', 1) !!}</td>
                                                <td>{!! $review->lab->labAffiliation->name !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section->name == Lang::choice('messages.staffing-summary', 1))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><p class="text-muted inline">{!! Lang::choice('messages.profession', 1) !!}</p></td>
                                                <td><p class="text-muted inline">{!! Lang::choice('messages.fulltime-employees', 1) !!}</p></td>
                                                <td><p class="text-muted inline">{!! Lang::choice('messages.adequate', 1) !!}</p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.degree', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->degree_staff !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->degree_staff_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.diploma', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->diploma_staff !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->diploma_staff_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.certificate', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->certificate_staff !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->certificate_staff_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.microscopist', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->microscopist !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->microscopist_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.data-clerk', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->data_clerk !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->data_clerk_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.phlebotomist', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->phlebotomist !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->phlebotomist_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.cleaner', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->cleaner !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->cleaner_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.cleaner-dedicated', 1) !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->cleaner_dedicated) !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.cleaner-trained', 1) !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->cleaner_trained) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.driver', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->driver !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->driver_adequate) !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.driver-dedicated', 1) !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->driver_dedicated) !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.driver-trained', 1) !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->driver_trained) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.other', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory()->other_staff !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->other_staff_adequate) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section->name == Lang::choice('messages.org-structure', 1))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.sufficient-space', 1) !!}</strong></td>
                                                <td>{!! $review->adequate($review->laboratory()->sufficient_space) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.equipment', 1) !!}</strong></td>
                                                <td>{!! $review->adequate($review->laboratory()->equipment) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.supplies', 1) !!}</strong></td>
                                                <td>{!! $review->adequate($review->laboratory()->supplies) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.personnel', 1) !!}</strong></td>
                                                <td>{!! $review->adequate($review->laboratory()->personnel) !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.infrsatructure', 1) !!}</strong></td>
                                                <td>{!! $review->adequate($review->laboratory()->infrastructure) !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! '<strong>'.Lang::choice('messages.other-specify', 1).'</strong> '.$review->laboratory()->other_description !!}</td>
                                                <td>{!! $review->adequate($review->laboratory()->other) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section->name == Lang::choice('messages.criteria-1', 1))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="2"><strong>{!! Lang::choice('messages.criteria-one', 1) !!}</strong></td>
                                                <td><strong>{!! Lang::choice('messages.frequency', 1) !!}</strong></td>
                                            </tr>
                                            @foreach($section->questions as $question)
                                                @if(count($question->children)>0)
                                                    <tr>
                                                        <td><strong>{!! $question->title !!}</strong></td>
                                                        <td>{!! $question->description !!}</td>
                                                        <td>{!! $question->qa($review->id)?App\Models\Answer::find($question->qa($review->id)[0])->name:'' !!}</td>
                                                    </tr>
                                                    @foreach($question->children as $kid)
                                                        <tr>
                                                            <td></td>
                                                            <td>{!! $kid->description !!}</td>
                                                            <td>{!! $kid->qa($review->id)?App\Models\Answer::find($kid->qa($review->id)[0])->name:'' !!}</td>
                                                        </tr>
                                                    @endforeach
                                                @elseif($question->question_type == App\Models\Question::TEXTAREA)
                                                    <tr>
                                                        <td><strong>{!! $question->title !!}</strong></td>
                                                        <td colspan="2">{!! $question->qa($review->id)[0] !!}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section->name == Lang::choice('messages.criteria-2', 1))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.criteria-two', 1) !!}</strong></td>
                                                <td><strong>{!! Lang::choice('messages.date-of-panel-receipt', 1) !!}</strong></td>
                                                <td><strong>{!! Lang::choice('messages.within-days', 1) !!}</strong></td>
                                                <td><strong>{!! Lang::choice('messages.percentage-correct', 1) !!}</strong></td>
                                            </tr>
                                            @foreach($section->questions as $question)
                                              @if(count($question->children)>0)
                                                  <tr>
                                                      <td colspan="4"><strong>{!! $question->title !!}</strong></td>
                                                  </tr>
                                                @foreach($question->children as $kid)
                                                    @if($kid->question_type == App\Models\Question::DATE)
                                                        <tr>
                                                            <td>{!! $kid->title !!}</td>
                                                            <td>{!! $kid->qa($review->id)?$kid->qa($review->id):'' !!}</td>
                                                    @elseif($kid->question_type == App\Models\Question::CHOICE)
                                                        <td>{!! $kid->qa($review->id)?App\Models\Answer::find($kid->qa($review->id)[0])->name:'' !!}</td>
                                                    @elseif($kid->question_type == App\Models\Question::FIELD)
                                                        <td>{!! $kid->qa($review->id)?$kid->qa($review->id):'' !!}</td>
                                                      </tr>
                                                    @endif
                                                @endforeach
                                              @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section->name == Lang::choice('messages.summary', 1))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.commendations', 1) !!}</strong></td>
                                                <td>{!! $review->summary_commendations?$review->summary_commendations:'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.challenges', 1) !!}</strong></td>
                                                <td>{!! $review->summary_challenges?$review->summary_challenges:'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.recommendations', 1) !!}</strong></td>
                                                <td>{!! $review->recommendations?$review->recommendations:'' !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @elseif($section->name == Lang::choice('messages.action-plan', 2))
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.follow-up-actions', 1) !!}</strong></td>
                                                <td><strong>{!! Lang::choice('messages.responsible-persons', 1) !!}</strong></td>
                                                <td><strong>{!! Lang::choice('messages.timeline', 1) !!}</strong></td>
                                            </tr>
                                            @forelse($review->plans() as $plan)
                                            <tr>
                                                <td>{!! $plan->action !!}</td>
                                                <td>{!! $plan->responsible_person !!}</td>
                                                <td>{!! $timeline !!}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">{!! Lang::choice('messages.no-records-found', 1) !!}</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <hr><h4>{!! $section->label !!}</h4><hr>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                <tr>
                                    <th>{!! Lang::choice('messages.count', 1) !!}</th>
                                    <th>{!! Lang::choice('messages.question', 1) !!}</th>
                                    <th>{!! Lang::choice('messages.response', 1) !!}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($section->questions as $question)
                                    @if(count($question->children)>0)
                                    <tr>
                                        <td>{!! $question->id !!}</td>
                                        <td colspan="2"><strong><u>{!! $question->title !!}</u><br />{!! $question->description !!}</strong></td>
                                    </tr>
                                        @foreach($question->children as $kid)
                                            <tr>
                                                <td>{!! $kid->id !!}</td>
                                                <td>{!! $kid->title?'<u><strong>'.$kid->title.'</strong></u><br />':''!!}{!! $kid->description !!}</td>
                                                <td>{!! $kid->qa($review->id)?App\Models\Answer::find((int)$kid->qa($review->id)[0])->name:'' !!}</td>
                                            </tr>
                                        @endforeach
                                    @elseif($question->score != 0)
                                    <tr>
                                        <td>{!! $question->id !!}</td>
                                        <td>{!!$question->title?'<u><strong>'.$question->title.'</strong></u><br />':''!!}<strong>{!! $question->description !!}</strong></td>
                                        <td>{!! $kid->qa($review->id)?App\Models\Answer::find((int)$kid->qa($review->id)[0])->name:'' !!}</td>
                                    </tr>
                                    @endif
                                @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        @endif
                      @endforeach
        <!---------------------------------------------END OF QUESTIONS------------------------------------------------------------ -->
    </div>
</div>
@stop