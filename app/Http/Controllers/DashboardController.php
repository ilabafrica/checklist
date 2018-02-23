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

		return view('dashboard', compact('labs', 'assessments', 'sections'));
	}

	public function general_performance($assessment){	

		$review = Review::find($id);
		$categories = array();
		$labels = array();
		$overall = $review->auditType->sections->sum('total_points'); // total points that can be earned
		$points = 0;
		$score = 0;
		$sections = $review->auditType->sections;
		foreach($sections as $section){
			if($section->total_points!=0)
				array_push($categories, $section);
			else
				continue;
		}
		$counter = count($categories);
		foreach($categories as $section){
			// dd($section->id);
			array_push($labels, $section->name);
			$points+=(int)$section->subtotal($review->id);
			$score+=(int)$section->subtotal($review->id, 1);
		}
		$average = $score*100/$overall;
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
