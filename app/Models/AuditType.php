<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditType extends Model {

	protected $table = 'audit_types';

	/**
	 * Audit field group relationship
	 */
	public function auditFieldGroup()
	{
	  return $this->hasMany('App\Models\AuditFieldGroup');
	}
}
