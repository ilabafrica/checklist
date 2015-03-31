<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\FacilityRequest;
use App\Models\Facility;
use App\Models\FacilityType;
use App\Models\FacilityOwner;
use App\Models\Town;
use App\Models\Title;
use Response;

class FacilityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all facilities
		$facilities = Facility::all();
		return view('mfl.facility.index', compact('facilities'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all facility types
		$facilityTypes = FacilityType::lists('name', 'id');
		//	Get all facility owners
		$facilityOwners = FacilityOwner::lists('name', 'id');
		//	Get all towns
		$towns = Town::lists('name', 'id');
		//	Get all titles
		$titles = Title::lists('name', 'id');
		return view('mfl.facility.create', compact('facilityTypes', 'facilityOwners', 'towns', 'titles'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(FacilityRequest $request)
	{
		$town = new Facility;
		$town->code = $request->code;
        $town->name = $request->name;
        $town->facility_type_id = $request->facility_type_id;
        $town->facility_owner_id = $request->facility_owner_id;
        $town->description = $request->description;
        $town->nearest_town = $request->nearest_town;
        $town->landline = $request->landline;
        $town->fax = $request->fax;
        $town->mobile = $request->mobile;
        $town->email = $request->email;
        $town->address = $request->address;
        $town->town_id = $request->town_id;
        $town->in_charge = $request->in_charge;
        $town->title_id = $request->title_id;
        $town->operational_status = $request->operational_status;
        $town->user_id = 1;
        $town->save();

        return redirect('facility')->with('message', 'Facility created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a facility
		$facility = Facility::find($id);
		//show the view and pass the $town to it
		return view('mfl.facility.show', compact('facility'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get facility
		$facility = Facility::find($id);
		//	Get all facility types
		$facilityTypes = FacilityType::lists('name', 'id');
		//	Get initial facility type
		$facilityType = $facility->facility_type_id;
		//	Get all facility owners
		$facilityOwners = FacilityOwner::lists('name', 'id');
		//	Get initial facility owner
		$facilityOwner = $facility->facility_owner_id;
		//	Get all towns
		$towns = Town::lists('name', 'id');
		//	Get initial town
		$town = $facility->town_id;
		//	Get all titles
		$titles = Title::lists('name', 'id');
		//	Get initial title
		$title = $facility->title_id;
		//	Get operational status
		$status = $facility->operational_status;

        return view('mfl.facility.edit', compact('facility', 'facilityTypes', 'facilityOwners', 'towns', 'titles', 'facilityType', 'facilityOwner', 'town', 'title', 'status'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(FacilityRequest $request, $id)
	{
		$town = Facility::findOrFail($id);;
        $town->code = $request->code;
        $town->name = $request->name;
        $town->facility_type_id = $request->facility_type_id;
        $town->facility_owner_id = $request->facility_owner_id;
        $town->description = $request->description;
        $town->nearest_town = $request->nearest_town;
        $town->landline = $request->landline;
        $town->fax = $request->fax;
        $town->mobile = $request->mobile;
        $town->email = $request->email;
        $town->address = $request->address;
        $town->town_id = $request->town_id;
        $town->in_charge = $request->in_charge;
        $town->title_id = $request->title_id;
        $town->operational_status = $request->operational_status;
        $town->user_id = 1;
        $town->save();

        return redirect('facility')->with('message', 'Facility updated successfully.');
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
