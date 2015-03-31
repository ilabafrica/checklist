<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\AuditFieldGroupRequest;
use App\Models\AuditType;
use App\Models\AuditFieldGroup;
use Response;

class AuditFieldGroupController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all audit field groups
		$auditFieldGroups = AuditFieldGroup::all();
		return view('audit.group.index', compact('auditFieldGroups'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all present groups
		$parents = AuditFieldGroup::lists('name', 'id');
		//	Get all audit types
		$auditTypes = AuditType::lists('name', 'id');
		return view('audit.group.create', compact('parents', 'auditTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AuditFieldGroupRequest $request)
	{
		$auditFieldGroup = new AuditFieldGroup;
        $auditFieldGroup->name = $request->name;
        $auditFieldGroup->description = $request->description;
        $auditFieldGroup->audit_type_id = $request->audit_type_id;
        $auditFieldGroup->user_id = 1;
        try{
			$auditFieldGroup->save();
			if($request->parent_id){
				$auditFieldGroup->setParent(array($request->parent_id));
			}
			$url = Session::get('SOURCE_URL');
        
        	return redirect('auditFieldGroup')->with('message', 'Audit field group created successfully.');
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
		//show a Audit field group
		$auditFieldGroup = AuditFieldGroup::find($id);
		//show the view and pass the $auditFieldGroup to it
		return view('audit.group.show', compact('auditFieldGroup'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$auditFieldGroup = AuditFieldGroup::find($id);
		//	Get all present groups
		$parents = AuditFieldGroup::lists('name', 'id');
		//	Get initial parent id
		$parent = $auditFieldGroup->parent_id;
		//	Get all audit types
		$auditTypes = AuditType::lists('name', 'id');
		//	Get initial audit type
		$auditType = $auditFieldGroup->audit_type_id;

        return view('audit.group.edit', compact('auditFieldGroup', 'parents', 'parent', 'auditTypes', 'auditType'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AuditFieldGroupRequest $request, $id)
	{
		$auditFieldGroup = AuditFieldGroup::findOrFail($id);;
        $auditFieldGroup->name = $request->name;
        $auditFieldGroup->parent_id = $request->parent_id;
        $auditFieldGroup->description = $request->description;
        $auditFieldGroup->audit_type_id = $request->audit_type_id;
        $auditFieldGroup->user_id = 1;

        try{
			$auditFieldGroup->save();
			if($request->parent_id){
				$auditFieldGroup->setParent(array($request->parent_id));
			}
			$url = Session::get('SOURCE_URL');
        
        	return redirect('auditFieldGroup')->with('message', 'Audit field group updated successfully.');
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
	public function destroy($id)
	{
		//
	}

}
