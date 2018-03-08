<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Review;
use App\Models\Lab;
use App\Models\Assessment;
use App\Models\Section;
use Auth;
use DB;


class DashboardController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get all dropdown requirements
		$labs = Lab::lists('name', 'id');
		$assessments = Assessment::lists('name', 'id');
		$sections = Section::lists('name', 'id');
	
		//reviews

		//scores
        dd($this->general_performance(5));

		return view('dashboard', compact('labs', 'assessments', 'sections'));
	}

	public function general_performance($assessment){	

		$reviews = DB::table('reviews')->leftJoin('review_slmta_info', 'review_slmta_info.review_id', '=', 'reviews.id')
					->where('review_slmta_info.assessment_id', $assessment)->get();
		foreach ($reviews as $key => $value) {
			$review = Review::find($value->id);
			$total_points = $review->auditType->sections->sum('total_points');
            $categories = array();		    
		    $score = 9;
		    $sections = $review->auditType->sections;
		    foreach($sections as $section){
			    if($section->total_points!=0)
				    array_push($categories, $section);
			    else
				    continue;
		    }
		    foreach($categories as $section){			
			    $score+=(int)$section->subtotal($review->id, 1);		    
		    }
	    }
		return $score;		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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

}
