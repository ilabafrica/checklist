<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditResponse extends Model {

	protected $table = 'audit_responses';
	/**
	* Completion Status
	*/
	const COMPLETE = 1;
	const INCOMPLETE = 0;

	/**
	* Relationship with audit/audit results
	*/
	public function audits()
	{
	 return $this->hasMany('App\Models\Audit');
	}
	/**
	* Relationship with laboratory
	*/
	public function lab()
	{
	 return $this->belongsTo('App\Models\Lab');
	}
	/**
	* Relationship with user
	*/
	public function user()
	{
	 return $this->belongsTo('App\Models\User');
	}
	/**
	* Relationship with audit Type
	*/
	public function auditType()
	{
	 return $this->belongsTo('App\Models\AuditType');
	}
}