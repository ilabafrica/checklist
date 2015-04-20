<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;


class Question extends Model {
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'questions';
	//	Constants for type of field
	const CHOICE = 0;
	const DATE = 1;
	const FIELD = 2;

	//	Constants for whether field is required
	const REQUIRED = 1;
	//	Constants for whether field is to include tabular display
	const ONESTAR = 1;
	/**
	 * Audit field relationship
	 */
	public function children()
	{
		return $this->belongsToMany('App\Models\Question', 'question_parent_child', 'parent_id', 'question_id');
	}
	/**
	 * answers relationship
	 */
	public function answers()
	{
	  return $this->belongsToMany('App\Models\Answer', 'question_answers', 'answer_id', 'question_id');
	}
	/**
	 * answers relationship
	 */
	public function notes()
	{
	  return $this->belongsToMany('App\Models\Note', 'question_notes', 'note_id', 'question_id');
	}
	//	Set parent for audit field if selected
	public function setParent($field){

		$fieldAdded = array();
		$questionId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'question_id' => (int)$this->id,
					'parent_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$questionId = (int)$this->id;
			}

		}
		// Delete existing parent-child mappings
		DB::table('question_parent_child')->where('question_id', '=', $questionId)->delete();

		// Add the new mapping
		DB::table('question_parent_child')->insert($fieldAdded);
	}
	//	Set parent for audit field if selected
	public function setAnswers($field){

		$fieldAdded = array();
		$questionId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'question_id' => (int)$this->id,
					'answer_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$questionId = (int)$this->id;
			}

		}
		// Delete existing parent-child mappings
		DB::table('question_answers')->where('question_id', '=', $questionId)->delete();

		// Add the new mapping
		DB::table('question_answers')->insert($fieldAdded);
	}
	//	Set parent for audit field if selected
	public function setNotes($field){

		$fieldAdded = array();
		$questionId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'question_id' => (int)$this->id,
					'note_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$questionId = (int)$this->id;
			}

		}
		// Delete existing question-note mappings
		DB::table('question_notes')->where('question_id', '=', $questionId)->delete();

		// Add the new mapping
		DB::table('question_notes')->insert($fieldAdded);
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
