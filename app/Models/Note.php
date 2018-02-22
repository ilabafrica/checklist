<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class Note extends Model implements Revisionable{

	protected $table = 'notes';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'name',
        'description',
        'audit_type_id',
    ];
	/**
	* Relationship with auditType
	*/
	public function auditType()
	{
	 return $this->belongsTo('App\Models\AuditType');
	}
}
