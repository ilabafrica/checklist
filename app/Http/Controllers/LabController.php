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
use App\Models\County;
use App\Models\Review;
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
		// dd($labs);
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
		//	Get all counties
		$counties = County::lists('name', 'id');
		//	Get all lab levels
		$labLevels = LabLevel::lists('name', 'id');
		//	Get all lab affiliations
		$labAffiliations = LabAffiliation::lists('name', 'id');
		//	Get all lab types
		$labTypes = LabType::lists('name', 'id');
		return view('lab.lab.create', compact('counties', 'labLevels', 'labAffiliations', 'labTypes'));
	}
	/*
		Function to autoload labs already created from the database
	*/

	public function autocomplete() {
        $term = Input::get('term');
	
		$results = array();
		
		$queries = DB::table('labs')
			->where('name', 'LIKE', '%'.$term.'%')
			->take(5)->get();
		
		foreach ($queries as $query)
		{
		    $results[] = [ 'id' => $query->id, 'value' => $query->name];
		}
		if (empty($results)>0) {
			# code...
		    $results[] = [ 'id' => 0, 'value' => 'No Records found'];
		} 
		return Response::json($results);
       
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LabRequest $request)
	{
		$lab = new Lab;
		$lab->name = $request->name;
		$lab->lab_number = $request->lab_number;
		$lab->lab_type_id = $request->lab_type;
       	$lab->lab_level_id = $request->lab_level;
        $lab->lab_affiliation_id = $request->lab_affiliation;
        $lab->address = $request->address;
		$lab->postal_address = $request->postal_address;
		$lab->county_id = $request->county_id;
		$lab->subcounty = $request->state;
		$lab->telephone = $request->telephone;
		$lab->country_id = 5;
		$lab->email = $request->email;
		$lab->country_id = 5;
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
		$counties = County::lists('name', 'id');
		//	Get initially selected country
		$county = $lab->county_id;
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

        return view('lab.lab.edit', compact('lab', 'counties', 'labLevels', 'labAffiliations', 'labTypes', 'county', 'labLevel', 'labAffiliation', 'labType'));
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
		$lab->lab_level_id = $request->lab_level;
        $lab->lab_affiliation_id = $request->lab_affiliation;
        $lab->name = $request->name;
		$lab->lab_number = $request->number;
		$lab->address = $request->address;
		$lab->postal_address = $request->postal_address;
		$lab->county_id = $request->county_id;
		$lab->telephone = $request->telephone;
		$lab->email = $request->email;
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
		$labReviewInUse = Review::where('lab_id', '=', $id)->first();

		if (empty($labReviewInUse)) 
		{
			// no review created for the lab
			$lab->delete();
			return redirect('lab')->with('message', 'Lab deleted successfully.');

		} else{

			return redirect('lab')->with('message', 'Lab is in use.');

		}

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
