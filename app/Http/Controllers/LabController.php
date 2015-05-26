<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LabRequest;
use App\Models\Lab;
use App\Models\Facility;
use App\Models\LabLevel;
use App\Models\LabAffiliation;
use App\Models\LabType;
use App\Models\AuditType;
use Response;
use Auth;

class LabController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all labs
		$labs = Lab::all();
		return view('lab.lab.index', compact('labs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all facilities
		$facilities = Facility::lists('name', 'id');
		//	Get all lab levels
		$labLevels = LabLevel::lists('name', 'id');
		//	Get all lab affiliations
		$labAffiliations = LabAffiliation::lists('name', 'id');
		//	Get all lab types
		$labTypes = LabType::lists('name', 'id');
		return view('lab.lab.create', compact('facilities', 'labLevels', 'labAffiliations', 'labTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LabRequest $request)
	{
		$lab = new Lab;
        $lab->facility_id = $request->facility;
        $lab->lab_level_id = $request->lab_level;
        $lab->lab_affiliation_id = $request->lab_affiliation;
        $lab->lab_type_id = $request->lab_type;
        $lab->user_id = Auth::user()->id;;
        $lab->save();

        return redirect('lab')->with('message', 'Lab created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a lab
		$lab = Lab::find($id);
		//show the view and pass the $lab to it
		return view('lab.lab.show', compact('lab'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get lab
		$lab = Lab::find($id);
		//	Get all facilities
		$facilities = Facility::lists('name', 'id');
		//	Get initially selected facility
		$facility = $lab->facility_id;
		//	Get all lab levels
		$labLevels = LabLevel::lists('name', 'id');
		//	Get initially selected lab level
		$labLevel = $lab->lab_level_id;
		//	Get all lab affiliations
		$labAffiliations = LabAffiliation::lists('name', 'id');
		//	Get initially selected lab affiliation
		$labAffiliation = $lab->lab_affiliation_id;
		//	Get all lab types
		$labTypes = LabType::lists('name', 'id');
		//	Get initially selected lab type
		$labType = $lab->lab_type_id;

        return view('lab.lab.edit', compact('lab', 'facilities', 'labLevels', 'labAffiliations', 'labTypes', 'facility', 'labLevel', 'labAffiliation', 'labType'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(LabRequest $request, $id)
	{
		$lab = Lab::findOrFail($id);;
        $lab->facility_id = $request->facility;
        $lab->lab_level_id = $request->lab_level;
        $lab->lab_affiliation_id = $request->lab_affiliation;
        $lab->lab_type_id = $request->lab_type;
        $lab->user_id = Auth::user()->id;;
        $lab->save();

        return redirect('lab')->with('message', 'Lab updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$lab= Lab::find($id);
		$lab->delete();
		return redirect('lab')->with('message', 'Lab deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}
	/**
	 * Select a lab, ready to begin audit
	 *
	 */
	public function select($id)
	{
		//	Return selected lab
		$lab= Lab::find($id);
		//	Get available audit types
		$auditTypes = AuditType::all();
		return view('audit.review.select', compact('lab', 'auditTypes'));
	}
}
