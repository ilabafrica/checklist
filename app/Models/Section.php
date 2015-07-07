<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class Section extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'sections';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'name',
        'label',
        'description',
        'audit_type_id',
        'total_points',
        'order',
    ];
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
		return $this->belongsTo('App\Models\AuditType', 'audit_type_sections', 'audit_type_id', 'section_id');
	}
	/**
	* Next page relationship
	*/
	public function next()
	{
		return DB::table('audit_type_sections')->where('order', $this->id)->get();
	}
	/**
	* Get Subtotal score
	*/
	public function subtotal($review)
	{
		$sum = 0;
		$rqs = Review::find($review)->rq;
		foreach ($rqs as $rq) {
			if(in_array($rq->question_id, $this->questions->lists('id')))
				$sum+=(int)$rq->qs['audited_score'];
		}
		return $sum;
	}
	/**
	 * Parent relationship
	 */
	public function parent()
	{
		return DB::table('section_parent_child')->where('section_id', $this->id)->first();
	}
	/**
	* Return Lab ID given the name
	* @param $name the name of the section
	*/
	public static function idByName($name)
	{
		try 
		{
			$section = Section::where('name', $name)->orderBy('name', 'asc')->firstOrFail();
			return $section->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The section ` $name ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
	/**
	 * Order column
	 * $id is the id of the audit type in question
	 */
	public function order($id)
	{
		return DB::table('audit_type_sections')->where('section_id', $this->id)->where('audit_type_id', $id)->get();
	}
}