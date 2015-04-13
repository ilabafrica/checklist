<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\AuditRequest;
use App\Models\AuditType;
use App\Models\Audit;
use App\Models\AuditFieldGroup;
use App\Models\Lab;
use App\Models\AuditResponse;
use Response;
use Auth;
use Input;

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
	public function assess($response, $section)
	{
		$assessment = AuditResponse::find($response);
		//	Get the selected lab
		$laboratory = $assessment->lab;
		//	Get the selected audit
		$audit = $assessment->auditType;
		//	Get first audit field group for selected audit
		$page = AuditFieldGroup::find($section);
		return view('audit.audit.create', compact('assessment', 'laboratory', 'audit', 'page'));
	}

	/**
	 * Show the form depending on audit type and section selected
	 *
	 * @return Response
	 */
	public function start($response)
	{
		$assessment = AuditResponse::find($response);
		//	Get the selected lab
		$laboratory = $assessment->lab;
		//	Get the selected audit
		$audit = $assessment->auditType;
		//	Get first audit field group for selected audit
		$page = $audit->auditFieldGroup->first();
		return view('audit.audit.create', compact('assessment', 'laboratory', 'audit', 'page'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AuditRequest $request)
	{
		//dd(count(Input::all()));
		//	Save the dynamically created form
		$audit = new Audit;
		dd($request->all());
		for($i = 0; $i<count($request->all()); $i++){
			var_dump($request[$i]);
		}
		/*foreach ($request->all() as $key => $value) {
			//var_dump($request->8);
			$audit->audit_response_id = $request->audit_response_id;
			$audit->audit_field_id = $key;
			$audit->value = $value;
			$audit->save();
		}*/
		//$audit->save();
		//dd($request->all());

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
	/**
	 * Return audit type selected to display in status
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function selected()
	{
		$input = Input::get('option');
        $audit = AuditType::find($input);
        return Response::make($audit->get(['id','name']));
	}
}
