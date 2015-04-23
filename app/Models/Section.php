<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model {
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'sections';

	/**
	 * Questions relationship
	 */
	public function questions()
	{
		return $this->hasMany('App\Models\Question');
	}
	/**
	 * Notes relationship
	 */
	public function notes()
	{
	 	return $this->belongsToMany('App\Models\Note', 'section_notes', 'section_id', 'note_id');
	}
	/**
	 * Audit field group relationship
	 */
	public function children()
	{
		return $this->belongsToMany('App\Models\Section', 'section_parent_child', 'parent_id', 'section_id');
	}
	//	Set parent for audit field group if selected
	public function setParent($field){

		$fieldAdded = array();
		$sectionId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'section_id' => (int)$this->id,
					'parent_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$sectionId = (int)$this->id;
			}

		}
		// Delete existing parent-child mappings
		DB::table('section_parent_child')->where('section_id', '=', $sectionId)->delete();

		// Add the new mapping
		DB::table('section_parent_child')->insert($fieldAdded);
	}
	//	Set notes for section if selected
	public function setNotes($field){

		$fieldAdded = array();
		$sectionId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'section_id' => (int)$this->id,
					'note_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$sectionId = (int)$this->id;
			}

		}
		// Delete existing parent-child mappings
		DB::table('section_notes')->where('section_id', '=', $sectionId)->delete();

		// Add the new mapping
		DB::table('section_notes')->insert($fieldAdded);
	}
	/**
	 * Return parent audit field groups for the audit type selected
	 */
	public static function parentGroups($id)
	{
	 	return AuditFieldGroup::where('audit_type_id', $id)
	  									->whereNotIn('id', DB::table('section_parent_child')->pluck('section_id'));
	}

	/**
	* Relationship with auditType
	*/
	public function auditType()
	{
		return $this->belongsTo('App\Models\AuditType');
	}
	/**
	* Next page relationship
	*/
	public function next()
	{
		return Section::where('order', $this->id)->get();
	}
}
