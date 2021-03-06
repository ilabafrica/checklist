<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\AuditTypeRequest;
use App\Models\AuditType;
use App\Models\Section;
use Response;
use Auth;
use Session;

class AuditTypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all audit types
		$auditTypes = AuditType::all();
		return view('audit.type.index', compact('auditTypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all sections
		$sections = Section::all();
		return view('audit.type.create', compact('sections'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AuditTypeRequest $request)
	{
		$auditType = new AuditType;
        $auditType->name = $request->name;
        $auditType->description = $request->description;
        $auditType->user_id = Auth::user()->id;
        try{
			$auditType->save();
			if($request->sections){
				$auditType->setSections($request->sections);
			}
			$url = session('SOURCE_URL');

        	return redirect()->to($url)->with('message', 'Audit type created successfully.')->with('active_auditType', $auditType ->id);
		}
		catch(QueryException $e){
			Log::error($e);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a Audit type
		$auditType = AuditType::find($id);
		//show the view and pass the $auditType to it
		return view('audit.type.show', compact('auditType'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$auditType = AuditType::find($id);
		//	Get all sections
		$sections = Section::all();

        return view('audit.type.edit', compact('auditType', 'sections'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AuditTypeRequest $request, $id)
	{
		$auditType = AuditType::findOrFail($id);;
        $auditType->name = $request->name;
        $auditType->description = $request->description;
        $auditType->user_id = Auth::user()->id;;
        try{
			$auditType->save();
			if($request->sections){
				$auditType->setSections($request->sections);
			}
			$url = session('SOURCE_URL');

        	return redirect()->to($url)->with('message', 'Audit type created successfully.')->with('active_auditType', $auditType ->id);
		}
		catch(QueryException $e){
			Log::error($e);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$auditType= AuditType::find($id);
		$auditType->delete();
		return redirect('auditType')->with('message', 'AuditType deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}

}
