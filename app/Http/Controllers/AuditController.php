<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\AuditRequest;
use App\Models\AuditType;
use App\Models\Audit;
use App\Models\AuditFieldGroup;
use App\Models\Lab;
use Response;
use Auth;

class AuditController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all audit types
		$auditTypes = AuditType::all();
		return view('audit.audit.index', compact('auditTypes'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get audit type - to be removed later
		$auditType = AuditType::find(1);
		//	Get audit field groups - main first
		$auditFieldGroups = AuditFieldGroup::where('audit_type_id', 1)->get();
		return view('audit.audit.create', compact('auditType', 'auditFieldGroups'));
	}
	/**
	 * Begin the audit in the selected lab
	 *
	 * @return Response
	 */
	public function start($lab, $auditType, $section)
	{
		//	Get the selected lab
		$laboratory = Lab::find($lab);
		//	Get the selected audit
		$audit = AuditType::find($auditType);
		//	Get first audit field group for selected audit
		$page = AuditFieldGroup::find($section);
		//	Get audit field groups - main first
		$auditFieldGroups = AuditFieldGroup::where('audit_type_id', $audit)->get();
		/* Save audit response first */
		if(Auth::check()){
			$user_id = Auth::user()->id;
			$update_user_id = Auth::user()->id;
		}
		return view('audit.audit.create', compact('auditFieldGroups', 'laboratory', 'audit', 'page'));
	}

	/**
	 * Show the form depending on audit type and section selected
	 *
	 * @return Response
	 */
	public function loadPage($auditType, $section)
	{
		//	Get audit field groups - main first
		$auditFieldGroup = AuditFieldGroup::find($section);
		return view('audit.audit.create', compact('auditFieldGroup'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AuditRequest $request)
	{
		//	Save the dynamically created form
		//	Save response first
		dd($request->all());

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
	/**
	 * View audits done
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function response()
	{
		return view('audit.audit.response');
	}
	/**
	 * View audits data done
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function result()
	{
		return view('audit.audit.result');
	}

}
