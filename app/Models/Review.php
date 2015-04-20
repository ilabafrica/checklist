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
	* Stars
	*/
	const NOTAUDITED = 0;
	const ZEROSTARS = 1;
	const ONESTAR = 2;
	const TWOSTARS = 3;
	const THREESTARS = 4;
	const FOURSTARS = 5;
	const FIVESTARS = 6;

	/**
	* Answers for Staffing Summary
	*/
	const INSUFFICIENT = 0;
	const YES = 2;
	const NO = 2;

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
	/**
	 * Auditors relationship
	 */
	public function assessors()
	{
	 	return $this->belongsToMany('App\Models\User', 'section_notes', 'section_id', 'note_id');
	}
	//	Set auditors for the review
	public function setAssessors($field){

		$fieldAdded = array();
		$reviewId = 0;	

		if(is_array($field)){
			foreach ($field as $key => $value) {
				$fieldAdded[] = array(
					'review_id' => (int)$this->id,
					'assessor_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$reviewId = (int)$this->id;
			}

		}
		// Delete existing parent-child mappings
		DB::table('review_assessors')->where('review_id', '=', $reviewId)->delete();

		// Add the new mapping
		DB::table('review_assessors')->insert($fieldAdded);
	}
}