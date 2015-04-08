<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AuditFieldGroup;
use Illuminate\Support\Facades\DB;

class AuditFieldGroup extends Model {

	protected $table = 'audit_field_groups';

	/**
	 * Audit field relationship
	 */
	public function auditField()
	{
	  return $this->hasMany('App\Models\AuditField');
	}
	/**
	 * Audit field group relationship
	 */
	public function children()
	{
		return $this->belongsToMany('App\Models\AuditFieldGroup', 'afg_parent_child', 'parent_id', 'field_group_id');
	}
	//	Set parent for audit field group if selected
	public function setParent($field){

		$fieldAdded = array();
		$fieldGroupId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'field_group_id' => (int)$this->id,
					'parent_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$fieldGroupId = (int)$this->id;
			}

		}
		// Delete existing parent-child mappings
		DB::table('afg_parent_child')->where('field_group_id', '=', $fieldGroupId)->delete();

		// Add the new mapping
		DB::table('afg_parent_child')->insert($fieldAdded);
	}

	/**
	 * Return parent audit field groups for the audit type selected
	 */
	public static function parentGroups($id)
	{
	  return AuditFieldGroup::where('audit_type_id', $id)
	  									->whereNotIn('id', DB::table('afg_parent_child')->pluck('field_group_id'));
	}

}
