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
use Auth;
use Input;
use Lang;

use Illuminate\Http\Request;

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
				if(Input::get('assessors')){
					$review->setAssessors(Input::get('assessors'));
				}
				//$url = Session::get('SOURCE_URL');
			}
			catch(QueryException $e){
				Log::error($e);
			}

	        $audit = AuditType::find($review->audit_type_id);
	        $page = $audit->sections->first()->get();
	    }
	    //dd(Input::all());
	    //	Check if SLMTA Info exists for the review
	    $slmta = DB::table('review_slmta_info')->where('review_id', $review->id)->get();
	    if(!$slmta){
	    	$slmta_data = array('review_id' => $review->id, 'official_slmta' => Input::get('official_slmta'), 'assessment_id' => Input::get('assessment_id'), 'tests_before_slmta' => Input::get('tests_before_slmta'), 'tests_this_year' => Input::get('tests_this_year'), 'cohort_id' => Input::get('cohort_id'), 'baseline_audit_date' => Input::get('baseline_audit_date'), 'slmta_workshop_date' => Input::get('slmta_workshop_date'), 'exit_audit_date' => Input::get('exit_audit_date'), 'baseline_score' => Input::get('baseline_score'), 'baseline_stars_obtained' => Input::get('baseline_stars'), 'exit_score' => Input::get('exit_score'), 'exit_stars_obtained' => Input::get('exit_stars'), 'last_audit_date' => Input::get('last_audit_date'), 'last_audit_score' => Input::get('last_audit_score'), 'prior_audit_status' => Input::get('prior_audit_status'), 'audit_start_date' => Input::get('audit_start_date'), 'audit_end_date' => Input::get('audit_end_date'));
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
		    	if(count($lab_profile)>0)
		    		DB::table('review_lab_profiles')->where('id', $profile->id)->update($lab_profile);
		    }
		}
		//	Store Audit data
		foreach (Input::all() as $key => $value) {
			if(stripos($key, 'radio') !==FALSE){
				$fieldId = $this->strip($key);
				$review_data = $review_data = DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
				if(!$review_data){
					DB::table('review_question_answers')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'answer_id' => $value]);
				}
				else{
					DB::table('review_question_answers')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['answer_id' => $value]);
				}
			}
			else if(stripos($key, 'text') !==FALSE){
				$fieldId = $this->strip($key);
				$review_notes = DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->get();
				$notes = $value;
				if(!$review_notes){
					if(Input::get('check_'.$fieldId)){
						DB::table('review_notes')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'note' => $notes, 'non_compliance' => '1']);
					}
					else{
						DB::table('review_notes')->insert(['review_id' => $review->id, 'question_id' => $fieldId, 'note' => $notes]);
					}
				}
				else{
					if(Input::get('check_'.$fieldId)){
						DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['note' => $notes, 'non_compliance' => '1']);
					}
					else{
						DB::table('review_notes')->where('review_id', $review->id)->where('question_id', $fieldId)->update(['note' => $notes]);
					}
				}
			}/*
			else if(stripos($key, 'textfield') !==FALSE){

			}
			else if(stripos($key, 'date') !==FALSE){
				
			}*/
		}
	    //	Get variables ready for processing of new audit
        $audit = AuditType::find($review->audit_type_id);
        $lab = Lab::find($review->lab_id);
        $page = Section::find(Input::get('section_id'))->next()->first();

        return redirect('review/create/'.$audit->id.'/'.$page->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
}
