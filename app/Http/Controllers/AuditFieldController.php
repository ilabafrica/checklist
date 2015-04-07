<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\AuditFieldRequest;
use App\Models\AuditField;
use App\Models\AuditFieldGroup;
use Response;

class AuditFieldController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all audit fields
		$auditFields = AuditField::all();
		return view('audit.field.index', compact('auditFields'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get parent fields
		$parents = AuditField::lists('label', 'id');
		//	Get all audit field groups
		$auditFieldGroups = AuditFieldGroup::lists('name', 'id');
		//	Field types
		$fieldTypes = array(AuditField::HEADING=>'Heading', AuditField::INSTRUCTION=>'Instruction', AuditField::LABEL=>'Label', AuditField::QUESTION=>'Question', AuditField::SUBHEADING=>'Sub-heading', AuditField::TEXT=>'Text', AuditField::DATE=>'Date', AuditField::CHOICE=>'Radiobutton', AuditField::SELECT=>'Select list', AuditField::TEXTAREA=>'Text Area', AuditField::CHECKBOX=>'Checkbox', AuditField::MAINQUESTION=>'Main Question', AuditField::SUBQUESTION=>'Sub Question', AuditField::STANDARD=>'Standard', AuditField::MAININSTRUCTION=>'Main Instruction', AuditField::SUBINSTRUCTION=>'Sub Instruction');
		return view('audit.field.create', compact('parents', 'auditFieldGroups', 'fieldTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AuditFieldRequest $request)
	{
		//	Get the values
		$auditField = new AuditField;
		$auditField->audit_field_group_id = $request->audit_field_group_id;
		$auditField->name = $request->name;
		$auditField->label = $request->label;
		$auditField->description = $request->description;
		$auditField->comment = $request->comment;
		$auditField->field_type = $request->field_type;
		$auditField->required = $request->required;
		$auditField->table = $request->table;
		$auditField->options = $request->options;
		$auditField->iso = $request->iso;
		$auditField->score = $request->score;
		$auditField->user_id = 1;
		try{
			$auditField->save();
			if($request->parent_id){
				$auditField->setParent(array($request->parent_id));
			}
			//$url = Session::get('SOURCE_URL');
        
        	return redirect('auditField')->with('message', 'Audit field created successfully.');
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
		//show an Audit field
		$auditField = AuditField::find($id);
		//show the view and pass the $auditFieldGroup to it
		return view('audit.field.show', compact('auditField'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get audit field
		$auditField = AuditField::find($id);
		//	Get parent fields
		$parents = AuditField::lists('name', 'id');
		//	Get initially selected parent
		$parent = $auditField->parent_id;
		//	Get all audit field groups
		$auditFieldGroups = AuditFieldGroup::lists('name', 'id');
		//	Get audit field group
		$auditFieldGroup = $auditField->audit_field_group_id;
		//	Field types
		$fieldTypes = array(AuditField::HEADING=>'Heading', AuditField::INSTRUCTION=>'Instruction', AuditField::LABEL=>'Label', AuditField::QUESTION=>'Question', AuditField::SUBHEADING=>'Sub-heading', AuditField::TEXT=>'Text', AuditField::DATE=>'Date', AuditField::CHOICE=>'Radiobutton', AuditField::SELECT=>'Select list', AuditField::TEXTAREA=>'Text Area', AuditField::CHECKBOX=>'Checkbox', AuditField::MAINQUESTION=>'Main Question', AuditField::SUBQUESTION=>'Sub Question', AuditField::STANDARD=>'Standard', AuditField::MAININSTRUCTION=>'Main Instruction', AuditField::SUBINSTRUCTION=>'Sub Instruction');
		//	Get field type
		$fieldType = $auditField->field_type;
		return view('audit.field.edit', compact('auditField', 'parents', 'auditFieldGroups', 'fieldTypes', 'parent', 'auditFieldGroup', 'fieldType'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AuditFieldRequest $request, $id)
	{
		$auditField = AuditField::find($id);
		$auditField->audit_field_group_id = $request->audit_field_group_id;
		$auditField->name = $request->name;
		$auditField->label = $request->label;
		$auditField->description = $request->description;
		$auditField->comment = $request->comment;
		$auditField->field_type = $request->field_type;
		$auditField->required = $request->required;
		$auditField->table = $request->table;
		$auditField->options = $request->options;
		$auditField->iso = $request->iso;
		$auditField->score = $request->score;
		$auditField->user_id = 1;

		try{
			$auditField->save();
			if($request->parent_id){
				$auditField->setParent(array($request->parent_id));
			}
			//$url = Session::get('SOURCE_URL');
        
        	return redirect('auditField')->with('message', 'Audit field updated successfully.');
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
		$auditField= AuditField::find($id);
		$auditField->delete();
		return redirect('auditField')->with('message', 'AuditField deleted successfully.');
	}
	public function destroy($id)
	{
		//
	}

}
