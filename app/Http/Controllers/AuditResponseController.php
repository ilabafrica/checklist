<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AuditResponse;
use App\Http\Requests\AssessmentRequest;
use Auth;
use Input;

use Illuminate\Http\Request;

class AuditResponseController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all audit responses
		$responses = AuditResponse::all();
		return view('audit.response.index', compact('responses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//return view('audit.response.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//	Get values for creation of audit response
		$response = new AuditResponse;
        $response->lab_id = Input::get('lab_id');
        $response->audit_type_id = Input::get('audit_type_id');
        $response->status = AuditResponse::INCOMPLETE;
        $response->user_id = Auth::user()->id;
        $response->update_user_id = Auth::user()->id;
        $response->save();

        return redirect('audit/'.$response->id.'/create')->with('message', 'Audit response created successfully.');
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
