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
	    $slmta = DB::table('review_slmta_info')->where('review_id', $review->id)->get();
	    //dd(Input::all());
	    if(!$slmta){
	    	$slmta_data = array('review_id' => $review->id, 'official_slmta' => Input::get('official_slmta'), 'assessment_id' => Input::get('assessment_id'), 'tests_before_slmta' => Input::get('tests_before_slmta'), 'tests_this_year' => Input::get('tests_this_year'), 'cohort_id' => Input::get('cohort_id'), 'baseline_audit_date' => Input::get('baseline_audit_date'), 'slmta_workshop_date' => Input::get('slmta_workshop_date'), 'exit_audit_date' => Input::get('exit_audit_date'), 'baseline_score' => Input::get('baseline_score'), 'baseline_stars_obtained' => Input::get('baseline_stars'), 'exit_score' => Input::get('exit_score'), 'exit_stars_obtained' => Input::get('exit_stars'), 'last_audit_date' => Input::get('last_audit_date'), 'last_audit_score' => Input::get('last_audit_score'), 'prior_audit_status' => Input::get('prior_audit_status'), 'audit_start_date' => Input::get('audit_start_date'), 'audit_end_date' => Input::get('audit_end_date'), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
	    	if(!Input::get('tests_before_slmta'))
				return redirect()->back()->with('error', 'Type of SLMTA audit cannot be empty.');
			else
	    		DB::table('review_slmta_info')->insert($slmta_data);
	    }
	    if(count($slmta)>0){
		    //	Check if Lab Info exists for the review
		    $profile = DB::table('review_lab_profiles')->where('review_id', $review->id)->first();
		    if(!$profile && Input::get('head')){
		    	$lab_profile = array('review_id' => $review->id, 'head' => Input::get('head'), 'head_work_telephone' => Input::get('head_work_telephone'), 'head_personal_telephone' => Input::get('head_personal_telephone'));
		    	DB::table('review_lab_profiles')->insert($lab_profile);
		    }
		    else if($profile){
		    	$lab_profile = array();
		    	//	Get elements with values given
				if(Input::get('degree_staff'))
		    		$lab_profile = array_merge($lab_profile, ['degree_staff' => Input::get('degree_staff')]);
		    	if(Input::get('degree_staff_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['degree_staff_adequate' => Input::get('degree_staff_adequate')]);
		    	if(Input::get('diploma_staff'))
		    		$lab_profile = array_merge($lab_profile, ['diploma_staff' => Input::get('diploma_staff')]);
		    	if(Input::get('diploma_staff_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['diploma_staff_adequate' => Input::get('diploma_staff_adequate')]);
		    	if(Input::get('certificate_staff')) 
		    		$lab_profile = array_merge($lab_profile, ['certificate_staff' => Input::get('certificate_staff')]);
		    	if(Input::get('certificate_staff_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['certificate_staff_adequate' => Input::get('certificate_staff_adequate')]);
		    	if(Input::get('microscopist'))
		    		$lab_profile = array_merge($lab_profile, ['microscopist' => Input::get('microscopist')]);
		    	if(Input::get('microscopist_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['microscopist_adequate' => Input::get('microscopist_adequate')]);
		    	if(Input::get('phlebotomist'))
		    		$lab_profile = array_merge($lab_profile, ['phlebotomist' => Input::get('phlebotomist')]);
		    	if(Input::get('phlebotomist_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['phlebotomist_adequate' => Input::get('phlebotomist_adequate')]);
		    	if(Input::get('data_clerk'))
		    		$lab_profile = array_merge($lab_profile, ['data_clerk' => Input::get('data_clerk')]);
		    	if(Input::get('data_clerk_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['data_clerk_adequate' => Input::get('data_clerk_adequate')]);
		    	if(Input::get('cleaner'))
		    		$lab_profile = array_merge($lab_profile, ['cleaner' => Input::get('cleaner')]);
		    	if(Input::get('cleaner_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['cleaner_adequate' => Input::get('cleaner_adequate')]);
		    	if(Input::get('cleaner_dedicated'))
		    		$lab_profile = array_merge($lab_profile, ['cleaner_dedicated' => Input::get('cleaner_dedicated')]);
		    	if(Input::get('cleaner_trained'))
		    		$lab_profile = array_merge($lab_profile, ['cleaner_trained' => Input::get('cleaner_trained')]);
		    	if(Input::get('driver'))
		    		$lab_profile = array_merge($lab_profile, ['driver' => Input::get('driver')]);
		    	if(Input::get('driver_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['driver_adequate' => Input::get('driver_adequate')]);
		    	if(Input::get('driver_dedicated'))
		    		$lab_profile = array_merge($lab_profile, ['driver_dedicated' => Input::get('driver_dedicated')]);
		    	if(Input::get('driver_trained'))
		    		$lab_profile = array_merge($lab_profile, ['driver_trained' => Input::get('driver_trained')]);
		    	if(Input::get('other_staff'))
		    		$lab_profile = array_merge($lab_profile, ['other_staff' => Input::get('other_staff')]);
		    	if(Input::get('other_staff_adequate'))
		    		$lab_profile = array_merge($lab_profile, ['other_staff_adequate' => Input::get('other_staff_adequate')]);
		    	if(Input::get('sufficient_space'))
		    		$lab_profile = array_merge($lab_profile, ['sufficient_space' => Input::get('sufficient_space')]);
		    	if(Input::get('equipment'))
		    		$lab_profile = array_merge($lab_profile, ['equipment' => Input::get('equipment')]);
		    	if(Input::get('supplies'))
		    		$lab_profile = array_merge($lab_profile, ['supplies' => Input::get('supplies')]);
		    	if(Input::get('personnel'))
		    		$lab_profile = array_merge($lab_profile, ['personnel' => Input::get('personnel')]);
		    	if(Input::get('infrastructure'))
		    		$lab_profile = array_merge($lab_profile, ['infrastructure' => Input::get('infrastructure')]);
		    	if(Input::get('other'))
		    		$lab_profile = array_merge($lab_profile, ['other' => Input::get('other')]);
		    	if(Input::get('other_description'))
		    		$lab_profile = array_merge($lab_profile, ['other_description' => Input::get('other_description')]);
		    	//	Update the lab_profile
		    	$lab_profile = array_merge($lab_profile, ['updated_at' => date('Y-m-d H:i:s')]);
		    	if(count($lab_profile)>0)
		    		DB::table('review_lab_profiles')->where('id', $profile->id)->update($lab_profile);
		    }
		}
		//	Store Audit data
		if(Input::get('assessment_data')){
			foreach (Input::all() as $key => $value) {
				if(stripos($key, 'radio') !==FALSE){
					$fieldId = $this->strip($key);
					$review_data = $review_data = DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					if(!$review_data){
						DB::table('review_question_answers')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'answer' => $value, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					else{
						DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['answer' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
				else if((stripos($key, 'pt') !==FALSE) || (stripos($key, 'date') !==FALSE) || (stripos($key, 'percent') !==FALSE)){
					$fieldId = $this->strip($key);
					$data = $value;
					$review_data = $review_data = DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					if(!$review_data){
						DB::table('review_question_answers')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'answer' => $data, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					else{
						DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['answer' => $data, 'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
				else if(stripos($key, 'text') !==FALSE){
					$fieldId = $this->strip($key);
					$review_notes = DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					$notes = $value;
					if(!$review_notes){
						if(Input::get('check_'.$fieldId)){
							DB::table('review_notes')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'note' => $notes, 'non_compliance' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}
						else{
							DB::table('review_notes')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'note' => $notes, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}
					}
					else{
						if(Input::get('check_'.$fieldId)){
							DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['note' => $notes, 'non_compliance' => '1', 'updated_at' => date('Y-m-d H:i:s')]);
						}
						else{
							DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['note' => $notes, 'updated_at' => date('Y-m-d H:i:s')]);
						}
					}
				}
				else if(stripos($key, 'points') !==FALSE){
					$fieldId = $this->strip($key);
					$rqs = DB::table('review_question_scores')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					$score = $value;
					if(!$rqs){
						DB::table('review_question_scores')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'audited_score' => $value, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					else{
						DB::table('review_question_scores')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['audited_score' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
			}
		}
		//	Save audit summary
		$summary = array();
		if(Input::get('commendations'))
			$summary = array_merge($summary, ['summary_commendations' => Input::get('commendations')]);
		if(Input::get('challenges'))
			$summary = array_merge($summary, ['summary_challenges' => Input::get('challenges')]);
		if(Input::get('recommendations'))
			$summary = array_merge($summary, ['recommendations' => Input::get('recommendations')]);
		if(count($summary)>0)
			DB::table('reviews')->where('review_id', $review->id)->update($summary);
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
        $slmta = DB::table('review_slmta_info')->where('review_id', $id)->first();
        //	Get Lab profile
        $profile = DB::table('review_lab_profiles')->where('review_id', $id)->first();
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
		//	SLMTA Information
		$slmta = DB::table('review_slmta_info')->where('review_id', $review->id)->first();
		$slmta_data = array();
		if(Input::get('official_slmta'))
			$slmta_data = array_merge($slmta_data, ['official_slmta' => Input::get('official_slmta')]);
		if(Input::get('assessment_id'))
			$slmta_data = array_merge($slmta_data, ['assessment_id' => Input::get('assessment_id')]);
		if(Input::get('tests_before_slmta'))
			$slmta_data = array_merge($slmta_data, ['tests_before_slmta' => Input::get('tests_before_slmta')]);
		$slmta_data = array_merge($slmta_data, ['updated_at' => date('Y-m-d H:i:s')]);
		if(!Input::get('tests_before_slmta'))
			return redirect()->back()->with('error', 'Type of SLMTA audit cannot be empty.');
		if(count($slmta_data)>0){
	    	DB::table('review_slmta_info')->where('id', $slmta->id)->update($slmta_data);
		}
		//	Lab Profile - Part 1
		$profile = DB::table('review_lab_profiles')->where('review_id', $review->id)->first();
		$lab_profile_1 = array();
		if(Input::get('head'))
			$lab_profile_1 = array_merge($lab_profile_1, ['head' => Input::get('head')]);
		if(Input::get('head_work_telephone'))
			$lab_profile_1 = array_merge($lab_profile_1, ['head_work_telephone' => Input::get('head_work_telephone')]);
		if(Input::get('head_personal_telephone'))
			$lab_profile_1 = array_merge($lab_profile_1, ['head_personal_telephone' => Input::get('head_personal_telephone')]);
		$lab_profile_1 = array_merge($lab_profile_1, ['updated_at' => date('Y-m-d H:i:s')]);
		if(count($lab_profile_1)>0){
			DB::table('review_lab_profiles')->where('id', $profile->id)->update($lab_profile_1);
		}
		//	Lab Profile - Part 2
		$lab_profile_2 = array();
		//	Get elements with values given
		if(Input::get('degree_staff'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['degree_staff' => Input::get('degree_staff')]);
    	if(Input::get('degree_staff_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['degree_staff_adequate' => Input::get('degree_staff_adequate')]);
    	if(Input::get('diploma_staff'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['diploma_staff' => Input::get('diploma_staff')]);
    	if(Input::get('diploma_staff_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['diploma_staff_adequate' => Input::get('diploma_staff_adequate')]);
    	if(Input::get('certificate_staff')) 
    		$lab_profile_2 = array_merge($lab_profile_2, ['certificate_staff' => Input::get('certificate_staff')]);
    	if(Input::get('certificate_staff_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['certificate_staff_adequate' => Input::get('certificate_staff_adequate')]);
    	if(Input::get('microscopist'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['microscopist' => Input::get('microscopist')]);
    	if(Input::get('microscopist_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['microscopist_adequate' => Input::get('microscopist_adequate')]);
    	if(Input::get('phlebotomist'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['phlebotomist' => Input::get('phlebotomist')]);
    	if(Input::get('phlebotomist_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['phlebotomist_adequate' => Input::get('phlebotomist_adequate')]);
    	if(Input::get('data_clerk'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['data_clerk' => Input::get('data_clerk')]);
    	if(Input::get('data_clerk_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['data_clerk_adequate' => Input::get('data_clerk_adequate')]);
    	if(Input::get('cleaner'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['cleaner' => Input::get('cleaner')]);
    	if(Input::get('cleaner_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['cleaner_adequate' => Input::get('cleaner_adequate')]);
    	if(Input::get('cleaner_dedicated'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['cleaner_dedicated' => Input::get('cleaner_dedicated')]);
    	if(Input::get('cleaner_trained'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['cleaner_trained' => Input::get('cleaner_trained')]);
    	if(Input::get('driver'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['driver' => Input::get('driver')]);
    	if(Input::get('driver_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['driver_adequate' => Input::get('driver_adequate')]);
    	if(Input::get('driver_dedicated'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['driver_dedicated' => Input::get('driver_dedicated')]);
    	if(Input::get('driver_trained'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['driver_trained' => Input::get('driver_trained')]);
    	if(Input::get('other_staff'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['other_staff' => Input::get('other_staff')]);
    	if(Input::get('other_staff_adequate'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['other_staff_adequate' => Input::get('other_staff_adequate')]);
    	if(Input::get('sufficient_space'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['sufficient_space' => Input::get('sufficient_space')]);
    	if(Input::get('equipment'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['equipment' => Input::get('equipment')]);
    	if(Input::get('supplies'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['supplies' => Input::get('supplies')]);
    	if(Input::get('personnel'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['personnel' => Input::get('personnel')]);
    	if(Input::get('infrastructure'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['infrastructure' => Input::get('infrastructure')]);
    	if(Input::get('other'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['other' => Input::get('other')]);
    	if(Input::get('other_description'))
    		$lab_profile_2 = array_merge($lab_profile_2, ['other_description' => Input::get('other_description')]);
    	$lab_profile_2 = array_merge($lab_profile_2, ['updated_at' => date('Y-m-d H:i:s')]);
    	//	Update the lab_profile
    	if(count($lab_profile_2)>0)
    		DB::table('review_lab_profiles')->where('id', $profile->id)->update($lab_profile_2);
    	//	Update the stored audit data
    	if(Input::get('assessment_data')){
	    	foreach (Input::all() as $key => $value) {
				if(stripos($key, 'radio') !==FALSE){
					$fieldId = $this->strip($key);
					$review_data = $review_data = DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					if(!$review_data){
						DB::table('review_question_answers')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'answer' => $value, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					else{
						DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['answer' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
				else if((stripos($key, 'pt') !==FALSE) || (stripos($key, 'date') !==FALSE) || (stripos($key, 'percent') !==FALSE)){
					$fieldId = $this->strip($key);
					$data = $value;
					$review_data = $review_data = DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					if(!$review_data){
						DB::table('review_question_answers')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'answer' => $data, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					else{
						DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['answer' => $data, 'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
				else if(stripos($key, 'text') !==FALSE){
					$fieldId = $this->strip($key);
					$review_notes = DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					$notes = $value;
					if(!$review_notes){
						if(Input::get('check_'.$fieldId)){
							DB::table('review_notes')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'note' => $notes, 'non_compliance' => '1', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}
						else{
							DB::table('review_notes')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'note' => $notes, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
						}
					}
					else{
						if(Input::get('check_'.$fieldId)){
							DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['note' => $notes, 'non_compliance' => '1']);
						}
						else{
							DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['note' => $notes, 'updated_at' => date('Y-m-d H:i:s')]);
						}
					}
				}
				else if(stripos($key, 'points') !==FALSE){
					$fieldId = $this->strip($key);
					$rqs = DB::table('review_question_scores')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
					$score = $value;
					if(!$rqs){
						DB::table('review_question_scores')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'audited_score' => $value, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					}
					else{
						DB::table('review_question_scores')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['audited_score' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
					}
				}
			}
		}
		//	Save audit summary
		$summary = array();
		if(Input::get('commendations'))
			$summary = array_merge($summary, ['summary_commendations' => Input::get('commendations')]);
		if(Input::get('challenges'))
			$summary = array_merge($summary, ['summary_challenges' => Input::get('challenges')]);
		if(Input::get('recommendations'))
			$summary = array_merge($summary, ['recommendations' => Input::get('recommendations')]);
		$summary = array_merge($summary, ['updated_at' => date('Y-m-d H:i:s')]);
		if(count($summary)>0)
			DB::table('reviews')->where('review_id', $review->id)->update($summary);
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
			DB::table('review_action_plans')->insert(['review_id' => $review_id, 'action' => $follow_up_action, 'responsible_person' => $responsible_person, 'timeline' => $timeline, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
			return 0;
		}
		else if($action == 'update'){
			if($follow_up_action)
				$plan = array_merge($plan, ['action' => $follow_up_action]);
			if($responsible_person)
				$plan = array_merge($plan, ['responsible_person' => $responsible_person]);
			if($timeline)
				$plan = array_merge($plan, ['timeline' => $timeline]);
			$plan = array_merge($plan, ['updated_at' => date('Y-m-d H:i:s')]);
			if(count($plan)>0)
				DB::table('review_action_plans')->where('id', $id)->update($plan);
		}
		else if($action == 'draw'){
			$plans = DB::table('review_action_plans')->where('review_id', $review_id)->get();

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
		$scored_questions = DB::table('review_question_scores')->where('review_id', $review->id)->lists('question_id');
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
        	Review::where('id', $review->id)->update(['status' => Review::COMPLETE,'updated_at' => date('Y-m-d H:i:s')]);
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
					for($i=0;$i<$counter;$i++){
        				//	Save Laboratory Profile
						$lab_profile = array('review_id' => $review_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
						$profile = DB::table('review_lab_profiles')->where('review_id', $review_id)->first();
						if(!$profile){
	    					$lab_profile = array('review_id' => $review_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
	    					$profile = DB::table('review_lab_profiles')->insert($lab_profile);
	    				}
						if($sheet[$i]->field == Lang::choice('messages.lab-head', 1)){
							$head = $sheet[$i]->value;
						}
						if($sheet[$i]->field == Lang::choice('messages.lab-head-telephone-personal', 1)){
							$head_personal_telephone = $sheet[$i]->value;
						}
						if($sheet[$i]->field == Lang::choice('messages.lab-head-telephone-work', 1)){
							$head_work_telephone = $sheet[$i]->value;
						}
						if($head!=NULL){
							if($profile){
								DB::table('review_lab_profiles')->where('id', $profile->id)->update(['head' => $head, 'updated_at' => date('Y-m-d H:i:s')]);
							}
						}
						if($head_personal_telephone!=NULL){
							if($profile){
								DB::table('review_lab_profiles')->where('id', $profile->id)->update(['head_personal_telephone' => $head_personal_telephone, 'updated_at' => date('Y-m-d H:i:s')]);
							}
						}
						if($head_work_telephone!=NULL){
							if($profile){
								DB::table('review_lab_profiles')->where('review_id', $review_id)->update(['head_work_telephone' => $head_work_telephone, 'updated_at' => date('Y-m-d H:i:s')]);
							}
						}
        			}
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
    				$profile = DB::table('review_lab_profiles')->where('review_id', $review_id)->first();
    				if(!$profile){
    					$lab_profile = array('review_id' => $review_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
    					$profile = DB::table('review_lab_profiles')->insert($lab_profile);
    				}
					//	Begin saving
        			for($i=0;$i<$counter;$i++){
        				if($staffing_summary[$i]->profession == Lang::choice('messages.degree', 1)){
							$degree = $staffing_summary[$i]->employees;
							$degree_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['degree_staff' => $degree, 'degree_staff_adequate' => $degree_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.diploma', 1)){
							$diploma = $staffing_summary[$i]->employees;
							$diploma_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['diploma_staff' => $diploma, 'diploma_staff_adequate' => $diploma_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.certificate', 1)){
							$certificate = $staffing_summary[$i]->employees;
							$certificate_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['certificate_staff' => $certificate, 'certificate_staff_adequate' => $certificate_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.microscopist', 1)){
							$microscopist = $staffing_summary[$i]->employees;
							$microscopist_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['microscopist' => $microscopist, 'microscopist_adequate' => $microscopist_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.data-clerk', 1)){
							$data_clerk = $staffing_summary[$i]->employees;
							$data_clerk_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['data_clerk' => $data_clerk, 'data_clerk_adequate' => $data_clerk_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.phlebotomist', 1)){
							$phlebotomist = $staffing_summary[$i]->employees;
							$phlebotomist_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['phlebotomist' => $degree, 'phlebotomist_adequate' => $phlebotomist_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.cleaner', 1)){
							$cleaner = $staffing_summary[$i]->employees;
							$cleaner_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['cleaner' => $degree, 'cleaner_adequate' => $cleaner_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.cleaner-dedicated', 1)){
							$cleaner_dedicated = Answer::adequate($staffing_summary[$i]->employees);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['cleaner_dedicated' => $cleaner_dedicated, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.cleaner-trained', 1)){
							$cleaner_trained = Answer::adequate($staffing_summary[$i]->employees);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['cleaner_trained' => $cleaner_trained, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.driver', 1)){
							$driver = $staffing_summary[$i]->employees;
							$driver_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['driver' => $driver, 'driver_adequate' => $driver_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.driver-dedicated', 1)){
							$driver_dedicated = Answer::adequate($staffing_summary[$i]->employees);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['driver_dedicated' => $driver_dedicated, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.driver-trained', 1)){
							$driver_trained = Answer::adequate($staffing_summary[$i]->employees);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['driver_trained' => $driver_trained, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($staffing_summary[$i]->profession == Lang::choice('messages.other', 1)){
							$other_staff = $staffing_summary[$i]->employees;
							$other_staff_adequate = Answer::adequate($staffing_summary[$i]->adequate);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['other_staff' => $other_staff, 'other_staff_adequate' => $other_staff_adequate, 'updated_at' => date('Y-m-d H:i:s')]);
						}
        			}
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
    				$profile = DB::table('review_lab_profiles')->where('review_id', $review_id)->first();
    				if(!$profile){
    					$lab_profile = array('review_id' => $review_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
    					$profile = DB::table('review_lab_profiles')->insert($lab_profile);
    				}
					//	Begin saving
        			for($i=0;$i<$counter;$i++){
        				if($organizational_structure[$i]->field == Lang::choice('messages.sufficient-space', 1)){
							$sufficient_space = Answer::adequate($organizational_structure[$i]->value);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['sufficient_space' => $sufficient_space, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.equipment', 1)){
							$equipment = Answer::adequate($organizational_structure[$i]->value);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['equipment' => $equipment, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.supplies', 1)){
							$supplies = Answer::adequate($organizational_structure[$i]->value);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['supplies' => $supplies, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.personnel', 1)){
							$personnel = Answer::adequate($organizational_structure[$i]->value);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['personnel' => $personnel, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if($organizational_structure[$i]->field == Lang::choice('messages.infrastructure', 1)){
							$infrastructure = Answer::adequate($organizational_structure[$i]->value);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['infrastructure' => $infrastructure, 'updated_at' => date('Y-m-d H:i:s')]);
						}
						if(strpos($organizational_structure[$i]->field, Lang::choice('messages.other-specify', 1)) !== FALSE){
							$other = Answer::adequate($organizational_structure[$i]->value);
							if(($pos = strpos($organizational_structure[$i]->field, ':')) !== FALSE)
								$other_description = substr($organizational_structure[$i]->field, $pos+2);
							$other_description = trim($other_description);
							DB::table('review_lab_profiles')->where('id', $profile->id)->update(['other' => $other, 'other_description' => $other_description, 'updated_at' => date('Y-m-d H:i:s')]);
						}
        			}
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
    				$slmta = DB::table('review_slmta_info')->where('review_id', $review_id)->first();
    				//	Begin saving
					for($i=0;$i<$counter;$i++){
						if($slmta_information[$i]->field == Lang::choice('messages.slmta-audit-type', 1)){
							$assessment_id = Assessment::idByName($slmta_information[$i]->value);
							$array = array_merge($array, ['assessment_id' => $assessment_id]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.official-slmta', 1)){
		    				$official_slmta = Answer::adequate($slmta_information[$i]->value);
		    				$array = array_merge($array, ['official_slmta' => $official_slmta]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.audit-start-date', 1)){
		    				$audit_start_date = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['audit_start_date' => $audit_start_date]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.audit-end-date', 1)){
		    				$audit_end_date = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['audit_end_date' => $audit_end_date]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.tests-before-slmta', 1)){
		    				$tests_before_slmta = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['tests_before_slmta' => $tests_before_slmta]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.tests-this-year', 1)){
		    				$tests_this_year = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['tests_this_year' => $tests_this_year]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.cohort-id', 1)){
		    				$cohort_id = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['cohort_id' => $cohort_id]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.baseline-audit-date', 1)){
		    				$baseline_audit_date = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['baseline_audit_date' => $baseline_audit_date]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.slmta-workshop-date', 1)){
		    				$slmta_workshop_date = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['slmta_workshop_date' => $slmta_workshop_date]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.exit-audit-date', 1)){
		    				$exit_audit_date = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['exit_audit_date' => $exit_audit_date]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.baseline-score', 1)){
		    				$baseline_score = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['baseline_score' => $baseline_score]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.baseline-stars', 1)){
		    				$baseline_stars = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['baseline_stars_obtained' => $baseline_stars]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.exit-score', 1)){
		    				$exit_score = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['exit_score' => $exit_score]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.exit-stars', 1)){
		    				$exit_stars = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['exit_stars_obtained' => $exit_stars]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.last-audit-date', 1)){
		    				$last_audit_date = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['last_audit_date' => $last_audit_date]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.last-audit-score', 1)){
		    				$last_audit_score = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['last_audit_score' => $last_audit_score]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.prior-audit-status', 1)){
		    				$prior_audit_status = $slmta_information[$i]->value;
		    				$array = array_merge($array, ['prior_audit_status' => $prior_audit_status]);
		    			}
		    			if($slmta_information[$i]->field == Lang::choice('messages.names-affiliations-of-auditors', 1)){
		    				foreach(explode(',', $slmta_information[$i]->value) as $assessor){
		    					$assessors = array_push($assessors, User::userIdName($assessor));
		    				}
		    			}
					}
					Review::find($review_id)->setAssessors([$assessors]);
					$array = array_merge($array, ['review_id' => $review_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
					if(!$slmta){
    					$slmta = DB::table('review_slmta_info')->insert($array);
    				}
    				else{
    					$slmta = DB::table('review_slmta_info')->where('id', $slmta->id)->update($array);
    				}
        		}
        		//	Summary of Audit Findings
        		else if($sheetTitle == 'Summary of Assessment Findings'){
        			$counter = count($summary);
        			$commendations = NULL;
        			$challenges = NULL;
        			$recommendations = NULL;
        			$array = array();
        			//	Update review data
        			for($i=0; $i<$counter; $i++){
        				if($summary[$i]->field == Lang::choice('messages.commendations', 1)){
        					$commendations = $summary[$i]->value;
        					$array = array_merge($array, ['summary_commendations' => $commendations]);
        				}
        				if($summary[$i]->field == Lang::choice('messages.challenges', 1)){
        					$challenges = $summary[$i]->value;
        					$array = array_merge($array, ['summary_challenges' => $challenges]);
        				}
        				if($summary[$i]->field == Lang::choice('messages.recommendations', 1)){
        					$recommendations = $summary[$i]->value;
        					$array = array_merge($array, ['recommendations' => $recommendations]);
        				}
        			}
        			$array = array_merge($array, ['updated_at' => date('Y-m-d H:i:s')]);
        			Review::where('id', $review_id)->update($array);
        		}
        		//	Action Plan
        		else if($sheetTitle == 'Action Plan'){
        			$counter = count($summary);
        			$array = array();
        			if($counter>0){
	        			for($i=0; $i<$counter; $i++){
	        				$plans = DB::table('review_action_plans')->where('review_id', $review_id)->where('action', $summary[$i]->action)->where('responsible_person', $summary[$i]->incharge)->where('timeline', $summary[$i]->timeline)->first();
		        			if(count($plans==0)){
		        				if($summary[$i]->action!=NULL || $summary[$i]->incharge!=NULL || $summary[$i]->timeline!=NULL)
		        					DB::table('review_action_plans')->insert(['review_id' => $review_id, 'action' => $summary[$i]->action, 'responsible_person' => $summary[$i]->incharge, 'timeline' => $summary[$i]->timeline, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		        			}
		        			else
		        				DB::table('review_action_plans')->where('id', $plans->id)->update(['action' => $summary[$i]->action, 'responsible_person' => $summary[$i]->incharge, 'timeline' => $summary[$i]->timeline, 'updated_at' => date('Y-m-d H:i:s')]);
		        		}
	        		}
        		}
        		//	Assessment data
        		else if($sheetTitle == 'Assessment Details'){
        			$counter = count($assessment);
        			if($counter>0){
	        			for($i=0; $i<$counter; $i++){
	        				$qa = DB::table('review_question_answers')->where('review_id', $review_id)->where('question_id', $assessment[$i]->question)->first();
	        				$note = DB::table('review_question_answers')->where('review_id', $review_id)->where('question_id', $assessment[$i]->question)->first();
		        			$question = Question::find((int)$assessment[$i]->question);
		        			if(count($question->children)>0){
		        				continue;
		        			}
		        			else{
		        				if(count($qa==0))
		        					DB::table('review_question_answers')->insert(['review_id' => $review_id, 'question_id' => $assessment[$i]->question, 'answer' => Answer::idByName($assessment[$i]->response), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		        				else
		        					DB::table('review_question_answers')->where('id', $qa->id)->update(['answer' => Answer::idByName($assessment[$i]->response), 'updated_at' => date('Y-m-d H:i:s')]);
		        			}
		        			if(count($note)==0)
		        				DB::table('review_notes')->insert(['review_id' => $review_id, 'question_id' => $assessment[$i]->question, 'note' => $assessment[$i]->notes, 'non_compliance' => Answer::adequate($assessment[$i]->compliance), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		        			else
		        				DB::table('review_notes')->where('id', $note->id)->update(['note' => $assessment[$i]->notes, 'non_compliance' => Answer::adequate($assessment[$i]->compliance), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		        		}
	        		}
        		}
        		//	Question Scores
        		else if($sheetTitle == 'Scores'){
        			$counter = count($scores);
        			if($counter>0){
        				for($i=0; $i<$counter; $i++){
        					$score = DB::table('review_question_scores')->where('review_id', $review_id)->where('question_id', $scores[$i]->question)->first();
        					if(count($score==0))
        						DB::table('review_question_scores')->insert(['review_id' => $review_id, 'question_id' => $scores[$i]->question, 'audited_score' => $scores[$i]->points, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        					else
        						DB::table('review_question_scores')->where('id', $score->id)->update(['audited_score' => $scores[$i]->points, 'updated_at' => date('Y-m-d H:i:s')]);
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
