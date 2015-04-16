<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\AssessmentRequest;
use App\Models\Assessment;
use Response;
use Auth;

class AssessmentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all assessments
		$assessments = Assessment::all();
		return view('audit.assessment.index', compact('assessments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('audit.assessment.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AssessmentRequest $request)
	{
		$assessment = new Assessment;
        $assessment->name = $request->name;
        $assessment->description = $request->description;
        $assessment->user_id = Auth::user()->id;
        $assessment->save();

        return redirect('assessment')->with('message', 'Assessment created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a Assessment
		$assessment = Assessment::find($id);
		//show the view and pass the $assessment to it
		return view('audit.assessment.show', compact('assessment'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$assessment = Assessment::find($id);

        return view('audit.assessment.edit', compact('assessment'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AssessmentRequest $request, $id)
	{
		$assessment = Assessment::findOrFail($id);;
        $assessment->name = $request->name;
        $assessment->description = $request->description;
        $assessment->user_id = Auth::user()->id;
        $assessment->save();

        return redirect('assessment')->with('message', 'Assessment updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$assessment= Assessment::find($id);
		$assessment->delete();
		return redirect('assessment')->with('message', 'Assessment deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}
}
