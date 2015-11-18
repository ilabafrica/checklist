<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\LabRequest;
use App\Models\Lab;
use App\Models\LabLevel;
use App\Models\LabAffiliation;
use App\Models\LabType;
use App\Models\AuditType;
use App\Models\Country;
use Response;
use Auth;
use Session;

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
		//	Get audit types
		$auditTypes = AuditType::all();
		/*Default audit type*/
		$auditType = AuditType::first();
		return view('lab.lab.index', compact('labs', 'auditTypes', 'auditType'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all countries
		$countries = Country::lists('name', 'id');
		//	Get all lab levels
		$labLevels = LabLevel::lists('name', 'id');
		//	Get all lab affiliations
		$labAffiliations = LabAffiliation::lists('name', 'id');
		//	Get all lab types
		$labTypes = LabType::lists('name', 'id');
		return view('lab.lab.create', compact('countries', 'labLevels', 'labAffiliations', 'labTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LabRequest $request)
	{
		$lab = new Lab;
		$lab->lab_type_id = $request->lab_type;
        $lab->name = $request->name;
		$lab->lab_number = $request->number;
		$lab->address = $request->address;
		$lab->postal_code = $request->postal_code;
		$lab->city = $request->city;
		$lab->state = $request->state;
        $lab->country_id = $request->country;
		$lab->fax = $request->fax;
		$lab->telephone = $request->telephone;
		$lab->email = $request->email;
		$lab->lab_level_id = $request->lab_level;
        $lab->lab_affiliation_id = $request->lab_affiliation;
        $lab->user_id = Auth::user()->id;
        $lab->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Lab created successfully.')->with('active_lab', $lab ->id);
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
		//	Get all countries
		$countries = Country::lists('name', 'id');
		//	Get initially selected country
		$country = $lab->country_id;
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

        return view('lab.lab.edit', compact('lab', 'countries', 'labLevels', 'labAffiliations', 'labTypes', 'country', 'labLevel', 'labAffiliation', 'labType'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(LabRequest $request, $id)
	{
		$lab = Lab::findOrFail($id);
        $lab->lab_type_id = $request->lab_type;
        $lab->name = $request->name;
		$lab->lab_number = $request->number;
		$lab->address = $request->address;
		$lab->postal_code = $request->postal_code;
		$lab->city = $request->city;
		$lab->state = $request->state;
        $lab->country_id = $request->country;
		$lab->fax = $request->fax;
		$lab->telephone = $request->telephone;
		$lab->email = $request->email;
		$lab->lab_level_id = $request->lab_level;
        $lab->lab_affiliation_id = $request->lab_affiliation;
        $lab->user_id = Auth::user()->id;;
        $lab->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', 'Lab updated successfully.')->with('active_lab', $lab ->id);
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
