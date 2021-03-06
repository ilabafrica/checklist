@extends("pdflayout")
@section("content")
<br />
<div class="panel panel-primary">  
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
                                            <td>{!! ($review->slmta && $review->slmta->official_slmta == App\Models\Review::OFFICIAL)?Lang::choice('messages.yes', 1):Lang::choice('messages.no', 1) !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.audit-start-date', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->audit_start_date:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.audit-end-date', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->audit_end_date:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.names-affiliations-of-auditors', 1) !!}</td>
                                            <td>{!! $review->assessors?implode(", ", $review->assessors->lists('name')->toArray()):'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.slmta-audit-type', 1) !!}</td>
                                            <td>{!! ($review->slmta && $review->assessment($review->slmta->assessment_id))?$review->assessment($review->slmta->assessment_id)->name:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.tests-before-slmta', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->tests_before_slmta:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.tests-this-year', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->tests_this_year:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.cohort-id', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->cohort_id:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.slmta-lab-type', 1) !!}</td>
                                            <td>{!! $review->lab->labType->name !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.baseline-audit-date', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->baseline_audit_date:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.slmta-workshop-date', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->slmta_workshop_date:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.exit-audit-date', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->exit_audit_date:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.baseline-score', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->baseline_score:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.baseline-stars', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->stars($review->slmta->baseline_stars_obtained):'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.exit-score', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->exit_score:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.exit-stars', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->stars($review->slmta->exit_stars_obtained):'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.last-audit-date', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->last_audit_date:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.last-audit-score', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->slmta->last_audit_score:'' !!}</td>
                                          </tr>
                                          <tr>
                                            <td>{!! Lang::choice('messages.prior-audit-status', 1) !!}</td>
                                            <td>{!! $review->slmta?$review->stars($review->slmta->prior_audit_status):'' !!}</td>
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
                                                <td>{!! $review->lab->name !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-number', 1) !!}</td>
                                                <td>{!! $review->lab->lab_number !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-address', 1) !!}</td>
                                                <td>{!! $review->lab->address.'-'.$review->lab->postal_code.', '.$review->lab->city !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-telephone', 1) !!}</td>
                                                <td>{!! $review->lab->telephone !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-fax', 1) !!}</td>
                                                <td>{!! $review->lab->fax !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-email', 1) !!}</td>
                                                <td>{!! $review->lab->email !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-head', 1) !!}</td>
                                                <td>{!! $review->laboratory?$review->laboratory->head:'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-head-telephone-personal', 1) !!}</td>
                                                <td>{!! $review->laboratory?$review->laboratory->head_personal_telephone:'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! Lang::choice('messages.lab-head-telephone-work', 1) !!}</td>
                                                <td>{!! $review->laboratory?$review->laboratory->head_work_telephone:'' !!}</td>
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
                                                <td>{!! $review->laboratory?$review->laboratory->degree_staff:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->degree_staff_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.diploma', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->diploma_staff:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->diploma_staff_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.certificate', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->certificate_staff:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->certificate_staff_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.microscopist', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->microscopist:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->microscopist_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.data-clerk', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->data_clerk:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->data_clerk_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.phlebotomist', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->phlebotomist:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->phlebotomist_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.cleaner', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->cleaner:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->cleaner_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.cleaner-dedicated', 1) !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->cleaner_dedicated):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.cleaner-trained', 1) !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->cleaner_trained):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.driver', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->driver:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->driver_adequate):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.driver-dedicated', 1) !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->driver_dedicated):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{!! Lang::choice('messages.driver-trained', 1) !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->driver_trained):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.other', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->laboratory->other_staff:'' !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->other_staff_adequate):'' !!}</td>
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
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->sufficient_space):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.equipment', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->equipment):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.supplies', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->supplies):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.personnel', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->personnel):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>{!! Lang::choice('messages.infrsatructure', 1) !!}</strong></td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->infrastructure):'' !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! '<strong>'.Lang::choice('messages.other-specify', 1).'</strong> '.($review->laboratory?$review->laboratory->other_description:'') !!}</td>
                                                <td>{!! $review->laboratory?$review->adequate($review->laboratory->other):'' !!}</td>
                                            </tr>
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
                                                <td>
                                                    @foreach($audit->sections as $part)
                                                        @if(count(array_intersect($questions, $part->questions->lists('id')->toArray()))>0)
                                                          <p>
                                                            <strong>{!! $part->label !!}</strong>
                                                            @foreach($notes as $note)
                                                                @if(in_array(App\Models\ReviewQuestion::find($note->review_question_id)->question_id, $part->questions->lists('id')->toArray()))
                                                                    <br>{!! $note->note !!}
                                                                @endif
                                                            @endforeach
                                                          </p>
                                                        @endif
                                                    @endforeach
                                                </td>
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
                                            @if($review->plans())
                                                @forelse($review->plans() as $plan)
                                                <tr>
                                                    <td>{!! $plan->action !!}</td>
                                                    <td>{!! $plan->responsible_person !!}</td>
                                                    <td>{!! $plan->timeline !!}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3">{!! Lang::choice('messages.no-records-found', 1) !!}</td>
                                                </tr>
                                                @endforelse
                                            @else
                                                <tr>
                                                    <td colspan="3">{!! Lang::choice('messages.no-records-found', 1) !!}</td>
                                                </tr>
                                            @endif
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
                                    <th>{!! Lang::choice('messages.comment', 1) !!}</th>
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
                                                <td>{!! $kid->qa($review->id)?App\Models\Answer::find((int)$kid->qa($review->id))->name:'' !!}</td>
                                                <td>{!! $kid->note($review->id)?$kid->note($review->id)->note:'' !!}</td>
                                            </tr>
                                        @endforeach
                                    @elseif($question->score != 0)
                                    <tr>
                                        <td>{!! $question->id !!}</td>
                                        <td>{!! $question->title?'<u><strong>'.$question->title.'</strong></u><br />':''!!}<strong>{!! $question->description !!}</strong></td>
                                        <td>{!! $question->qa($review->id)?App\Models\Answer::find((int)$question->qa($review->id))->name:'' !!}</td>
                                        <td>{!! $question->note($review->id)?$question->note($review->id)->note:'' !!}</td>
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
