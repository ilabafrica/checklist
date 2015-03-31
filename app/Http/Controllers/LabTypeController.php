<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\LabTypeRequest;
use App\Models\LabType;
use Response;

class LabTypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all lab Types
		$labTypes = LabType::all();
		return view('lab.type.index', compact('labTypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('lab.type.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LabTypeRequest $request)
	{
		$labType = new LabType;
        $labType->name = $request->name;
        $labType->description = $request->description;
        $labType->user_id = 1;
        $labType->save();

        return redirect('labType')->with('message', 'Lab type created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a lab Type
		$labType = LabType::find($id);
		//show the view and pass the $labType to it
		return view('lab.type.show', compact('labType'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$labType = LabType::find($id);

        return view('lab.type.edit', compact('labType'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(LabTypeRequest $request, $id)
	{
		$labType = LabType::findOrFail($id);;
        $labType->name = $request->name;
        $labType->description = $request->description;
        $labType->user_id = 1;
        $labType->save();

        return redirect('labType')->with('message', 'Lab type updated successfully.');
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