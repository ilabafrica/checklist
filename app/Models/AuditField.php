<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuditField extends Model {

	protected $table = 'audit_fields';
	//	Constants for type of field
	const HEADING = 0;
	const INSTRUCTION = 1;
	const LABEL = 2;
	const QUESTION = 3;
	const SUBHEADING = 4;
	const TEXT = 5;
	const DATE = 6;
	const CHOICE = 7;
	const SELECT = 8;
	const TEXTAREA = 9;
	const CHECKBOX = 10;
	const MAINQUESTION = 11;
	const SUBQUESTION = 12;
	const STANDARD = 13;
	const MAININSTRUCTION = 14;
	const SUBINSTRUCTION = 15;

	//	Constants for whether field is required
	const REQUIRED = 1;
	//	Constants for whether field is to include tabular display
	const TXTAREA = 1;
	/**
	 * Audit field relationship
	 */
	public function children()
	{
		return $this->belongsToMany('App\Models\AuditField', 'af_parent_child', 'parent_id', 'field_id');
	}
	//	Set parent for audit field if selected
	public function setParent($field){

		$fieldAdded = array();
		$fieldId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'field_id' => (int)$this->id,
					'parent_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$fieldId = (int)$this->id;
			}

		}
		// Delete existing parent-child mappings
		DB::table('af_parent_child')->where('field_id', '=', $fieldId)->delete();

		// Add the new mapping
		DB::table('af_parent_child')->insert($fieldAdded);
	}
	/**
	 * Display audit field according to field type
	 */
	/**
	 * Display audit field according to field type
	 */
	/*public function fieldHTML($fieldType)
	{
		switch($fieldType){
			case AuditField::HEADING:
				break;
			case AuditField::INSTRUCTION:
				break;
			case AuditField::LABEL:
				break;
			case AuditField::QUESTION:
				break;
			case AuditField::SUBHEADING:
				break;
			case AuditField::TEXT:
				break;
			case AuditField::DATE:
				break;
			case AuditField::CHOICE:
				break;
			case AuditField::SELECT:
				break;
			case AuditField::TEXTAREA:
				break;
			case AuditField::CHECKBOX:
				break;
			case AuditField::MAINQUESTION:
				break;
			case AuditField::SUBQUESTION:
				break;
		}

		return $this->belongsToMany('App\Models\AuditField', 'af_parent_child', 'parent_id', 'field_id');
	}*/
}
