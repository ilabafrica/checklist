<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface
use DB;

class AuditType extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'audit_types';

	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'name',
        'description',
    ];

	/**
	 * Audit section relationship
	 */
	public function sections()
	{
	 	return $this->belongsToMany('App\Models\Section', 'audit_type_sections', 'audit_type_id', 'section_id');
	}
	/**
	 * Reviews relationship
	 */
	public function reviews()
	{
		return $this->hasMany('App\Models\Review');
	}
	/**
	 * Set applicable sections for the audit type
	 */
	public function setSections($field){

		$fieldAdded = array();
		$auditTypeId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'audit_type_id' => (int)$this->id,
					'section_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$auditTypeId = (int)$this->id;
			}

		}
		// Delete existing audit-type-sections mappings
		DB::table('audit_type_sections')->where('audit_type_id', '=', $auditTypeId)->delete();

		// Add the new mapping
		DB::table('audit_type_sections')->insert($fieldAdded);
	}
	/**
	* Return audit type ID given the name
	* @param $name the name of the audit-type
	*/
	public static function idByName($name)
	{
		try 
		{
			$audit_type = AuditType::where('name', $name)->orderBy('name', 'asc')->firstOrFail();
			return $audit_type->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The audit type ` $name ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
}