<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use App\Models\AuditType;
use App\Models\Lab;
use App\Models\Section;
use Auth;
use Input;

use Illuminate\Http\Request;

class ReviewController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all audit responses
		$responses = Review::all();
		return view('audit.review.index', compact('responses'));
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
		return view('audit.review.create', compact('audit', 'lab', 'page', 'review'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ReviewRequest $request)
	{
		dd(Input::all());
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
        $page = $audit->sections->first()->get();

        return redirect('review/create', compact('audit', 'lab', 'page'));
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

}
