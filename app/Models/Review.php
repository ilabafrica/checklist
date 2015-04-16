<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {

	protected $table = 'reviews';
	/**
	* Completion Status
	*/
	const COMPLETE = 1;
	const INCOMPLETE = 0;

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