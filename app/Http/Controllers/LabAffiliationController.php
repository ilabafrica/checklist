<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\LabAffiliationRequest;
use App\Models\LabAffiliation;
use Response;

class LabAffiliationController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all lab affiliations
		$labAffiliations = LabAffiliation::all();
		return view('lab.affiliation.index', compact('labAffiliations'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('lab.affiliation.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LabAffiliationRequest $request)
	{
		$labAffiliation = new LabAffiliation;
        $labAffiliation->name = $request->name;
        $labAffiliation->description = $request->description;
        $labAffiliation->user_id = 1;
        $labAffiliation->save();

        return redirect('labAffiliation')->with('message', 'Lab affiliation created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a lab affiliation
		$labAffiliation = LabAffiliation::find($id);
		//show the view and pass the $labaffiliation to it
		return view('lab.affiliation.show', compact('labAffiliation'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$labAffiliation = LabAffiliation::find($id);

        return view('lab.affiliation.edit', compact('labAffiliation'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(LabAffiliationRequest $request, $id)
	{
		$labAffiliation = LabAffiliation::findOrFail($id);;
        $labAffiliation->name = $request->name;
        $labAffiliation->description = $request->description;
        $labAffiliation->user_id = 1;
        $labAffiliation->save();

        return redirect('labAffiliation')->with('message', 'Lab affiliation updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$labAffiliation= LabAffiliation::find($id);
		$labAffiliation->delete();
		return redirect('labAffiliation')->with('message', 'LabAffiliation deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}

}
