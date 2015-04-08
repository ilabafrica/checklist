<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditType extends Model {
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'audit_types';

	/**
	 * Audit field group relationship
	 */
	public function auditFieldGroup()
	{
	  return $this->hasMany('App\Models\AuditFieldGroup');
	}
}
