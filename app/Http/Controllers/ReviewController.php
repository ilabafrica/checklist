<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use App\Models\AuditType;
use App\Models\Lab;
use App\Models\Section;
use App\Models\Assessment;
use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use App\Models\ReviewSlmtaInfo;
use App\Models\ReviewLabProfile;
use App\Models\ReviewQuestion;
use App\Models\ReviewQAnswer;
use App\Models\ReviewQScore;
use App\Models\ReviewNote;
use App\Models\ReviewActPlan;
use App\Http\Requests\UserListImport;
use Auth;
use Input;
use Lang;
use Request;
use Excel;
use App;
use Session;

class ReviewController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all audit types
		$audits = AuditType::all();
		//	Get all audit responses
		$responses = Review::all();
		return view('audit.review.index', compact('audits', 'responses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id, $section)
	{
		//	Get the page to be loaded
		$page = Section::find($section);
		//	Get review
		$review = Review::find($id);
		//	Get variables ready for processing of new audit
        $audit = AuditType::find($review->audit_type_id);
        $lab = Lab::find($review->lab_id);
        //	Get all SLMTA audit types
        $assessments = Assessment::lists('name', 'id');
        //	Get all SLMTA audit stars
        $stars = array(Review::NOTAUDITED => Lang::choice('messages.not-audited', 1), Review::ZEROSTARS => Lang::choice('messages.zero-stars', 1), Review::ONESTAR => Lang::choice('messages.one-star', 1), Review::TWOSTARS => Lang::choice('messages.two-stars', 1), Review::THREESTARS => Lang::choice('messages.three-stars', 1), Review::FOURSTARS => Lang::choice('messages.four-stars', 1), Review::FIVESTARS => Lang::choice('messages.five-stars', 1));
        //	Get users - to be updated to pick auditors alone
        $assessors = User::all();
        
		return view('audit.review.create', compact('audit', 'lab', 'page', 'review', 'assessments', 'stars', 'assessors'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//dd(Input::all());
		//	Get all SLMTA audit types
        $assessments = Assessment::lists('name', 'id');
        //	Get all SLMTA audit stars
        $stars = array(Review::NOTAUDITED => Lang::choice('messages.not-audited', 1), Review::ZEROSTARS => Lang::choice('messages.zero-stars', 1), Review::ONESTAR => Lang::choice('messages.one-star', 1), Review::TWOSTARS => Lang::choice('messages.two-stars', 1), Review::THREESTARS => Lang::choice('messages.three-stars', 1), Review::FOURSTARS => Lang::choice('messages.four-stars', 1), Review::FIVESTARS => Lang::choice('messages.five-stars', 1));
		//	Get values for creation of audit response
		//	Check if response exists
		$review = Review::find(Input::get('review_id'));
		if(!$review){
			$review = new Review;
	        $review->lab_id = Input::get('lab_id');
	        $review->audit_type_id = Input::get('audit_type_id');
	        $review->status = Review::INCOMPLETE;
	        $review->user_id = Auth::user()->id;
	        $review->update_user_id = Auth::user()->id;
	        try{
				$review->save();
				//$url = Session::get('SOURCE_URL');
			}
			catch(QueryException $e){
				Log::error($e);
			}

	        $audit = AuditType::find($review->audit_type_id);
	        $page = $audit->sections->first()->get();
	    }
	    //	Save Auditors
	    if(Input::get('assessors')){
			$review->setAssessors(array(Input::get('assessors')));
		}
	    //	Check if SLMTA Info exists for the review
	    $slmta = $review->slmta;
	    if(!count($slmta)>0){
	    	$slmtaInfo = new ReviewSlmtaInfo;
	    	$slmtaInfo->review_id = $review->id;
	    	$slmtaInfo->official_slmta = Input::get('official_slmta');
	    	$slmtaInfo->assessment_id = Input::get('assessment_id');
	    	$slmtaInfo->tests_before_slmta  = Input::get('tests_before_slmta');
	    	$slmtaInfo->tests_this_year  = Input::get('tests_this_year');
	    	$slmtaInfo->cohort_id  = Input::get('cohort_id');
	    	$slmtaInfo->baseline_audit_date  = Input::get('baseline_audit_date');
	    	$slmtaInfo->slmta_workshop_date  = Input::get('slmta_workshop_date');
	    	$slmtaInfo->exit_audit_date  = Input::get('exit_audit_date');
	    	$slmtaInfo->baseline_score  = Input::get('baseline_score');
	    	$slmtaInfo->baseline_stars_obtained  = Input::get('baseline_stars');
	    	$slmtaInfo->exit_score  = Input::get('exit_score');
	    	$slmtaInfo->exit_stars_obtained  = Input::get('exit_stars');
	    	$slmtaInfo->last_audit_date  = Input::get('last_audit_date');
	    	$slmtaInfo->last_audit_score  = Input::get('last_audit_score');
	    	$slmtaInfo->prior_audit_status  = Input::get('prior_audit_status');
	    	$slmtaInfo->audit_start_date  = Input::get('audit_start_date');
	    	$slmtaInfo->audit_end_date  = Input::get('audit_end_date');
	    	$slmtaInfo->created_at = date('Y-m-d H:i:s');
	    	$slmtaInfo->updated_at = date('Y-m-d H:i:s');
	    	if(!Input::get('assessment_id'))
				return redirect()->back()->with('error', 'Type of SLMTA audit cannot be empty.');
			else
	    		$slmtaInfo->save();
	    }
	    if(count($slmta)>0){
		    //	Check if Lab Info exists for the review
		    $profile = $review->laboratory;
		    if(!count($profile)>0 && Input::get('head')){
		    	$labProfile = new ReviewLabProfile;
		    	$labProfile->review_id = $review->id;
		    	$labProfile->head = Input::get('head');
		    	$labProfile->head_work_telephone = Input::get('head_work_telephone');
		    	$labProfile->head_personal_telephone = Input::get('head_personal_telephone');
		    	$labProfile->created_at = date('Y-m-d H:i:s');
		    	$labProfile->save();
		    }
		    else if(count($profile)>0){
		    	$labProfile = ReviewLabProfile::find($profile->id);
		    	//	Get elements with values given
		    	if(Input::get('degree_staff'))
		    		$labProfile->degree_staff = Input::get('degree_staff');
		    	if(Input::get('degree_staff_adequate'))
		    		$labProfile->degree_staff_adequate = Input::get('degree_staff_adequate');
		    	if(Input::get('diploma_staff'))
		    		$labProfile->diploma_staff = Input::get('diploma_staff');
		    	if(Input::get('diploma_staff_adequate'))
		    		$labProfile->diploma_staff_adequate = Input::get('diploma_staff_adequate');
		    	if(Input::get('certificate_staff')) 
		    		$labProfile->certificate_staff = Input::get('certificate_staff');
		    	if(Input::get('certificate_staff_adequate'))
		    		$labProfile->certificate_staff_adequate = Input::get('certificate_staff_adequate');
		    	if(Input::get('microscopist'))
		    		$labProfile->microscopist = Input::get('microscopist');
		    	if(Input::get('microscopist_adequate'))
		    		$labProfile->microscopist_adequate = Input::get('microscopist_adequate');
		    	if(Input::get('phlebotomist'))
		    		$labProfile->phlebotomist = Input::get('phlebotomist');
		    	if(Input::get('phlebotomist_adequate'))
		    		$labProfile->phlebotomist_adequate = Input::get('phlebotomist_adequate');
		    	if(Input::get('data_clerk'))
		    		$labProfile->data_clerk = Input::get('data_clerk');
		    	if(Input::get('data_clerk_adequate'))
		    		$labProfile->data_clerk_adequate = Input::get('data_clerk_adequate');
		    	if(Input::get('cleaner'))
		    		$labProfile->cleaner = Input::get('cleaner');
		    	if(Input::get('cleaner_adequate'))
		    		$labProfile->cleaner_adequate = Input::get('cleaner_adequate');
		    	if(Input::get('cleaner_dedicated'))
		    		$labProfile->cleaner_dedicated = Input::get('cleaner_dedicated');
		    	if(Input::get('cleaner_trained'))
		    		$labProfile->cleaner_trained = Input::get('cleaner_trained');
		    	if(Input::get('driver'))
		    		$labProfile->driver = Input::get('driver');
		    	if(Input::get('driver_adequate'))
		    		$labProfile->driver_adequate = Input::get('driver_adequate');
		    	if(Input::get('driver_dedicated'))
		    		$labProfile->driver_dedicated = Input::get('driver_dedicated');
		    	if(Input::get('driver_trained'))
		    		$labProfile->driver_trained = Input::get('driver_trained');
		    	if(Input::get('other_staff'))
		    		$labProfile->other_staff = Input::get('other_staff');
		    	if(Input::get('other_staff_adequate'))
		    		$labProfile->other_staff_adequate = Input::get('other_staff_adequate');
		    	if(Input::get('sufficient_space'))
		    		$labProfile->sufficient_space = Input::get('sufficient_space');
		    	if(Input::get('equipment'))
		    		$labProfile->equipment = Input::get('equipment');
		    	if(Input::get('supplies'))
		    		$labProfile->supplies = Input::get('supplies');
		    	if(Input::get('personnel'))
		    		$labProfile->personnel = Input::get('personnel');
		    	if(Input::get('infrastructure'))
		    		$labProfile->infrastructure = Input::get('infrastructure');
		    	if(Input::get('other'))
		    		$labProfile->other = Input::get('other');
		    	if(Input::get('other_description'))
		    		$labProfile->other_description = Input::get('other_description');
		    	//	Update the lab_profile
		    	$labProfile->updated_at = date('Y-m-d H:i:s');
				if(count($labProfile)>0)
		    		$labProfile->save();
		    }
		}
		//	Store Audit data
		if(Input::get('assessment_data')){
			foreach (Input::all() as $key => $value) {
				if((stripos($key, 'token') !==FALSE) || (stripos($key, 'audit') !==FALSE) || (stripos($key, 'lab') !==FALSE) || (stripos($key, 'review') !==FALSE) || (stripos($key, 'section') !==FALSE) || (stripos($key, 'assessment') !==FALSE) || (stripos($key, 'answer') !==FALSE))
					continue;
				$fieldId = $this->strip($key);
				$rq = ReviewQuestion::where('review_id', $review->id)->where('question_id', $fieldId)->first();
				if(!$rq){
					//	Create review-question
					$rq = new ReviewQuestion;
					$rq->review_id = $review->id;
					$rq->question_id = $fieldId;
					$rq->created_at = date('Y-m-d H:i:s');
					$rq->updated_at = date('Y-m-d H:i:s');
					$rq->save();
				}
				if((stripos($key, 'radio') !==FALSE) || (stripos($key, 'pt') !==FALSE) || (stripos($key, 'date') !==FALSE) || (stripos($key, 'percent') !==FALSE)){
					$rqa = $rq->qa;
					if(!$rqa){
						//	Create review-question-answer
						$rqa = new ReviewQAnswer;
						$rqa->review_question_id = $rq->id;
						$rqa->answer = $value;
						$rqa->created_at = date('Y-m-d H:i:s');
						$rqa->updated_at = date('Y-m-d H:i:s');
						$rqa->save();
					}
					else{
						//	Update review-question-answer
						$rqa = ReviewQAnswer::find($rqa->id);
						$rqa->review_question_id = $rq->id;
						$rqa->answer = $value;
						$rqa->updated_at = date('Y-m-d H:i:s');
						$rqa->save();
					}
				}
				else if(stripos($key, 'text') !==FALSE){
					$rn = $rq->qn;
					$notes = $value;
					if(!$rn){
						//	Create review-note
						$rn = new ReviewNote;
						$rn->review_question_id = $rq->id;
						$rn->note = $notes;
						if(Input::get('check_'.$fieldId))
							$rn->non_compliance = 1;
						$rn->created_at = date('Y-m-d H:i:s');
						$rn->updated_at = date('Y-m-d H:i:s');
						$rn->save();
					}
					else{
						//	Update review-notes
						$rn = ReviewNote::find($rqn->id);
						$rn->review_question_id = $rq->id;
						$rn->note = $notes;
						if(Input::get('check_'.$fieldId))
							$rn->non_compliance = 1;
						$rn->updated_at = date('Y-m-d H:i:s');
						$rn->save();
					}
				}
				else if(stripos($key, 'points') !==FALSE){
					$rqs = $rq->qs;
					$score = $value;
					if(!$rqs){
						//	Create review-question-score
						$rqs = new ReviewQScore;
						$rqs->review_question_id = $rq->id;
						$rqs->audited_score = $score;
						$rqs->created_at = date('Y-m-d H:i:s');
						$rqs->updated_at = date('Y-m-d H:i:s');
						$rqs->save();
					}
					else{
						//	Update review-question-score
						$rqa = ReviewQScore::find($rqs->id);
						$rqa->review_question_id = $rq->id;
						$rqa->audited_score = $score;
						$rqa->updated_at = date('Y-m-d H:i:s');
						$rqa->save();
					}
				}
			}
		}
		//	Save audit summary
		$summary = array();
		if(Input::get('commendations'))
			$review->summary_commendations = Input::get('commendations');
		if(Input::get('challenges'))
			$review->summary_challenges = Input::get('challenges');
		if(Input::get('recommendations'))
			$review->recommendations = Input::get('recommendations');
		$review->updated_at = date('Y-m-d H:i:s');
		$review->save();
	    //	Get variables ready for processing of new audit
        $audit = AuditType::find($review->audit_type_id);
        $lab = Lab::find($review->lab_id);
        $section = Section::find(Input::get('section_id'));
        $page = $section->next()->first();
        //	Redirect to the next page

        if(Request::has('Save')){
        	return redirect('review/'.$review->id.'/edit/'.$section->id);
        }
        else{
        	return redirect('review/create/'.$review->id.'/'.$page->id);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$review = Review::find($id);
		//	Get audit type
		$audit = AuditType::find($review->audit_type_id);
		return view('audit.review.show', compact('review', 'audit'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get values for edition of audit response
		$response = Review::find($id);
        $response->update_user_id = Auth::user()->id;
        $response->update();

        //	Get variables ready for processing of new audit
        $audit = AuditType::find($response->audit_type_id);
        $lab = Lab::find($response->lab_id);
        $page = $audit->sections->first();
        //	Get saved review
        $review = Review::find($response->id);

        return view('audit.review.edit', compact('audit', 'lab', 'page', 'review'));
	}
	/**
	 * Proceed with the amendment
	 *
	 */
	public function amend($id, $section)
	{
		//	Get the page to be loaded
		$page = Section::find($section);
		//	Get review
		$review = Review::find($id);
		//	Get variables ready for processing of new audit
        $audit = AuditType::find($review->audit_type_id);
        $lab = Lab::find($review->lab_id);
        //	Get all SLMTA audit types
        $assessments = Assessment::lists('name', 'id');
        //	Get all SLMTA audit stars
        $stars = array(Review::NOTAUDITED => Lang::choice('messages.not-audited', 1), Review::ZEROSTARS => Lang::choice('messages.zero-stars', 1), Review::ONESTAR => Lang::choice('messages.one-star', 1), Review::TWOSTARS => Lang::choice('messages.two-stars', 1), Review::THREESTARS => Lang::choice('messages.three-stars', 1), Review::FOURSTARS => Lang::choice('messages.four-stars', 1), Review::FIVESTARS => Lang::choice('messages.five-stars', 1));
        //	Get users - to be updated to pick auditors alone
        $assessors = User::all();
        /* Get already saved data */
        //	SLMTA Information
        $slmta = $review->slmta;
        //	Get Lab profile
        $profile = $review->laboratory;
        //	Get radios selected

		return view('audit.review.edit', compact('audit', 'lab', 'page', 'review', 'assessments', 'stars', 'assessors', 'slmta', 'profile'));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//dd(Input::all());
		$review = Review::find($id);
		//	Save Auditors
		if(Input::get('assessors')){
			$review->setAssessors(array(Input::get('assessors')));
		}
		//	Check if SLMTA Info exists for the review
	    $slmta = $review->slmta;
	    if(!count($slmta)>0){
	    	$slmtaInfo = new ReviewSlmtaInfo;
	    	$slmtaInfo->review_id = $review->id;
	    	$slmtaInfo->official_slmta = Input::get('official_slmta');
	    	$slmtaInfo->assessment_id = Input::get('assessment_id');
	    	$slmtaInfo->tests_before_slmta  = Input::get('tests_before_slmta');
	    	$slmtaInfo->tests_this_year  = Input::get('tests_this_year');
	    	$slmtaInfo->cohort_id  = Input::get('cohort_id');
	    	$slmtaInfo->baseline_audit_date  = Input::get('baseline_audit_date');
	    	$slmtaInfo->slmta_workshop_date  = Input::get('slmta_workshop_date');
	    	$slmtaInfo->exit_audit_date  = Input::get('exit_audit_date');
	    	$slmtaInfo->baseline_score  = Input::get('baseline_score');
	    	$slmtaInfo->baseline_stars_obtained  = Input::get('baseline_stars');
	    	$slmtaInfo->exit_score  = Input::get('exit_score');
	    	$slmtaInfo->exit_stars_obtained  = Input::get('exit_stars');
	    	$slmtaInfo->last_audit_date  = Input::get('last_audit_date');
	    	$slmtaInfo->last_audit_score  = Input::get('last_audit_score');
	    	$slmtaInfo->prior_audit_status  = Input::get('prior_audit_status');
	    	$slmtaInfo->audit_start_date  = Input::get('audit_start_date');
	    	$slmtaInfo->audit_end_date  = Input::get('audit_end_date');
	    	$slmtaInfo->created_at = date('Y-m-d H:i:s');
	    	$slmtaInfo->updated_at = date('Y-m-d H:i:s');
	    	if(!Input::get('assessment_id'))
				return redirect()->back()->with('error', 'Type of SLMTA audit cannot be empty.');
			else
	    		$slmtaInfo->save();
	    }
	    if(count($slmta)>0){
		    //	Check if Lab Info exists for the review
		    $profile = $review->laboratory;
		    if(!count($profile)>0 && Input::get('head')){
		    	$labProfile = new ReviewLabProfile;
		    	$labProfile->review_id = $review->id;
		    	$labProfile->head = Input::get('head');
		    	$labProfile->head_work_telephone = Input::get('head_work_telephone');
		    	$labProfile->head_personal_telephone = Input::get('head_personal_telephone');
		    	$labProfile->created_at = date('Y-m-d H:i:s');
		    	$labProfile->save();
		    }
		    else if(count($profile)>0){
		    	$labProfile = ReviewLabProfile::find($profile->id);
		    	//	Get elements with values given
		    	if(Input::get('degree_staff'))
		    		$labProfile->degree_staff = Input::get('degree_staff');
		    	if(Input::get('degree_staff_adequate'))
		    		$labProfile->degree_staff_adequate = Input::get('degree_staff_adequate');
		    	if(Input::get('diploma_staff'))
		    		$labProfile->diploma_staff = Input::get('diploma_staff');
		    	if(Input::get('diploma_staff_adequate'))
		    		$labProfile->diploma_staff_adequate = Input::get('diploma_staff_adequate');
		    	if(Input::get('certificate_staff')) 
		    		$labProfile->certificate_staff = Input::get('certificate_staff');
		    	if(Input::get('certificate_staff_adequate'))
		    		$labProfile->certificate_staff_adequate = Input::get('certificate_staff_adequate');
		    	if(Input::get('microscopist'))
		    		$labProfile->microscopist = Input::get('microscopist');
		    	if(Input::get('microscopist_adequate'))
		    		$labProfile->microscopist_adequate = Input::get('microscopist_adequate');
		    	if(Input::get('phlebotomist'))
		    		$labProfile->phlebotomist = Input::get('phlebotomist');
		    	if(Input::get('phlebotomist_adequate'))
		    		$labProfile->phlebotomist_adequate = Input::get('phlebotomist_adequate');
		    	if(Input::get('data_clerk'))
		    		$labProfile->data_clerk = Input::get('data_clerk');
		    	if(Input::get('data_clerk_adequate'))
		    		$labProfile->data_clerk_adequate = Input::get('data_clerk_adequate');
		    	if(Input::get('cleaner'))
		    		$labProfile->cleaner = Input::get('cleaner');
		    	if(Input::get('cleaner_adequate'))
		    		$labProfile->cleaner_adequate = Input::get('cleaner_adequate');
		    	if(Input::get('cleaner_dedicated'))
		    		$labProfile->cleaner_dedicated = Input::get('cleaner_dedicated');
		    	if(Input::get('cleaner_trained'))
		    		$labProfile->cleaner_trained = Input::get('cleaner_trained');
		    	if(Input::get('driver'))
		    		$labProfile->driver = Input::get('driver');
		    	if(Input::get('driver_adequate'))
		    		$labProfile->driver_adequate = Input::get('driver_adequate');
		    	if(Input::get('driver_dedicated'))
		    		$labProfile->driver_dedicated = Input::get('driver_dedicated');
		    	if(Input::get('driver_trained'))
		    		$labProfile->driver_trained = Input::get('driver_trained');
		    	if(Input::get('other_staff'))
		    		$labProfile->other_staff = Input::get('other_staff');
		    	if(Input::get('other_staff_adequate'))
		    		$labProfile->other_staff_adequate = Input::get('other_staff_adequate');
		    	if(Input::get('sufficient_space'))
		    		$labProfile->sufficient_space = Input::get('sufficient_space');
		    	if(Input::get('equipment'))
		    		$labProfile->equipment = Input::get('equipment');
		    	if(Input::get('supplies'))
		    		$labProfile->supplies = Input::get('supplies');
		    	if(Input::get('personnel'))
		    		$labProfile->personnel = Input::get('personnel');
		    	if(Input::get('infrastructure'))
		    		$labProfile->infrastructure = Input::get('infrastructure');
		    	if(Input::get('other'))
		    		$labProfile->other = Input::get('other');
		    	if(Input::get('other_description'))
		    		$labProfile->other_description = Input::get('other_description');
		    	//	Update the lab_profile
		    	$labProfile->updated_at = date('Y-m-d H:i:s');
				if(count($labProfile)>0)
		    		$labProfile->save();
		    }
		}
		//	Store Audit data
		if(Input::get('assessment_data')){
			foreach (Input::all() as $key => $value) {
				if((stripos($key, 'token') !==FALSE) || (stripos($key, 'audit') !==FALSE) || (stripos($key, 'lab') !==FALSE) || (stripos($key, 'review') !==FALSE) || (stripos($key, 'section') !==FALSE) || (stripos($key, 'assessment') !==FALSE) || (stripos($key, 'answer') !==FALSE) || (stripos($key, 'method') !==FALSE))
					continue;
				$fieldId = $this->strip($key);
				$rq = ReviewQuestion::where('review_id', $review->id)->where('question_id', $fieldId)->first();
				if(!$rq){
					//	Create review-question
					$rq = new ReviewQuestion;
					$rq->review_id = $review->id;
					$rq->question_id = $fieldId;
					$rq->created_at = date('Y-m-d H:i:s');
					$rq->updated_at = date('Y-m-d H:i:s');
					$rq->save();
				}
				if((stripos($key, 'radio') !==FALSE) || (stripos($key, 'pt') !==FALSE) || (stripos($key, 'date') !==FALSE) || (stripos($key, 'percent') !==FALSE)){
					$rqa = $rq->qa;
					if(!$rqa){
						//	Create review-question-answer
						$rqa = new ReviewQAnswer;
						$rqa->review_question_id = $rq->id;
						$rqa->answer = $value;
						$rqa->created_at = date('Y-m-d H:i:s');
						$rqa->updated_at = date('Y-m-d H:i:s');
						$rqa->save();
					}
					else{
						//	Update review-question-answer
						$rqa = ReviewQAnswer::find($rqa->id);
						$rqa->review_question_id = $rq->id;
						$rqa->answer = $value;
						$rqa->updated_at = date('Y-m-d H:i:s');
						$rqa->save();
					}
				}
				else if(stripos($key, 'text') !==FALSE){
					$rqn = $rq->qn;
					$notes = $value;
					if(!$rqn){
						//	Create review-note
						$rn = new ReviewNote;
						$rn->review_question_id = $rq->id;
						$rn->note = $notes;
						if(Input::get('check_'.$fieldId))
							$rn->non_compliance = 1;
						$rn->created_at = date('Y-m-d H:i:s');
						$rn->updated_at = date('Y-m-d H:i:s');
						$rn->save();
					}
					else{
						//	Update review-notes
						$rn = ReviewNote::find($rqn->id);
						$rn->review_question_id = $rq->id;
						$rn->note = $notes;
						if(Input::get('check_'.$fieldId))
							$rn->non_compliance = 1;
						$rn->updated_at = date('Y-m-d H:i:s');
						$rn->save();
					}
				}
				else if(stripos($key, 'points') !==FALSE){
					$rqs = $rq->qs;
					$score = $value;
					if(!$rqs){
						//	Create review-question-score
						$rqs = new ReviewQScore;
						$rqs->review_question_id = $rq->id;
						$rqs->audited_score = $score;
						$rqs->created_at = date('Y-m-d H:i:s');
						$rqs->updated_at = date('Y-m-d H:i:s');
						$rqs->save();
					}
					else{
						//	Update review-question-score
						$rqs = ReviewQScore::find($rqs->id);
						$rqs->review_question_id = $rq->id;
						$rqs->audited_score = $score;
						$rqs->updated_at = date('Y-m-d H:i:s');
						$rqs->save();
					}
				}
			}
		}
		//	Save audit summary
		$summary = array();
		if(Input::get('commendations'))
			$review->summary_commendations = Input::get('commendations');
		if(Input::get('challenges'))
			$review->summary_challenges = Input::get('challenges');
		if(Input::get('recommendations'))
			$review->recommendations = Input::get('recommendations');
		$review->updated_at = date('Y-m-d H:i:s');
		$review->save();
	    //	Get variables ready for processing of new audit
        $audit = AuditType::find($review->audit_type_id);
        $lab = Lab::find($review->lab_id);
        $section = Section::find(Input::get('section_id'));
        $page = $section->next()->first();
        //	Redirect to the next page
        if(Request::has('Save')){
        	return redirect('review/'.$review->id.'/edit/'.$section->id);
        }
        else{
        	return redirect('review/'.$review->id.'/edit/'.$page->id);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	/**
	 * Start the assessment by saving the first cumpulsory fields
	 *
	 */
	public function start()
	{
		//	Get values for creation of audit response
		$response = new Review;
        $response->lab_id = Input::get('lab_id');
        $response->audit_type_id = Input::get('audit_type_id');
        $response->status = Review::INCOMPLETE;
        $response->user_id = Auth::user()->id;
        $response->update_user_id = Auth::user()->id;
        $response->save();

        //	Get variables ready for processing of new audit
        $audit = AuditType::find($response->audit_type_id);
        $lab = Lab::find($response->lab_id);
        $page = $audit->sections->first();
        //	Get saved review
        $review = Review::find($response->id);

        return view('audit.review.create', compact('audit', 'lab', 'page', 'review'));
	}
	
	/**
	 * Remove the specified begining of text to get Id alone.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function strip($field)
	{
		if(($pos = strpos($field, '_')) !== FALSE)
		return substr($field, $pos+1);
	}
	/**
	 * Return assessments based on selected audit type
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function assessments($id=NULL)
	{
		if ($id==NULL){
			//	Get all audits
			$responses = Review::all();
		}
		else{
			$audit = AuditType::find($id);
			$responses = $audit->reviews;
			$id=$audit->id;
		}
		return view('audit.review.review', compact('responses', 'id'));
	}
	/**
	 * Saves the review's action plan submitted via ajax
	 *
	 */
	public function plan(){
		$action = Input::get('action');
		$review_id = Input::get('review_id');
		$follow_up_action = Input::get('follow_up_action');
		$responsible_person = Input::get('responsible_person');
		$timeline = Input::get('timeline');
		$plan = array();
		$id = Input::get('id');
		if($action == 'add'){
			$plan = new ReviewActPlan;
			$plan->review_id = $review_id;
			$plan->action = $follow_up_action;
			$plan->responsible_person = $responsible_person;
			$plan->timeline = $timeline;
			$plan->created_at = date('Y-m-d H:i:s');
			$plan->updated_at = date('Y-m-d H:i:s');
			$plan->save();
			return 0;
		}
		else if($action == 'update'){
			$plan = ReviewActPlan::find($id);
			if($follow_up_action)
				$plan->action = $follow_up_action;
			if($responsible_person)
				$plan->responsible_person = $responsible_person;
			if($timeline)
				$plan->timeline = $timeline;
			$plan->updated_at = date('Y-m-d H:i:s');
			$plan->save();
		}
		else if($action == 'draw'){
			$plans = Review::find($review_id)->plans;

			return json_encode($plans);
		}
	}
	/**
	 * Retrieve Summary by audit type
	 *
	 */
	public function summary($id){
		//	Get audit type
		$audit = AuditType::find($id);
		//	Get counts grouped by user
		$reviews = $audit->reviews->groupBy('user_id');
		//	Get all users
		$users = User::all();
		return view('audit.review.summary', compact('audit', 'users'));
	}
	/**
	 * Mark audit as complete
	 *
	 */
	public function complete($id){
		//	Get review
		$review = Review::find($id);
		$categories = array();
		$questions = array();
		$scored_questions = array(); 
		$rqs = $review->rq;
		foreach ($rqs as $rq) {
			if($rq->qa)
				array_push($scored_questions, $rq);
			else
				continue;
		}
		$sections = $review->auditType->sections;
		foreach($sections as $section){
			if($section->total_points!=0)
				array_push($categories, $section);
			else
				continue;
		}
		foreach ($categories as $section) {
			foreach($section->questions as $question){
				if($question->score>0)
					array_push($questions, $question);
				else
					continue;
			}
		}
		if(count($questions) == count($scored_questions)){
			$review->status = Review::COMPLETE;
			$review->updated_at = date('Y-m-d H:i:s');
        	return redirect()->to('review/assessment/'.$review->audit_type_id)->with('message', 'Audit marked complete')->with('active_review', $review->id);
		}
		else{
			return view('audit.review.complete', compact('review', 'categories'));
		}
	}
	/**
	 * Display view for file input
	 *
	 */
	public function import($id){
		//	Get audit type
		$audit = AuditType::find($id);
		$message = '';
		return view('audit.review.import', compact('audit', 'message'));
	}
	public function check($products, $field)
	{
	   foreach($products as $key => $product)
	   {
	      if ( $key )
	         return $products[$product];
	   }
	   return false;
	}
	/**
	 * Import the audit data
	 *
	 */
	public function importUserList()
    {
    	//	Get the audit type
    	$audit_type_id = AuditType::find(Input::get('audit_type_id'))->id;
    	//	Declare variable to hold review_id
    	$review_id = NULL;
    	// 	Handle the import
        // 	Get the results
        // 	Import a user provided file
        $file = Input::file('excel');
        $ext = $file->getClientOriginalExtension();
        $excel = uniqid().'.'.$ext;
        $filename = $file->move('uploads/', $excel);
        //	Convert file to csv
        Excel::load('/public/uploads/'.$excel, function($reader) use($audit_type_id, $review_id){
        	$laboratory_profile = $reader->get()[0];
        	$staffing_summary = $reader->get()[1];
        	$organizational_structure = $reader->get()[2];
        	$slmta_information = $reader->get()[3];
        	$assessment = $reader->get()[4];
        	$scores = $reader->get()[5];
        	$summary = $reader->get()[6];
        	$action_plan = $reader->get()[7];
        	//	Initialize variables
        	$labName = $reader->first()[0]->value;
	        $lab_id = Lab::labIdName($labName);
	        $review = Review::where('lab_id', $lab_id)->where('audit_type_id', $audit_type_id)->first();
	        //	Check if review exists
			if(!$review){
				//	Create new review
				$review = new Review;
				$review->lab_id = $lab_id;
		        $review->audit_type_id = $audit_type_id;
		        $review->status = Review::INCOMPLETE;
		        $review->user_id = Auth::user()->id;
		        $review->update_user_id = Auth::user()->id;
		        try{
					$review->save();
					//$url = Session::get('SOURCE_URL');
				}
				catch(QueryException $e){
					Log::error($e);
				}
			}
			//	Get review id
			$review_id = $review->id;

        	$reader->each(function($sheet) use($review_id, $laboratory_profile, $staffing_summary, $organizational_structure, $slmta_information, $assessment, $scores, $summary, $action_plan){
        		$sheetTitle = $sheet->getTitle();
        		if($sheetTitle == Lang::choice('messages.lab-info', 2)){
        			$counter = count($sheet);
        			$head = NULL;
					$head_personal_telephone = NULL;
					$head_work_telephone = NULL;
					//	Check if Lab Info exists for the review
		    		$lab_profile = $review->laboratory;
		    		if(!count($lab_profile)){
				    	$lab_profile = new ReviewLabProfile;
				    	$lab_profile->review_id = $review_id;
				    	$lab_profile->created_at = date('Y-m-d H:i:s');
				    	$lab_profile->save();
				    }
					for($i=0;$i<$counter;$i++){
        				//	Save Laboratory Profile		    
						if($sheet[$i]->field == Lang::choice('messages.lab-head', 1)){
							$lab_profile->head = $sheet[$i]->value;
						}
						if($sheet[$i]->field == Lang::choice('messages.lab-head-telephone-personal', 1)){
							$lab_profile->head_personal_telephone = $sheet[$i]->value;
						}
						if($sheet[$i]->field == Lang::choice('messages.lab-head-telephone-work', 1)){
							$lab_profile->head_work_telephone = $sheet[$i]->value;
						}
        			}
        			$lab_profile->updated_at = date('Y-m-d H:is:s');
        			$lab_profile->save();
        		}
        		//	Staffing Summary
        		else if($sheetTitle == Lang::choice('messages.staffing-summary', 1)){
        			//	Initialize counter
        			$counter = count($staffing_summary);
        			//dd($counter);
        			//	Variables
        			$degree = NULL;
    				$degree_adequate = NULL;
    				$diploma = NULL;
    				$diploma_adequate = NULL;
    				$certificate = NULL;
    				$certificate_adequate = NULL;
    				$microscopist = NULL;
    				$microscopist_adequate = NULL;
    				$data_clerk = NULL;
    				$data_clerk_adequate = NULL;
    				$phlebotomist = NULL;
    				$phlebotomist_adequate = NULL;
    				$cleaner = NULL;
    				$cleaner_adequate = NULL;
    				$cleaner_dedicated = NULL;
    				$cleaner_trained = NULL;
    				$driver = NULL;
    				$driver_adequate = NULL;
    				$driver_dedicated = NULL;
    				$driver_trained = NULL;
    				$other_staff = NULL;
    				$other_staff_adequate = NULL;
    				//	Check lab profile
    				$lab_profile = $review->laboratory;
		    		if(!count($lab_profile)){
				    	$lab_profile = new ReviewLabProfile;
				    	$lab_profile->review_id = $review_id;
				    	$lab_profile->created_at = date('Y-m-d H:i:s');
				    	$lab_profile->save();
				    }
					//	Begin saving
        			for($i=0;$i<$counter;$i++){
        				if($staffing_summary[$i]->profession == Lang::choice('messages.degree', 1)){
							$lab_profile->degree_staff = $staffing_summary[$i]->employees;
							$lab_profile->degree_staff_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.diploma', 1)){
							$lab_profile->diploma_staff = $staffing_summary[$i]->employees;
							$lab_profile->diploma_staff_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.certificate', 1)){
							$lab_profile->certificate_staff = $staffing_summary[$i]->employees;
							$lab_profile->certificate_staff_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.microscopist', 1)){
							$lab_profile->microscopist = $staffing_summary[$i]->employees;
							$lab_profile->microscopist_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.data-clerk', 1)){
							$lab_profile->data_clerk = $staffing_summary[$i]->employees;
							$lab_profile->data_clerk_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.phlebotomist', 1)){
							$lab_profile->phlebotomist = $staffing_summary[$i]->employees;
							$lab_profile->phlebotomist_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.cleaner', 1)){
							$lab_profile->cleaner = $staffing_summary[$i]->employees;
							$lab_profile->cleaner_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.cleaner-dedicated', 1)){
							$lab_profile->cleaner_dedicated = Answer::adequate($staffing_summary[$i]->employees);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.cleaner-trained', 1)){
							$lab_profile->cleaner_trained = Answer::adequate($staffing_summary[$i]->employees);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.driver', 1)){
							$lab_profile->driver = $staffing_summary[$i]->employees;
							$lab_profile->driver_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.driver-dedicated', 1)){
							$lab_profile->driver_dedicated = Answer::adequate($staffing_summary[$i]->employees);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.driver-trained', 1)){
							$lab_profile->driver_trained = Answer::adequate($staffing_summary[$i]->employees);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.other', 1)){
							$lab_profile->other_staff = $staffing_summary[$i]->employees;
							$lab_profile->other_staff_adequate = Answer::adequate($staffing_summary[$i]->adequate);
						}
        			}
        			$lab_profile->updated_at = date('Y-m-d H:i:s');
        			$lab_profile->save();
        		}
        		//	Organizational structure
        		else if($sheetTitle == Lang::choice('messages.org-structure', 2)){
        			$counter = count($organizational_structure);
        			//	Declare variables
        			$sufficient_space = NULL;
        			$equipment = NULL;
        			$supplies = NULL;
        			$personnel = NULL;
        			$infrastructure = NULL;
        			$other = NULL;
        			$other_description = NULL;
        			//	Check lab profile
    				$lab_profile = $review->laboratory;
		    		if(!count($lab_profile)){
				    	$lab_profile = new ReviewLabProfile;
				    	$lab_profile->review_id = $review_id;
				    	$lab_profile->created_at = date('Y-m-d H:i:s');
				    	$lab_profile->save();
				    }
					//	Begin saving
        			for($i=0;$i<$counter;$i++){
        				if($organizational_structure[$i]->field == Lang::choice('messages.sufficient-space', 1)){
							$lab_profile->sufficient_space = Answer::adequate($organizational_structure[$i]->value);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.equipment', 1)){
							$lab_profile->equipment = Answer::adequate($organizational_structure[$i]->value);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.supplies', 1)){
							$lab_profile->supplies = Answer::adequate($organizational_structure[$i]->value);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.personnel', 1)){
							$lab_profile->personnel = Answer::adequate($organizational_structure[$i]->value);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.infrastructure', 1)){
							$lab_profile->infrastructure = Answer::adequate($organizational_structure[$i]->value);
						}
						if(strpos($organizational_structure[$i]->field, Lang::choice('messages.other-specify', 1)) !== FALSE){
							$lab_profile->other = Answer::adequate($organizational_structure[$i]->value);
							if(($pos = strpos($organizational_structure[$i]->field, ':')) !== FALSE)
								$other_description = substr($organizational_structure[$i]->field, $pos+2);
							$lab_profile->other_description = trim($other_description);
						}
        			}
        			$lab_profile->updated_at = date('Y-m-d H:i:s');
				    $lab_profile->save();
        		}
        		//	SLMTA Information
        		else if($sheetTitle == Lang::choice('messages.slmta-info', 2)){
        			$counter = count($slmta_information);
        			//	Variables declaration
        			$official_slmta = NULL;
        			$assessment_id = NULL;
        			$tests_before_slmta = NULL;
        			$tests_this_year = NULL;
        			$cohort_id = NULL;
        			$baseline_audit_date = NULL;
        			$slmta_workshop_date = NULL;
        			$exit_audit_date = NULL;
        			$baseline_score = NULL;
        			$baseline_stars_obtained = NULL;
        			$exit_score = NULL;
        			$exit_stars_obtained = NULL;
        			$last_audit_date = NULL;
        			$last_audit_score = NULL;
        			$prior_audit_status = NULL;
        			$audit_start_date = NULL;
        			$audit_end_date = NULL;
        			$array = array();
        			$assessors = array();
        			//	Check SLMTA Info
    				//	Check if SLMTA Info exists for the review
				    $slmta = $review->slmta;
				    if(!count($slmta)>0)
				    	$slmta = new ReviewSlmtaInfo;
    				//	Begin saving
					for($i=0;$i<$counter;$i++){
						if($slmta_information[$i]->field == Lang::choice('messages.slmta-audit-type', 1)){
							$slmta->assessment_id = Assessment::idByName($slmta_information[$i]->value);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.official-slmta', 1)){
		    				$slmta->official_slmta = Answer::adequate($slmta_information[$i]->value);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.audit-start-date', 1)){
		    				$slmta->audit_start_date = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.audit-end-date', 1)){
		    				$slmta->audit_end_date = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.tests-before-slmta', 1)){
		    				$slmta->tests_before_slmta = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.tests-this-year', 1)){
		    				$slmta->tests_this_year = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.cohort-id', 1)){
		    				$slmta->cohort_id = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.baseline-audit-date', 1)){
		    				$slmta->baseline_audit_date = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.slmta-workshop-date', 1)){
		    				$slmta->slmta_workshop_date = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.exit-audit-date', 1)){
		    				$slmta->exit_audit_date = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.baseline-score', 1)){
		    				$slmta->baseline_score = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.baseline-stars', 1)){
		    				$slmta->baseline_stars = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.exit-score', 1)){
		    				$slmta->exit_score = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.exit-stars', 1)){
		    				$slmta->exit_stars = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.last-audit-date', 1)){
		    				$slmta->last_audit_date = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.last-audit-score', 1)){
		    				$slmta->last_audit_score = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.prior-audit-status', 1)){
		    				$slmta->prior_audit_status = $slmta_information[$i]->value;
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.names-affiliations-of-auditors', 1)){
		    				foreach(explode(',', $slmta_information[$i]->value) as $assessor){
		    					$assessors = array_push($assessors, User::userIdName($assessor));
		    				}
		    			}
					}
					Review::find($review_id)->setAssessors([$assessors]);
					$slmta->created_at = date('Y-m-d H:i:s');
					$slmta->updated_at = date('Y-m-d H:i:s');
					$slmta->save();
        		}
        		//	Summary of Audit Findings
        		else if($sheetTitle == 'Summary of Assessment Findings'){
        			$counter = count($summary);
        			$commendations = NULL;
        			$challenges = NULL;
        			$recommendations = NULL;
        			$array = array();
        			$review = Review::find($review_id);
        			//	Update review data
        			for($i=0; $i<$counter; $i++){
        				if($summary[$i]->field == Lang::choice('messages.commendations', 1)){
        					$review->summary_commendations = $summary[$i]->value;
        				}
        				if($summary[$i]->field == Lang::choice('messages.challenges', 1)){
        					$review->summary_challenges = $summary[$i]->value;
        				}
        				if($summary[$i]->field == Lang::choice('messages.recommendations', 1)){
        					$review->recommendations = $summary[$i]->value;
        				}
        			}
        			$review->updated_at = date('Y-m-d H:i:s');
        			$review->save();
        		}
        		//	Action Plan
        		else if($sheetTitle == 'Action Plan'){
        			$counter = count($summary);
        			$array = array();
        			if($counter>0){
	        			for($i=0; $i<$counter; $i++){
	        				$plans = Review::find($review_id)->plans->where('action', $summary[$i]->action)->where('responsible_person', $summary[$i]->incharge)->where('timeline', $summary[$i]->timeline)->first();
		        			if(count($plans==0)){
		        				if($summary[$i]->action!=NULL || $summary[$i]->incharge!=NULL || $summary[$i]->timeline!=NULL){
		        					$plan = new ReviewActPlan;
		        					$plan->review_id = $review_id;
		        					$plan->action = $summary[$i]->action;
		        					$plan->responsible_person = $summary[$i]->incharge;
		        					$plan->timeline = $summary[$i]->timeline;
		        					$plan->created_at = date('Y-m-d H:i:s');
		        					$plan->updated_at = date('Y-m-d H:i:s');
		        					$plan->save();
		        				}
		        			}
		        			else{
		        				$plan = ReviewActPlan::find($plans->id);
		        				$plan->review_id = $review_id;
	        					$plan->action = $summary[$i]->action;
	        					$plan->responsible_person = $summary[$i]->incharge;
	        					$plan->timeline = $summary[$i]->timeline;
	        					$plan->updated_at = date('Y-m-d H:i:s');
	        					$plan->save();
		        			}
		        		}
	        		}
        		}
        		//	Assessment data
        		else if($sheetTitle == 'Assessment Details'){
        			$counter = count($assessment);
        			if($counter>0){
	        			for($i=0; $i<$counter; $i++){
	        				$rq = ReviewQuestion::where('review_id', $review_id)->where('question_id', $assessment[$i]->question)->first();
							if(!$rq){
								//	Create review-question
								$rq = new ReviewQuestion;
								$rq->review_id = $review_id;
								$rq->question_id = $scores[$i]->question;
								$rq->created_at = date('Y-m-d H:i:s');
								$rq->updated_at = date('Y-m-d H:i:s');
								$rq->save();
							}
							$rqa = $rq->qa;
							$rqn = $rq->qn;
	        				$question = Question::find((int)$assessment[$i]->question);
		        			if(count($question->children)>0){
		        				continue;
		        			}
		        			else{
		        				if(!$rqa){
									//	Create review-question-answer
									$rqa = new ReviewQAnswer;
									$rqa->review_question_id = $rq->id;
									$rqa->answer = Answer::idByName($assessment[$i]->response);
									$rqa->created_at = date('Y-m-d H:i:s');
									$rqa->updated_at = date('Y-m-d H:i:s');
									$rqa->save();
								}
								else{
									//	Update review-question-answer
									$rqa = ReviewQAnswer::find($rqa->id);
									$rqa->review_question_id = $rq->id;
									$rqa->answer = Answer::idByName($assessment[$i]->response);
									$rqa->updated_at = date('Y-m-d H:i:s');
									$rqa->save();
								}
							}
							if(!$rqn){
								//	Create review-note
								$rn = new ReviewNote;
								$rn->review_question_id = $rq->id;
								$rn->note = $assessment[$i]->notes;
								$rn->non_compliance = Answer::adequate($assessment[$i]->compliance);
								$rn->created_at = date('Y-m-d H:i:s');
								$rn->updated_at = date('Y-m-d H:i:s');
								$rn->save();
							}
							else{
								//	Update review-notes
								$rn = ReviewNote::find($rqn->id);
								$rn->review_question_id = $rq->id;
								$rn->note = $assessment[$i]->notes;
								$rn->non_compliance = Answer::adequate($assessment[$i]->compliance);
								$rn->updated_at = date('Y-m-d H:i:s');
								$rn->save();
							}
						}
	        		}
        		}
        		//	Question Scores
        		else if($sheetTitle == 'Scores'){
        			$counter = count($scores);
        			if($counter>0){
        				for($i=0; $i<$counter; $i++){
        					$rq = ReviewQuestion::where('review_id', $review_id)->where('question_id', $scores[$i]->question)->first();
							if(!$rq){
								//	Create review-question
								$rq = new ReviewQuestion;
								$rq->review_id = $review_id;
								$rq->question_id = $scores[$i]->question;
								$rq->created_at = date('Y-m-d H:i:s');
								$rq->updated_at = date('Y-m-d H:i:s');
								$rq->save();
							}
        					$rqs = $rq->qs;
							if(!$rqs){
								//	Create review-question-score
								$rqs = new ReviewQScore;
								$rqs->review_question_id = $rq->id;
								$rqs->audited_score = $scores[$i]->points;
								$rqs->created_at = date('Y-m-d H:i:s');
								$rqs->updated_at = date('Y-m-d H:i:s');
								$rqs->save();
							}
							else{
								//	Update review-question-score
								$rqs = ReviewQScore::find($rqs->id);
								$rqs->review_question_id = $rq->id;
								$rqs->audited_score = $scores[$i]->points;
								$rqs->updated_at = date('Y-m-d H:i:s');
								$rqs->save();
							}
        				}
        			}
        		}
        	});
		});
		return redirect('/home')->with('message', Lang::choice('messages.success-import', 1));/*
		else
			return redirect()->back()->with('message', Lang::choice('messages.failure-import', 1));;*/
    }
}
$excel = App::make('excel');
