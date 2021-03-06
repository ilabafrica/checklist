<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface
use Lang;

class Review extends Model implements Revisionable{
	
	use SoftDeletes;
	use RevisionableTrait;
	protected $dates = ['deleted_at'];
	protected $table = 'reviews';
	/**
	* Official SLMTA?
	*/
	const OFFICIAL = 1;

	/**
	* Completion Status
	*/
	const INCOMPLETE = 0;
	const COMPLETE = 1;
	const FINALIZED = 2;
	const REJECTED = 3;
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
	* Relationship with assessment Type
	*/
	public function assessment($id)
	{
		return Assessment::find($id);
	}
    /**
     * Relationship with workshop #
     */
    public function workshop($id)
    {
        return Workshop::find($id);
    }
	/**
	 * Auditors relationship
	 */
	public function assessors()
	{
	 	return $this->belongsToMany('App\Models\User', 'review_assessors', 'review_id', 'assessor_id');
	}
	//	Set auditors for the review
	public function setAssessors($field,$review_user_id){

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
		DB::table('review_assessors')->where('review_id', '=', $reviewId)->where('assessor_id', '!=', $review_user_id) ->delete();

		// Add the new mapping
		DB::table('review_assessors')->insert($fieldAdded);
	}
	/**
	* SLMTA Information
	*/
	public function slmta()
	{
		return $this->hasOne('App\Models\ReviewSlmtaInfo');
	}
	/**
	* Stars - Not Audited, 0-5
	*/
	public function stars($id)
	{
		if($id == Review::NOTAUDITED)
			return Lang::choice('messages.not-audited', 1);
		else if($id == Review::ZEROSTARS)
			return Lang::choice('messages.zero-stars', 1);
		else if($id == Review::ONESTAR)
			return Lang::choice('messages.one-star', 1);
		else if($id == Review::TWOSTARS)
			return Lang::choice('messages.two-stars', 1);
		else if($id == Review::THREESTARS)
			return Lang::choice('messages.three-stars', 1);
		else if($id == Review::FOURSTARS)
			return Lang::choice('messages.four-stars', 1);
		else if($id == Review::FIVESTARS)
			return Lang::choice('messages.five-stars', 1);
	}
	/**
	* Laboratory Information
	*/
	public function laboratory()
	{
		return $this->hasOne('App\Models\ReviewLabProfile');
	}
	/**
	* Review Question Relationship
	*/
	public function rq()
	{
		return $this->hasMany('App\Models\ReviewQuestion');
	}
	/**
	* Adequate
	*/
	public function adequate($id)
	{
		if($id === Answer::INSUFFICIENT)
			return Lang::choice('messages.insufficient-data', 1);
		else if($id ===Answer::YES)
			return Lang::choice('messages.yes', 1);
		else if($id === Answer::NO)
			return Lang::choice('messages.no', 1);
		else
			return null;
	}
	/**
	* Action plan 
	*/
	public function plans()
	{
		return $this->hasMany('App\Models\ReviewActPlan');
	}
	/**
	* Non-compliancies 
	*/
	public function notes($i=0)
	{
		$summary = [];
		$notes = ReviewNote::whereHas('review_question', function($q){
			$q->where('review_id', $this->id)->whereIn('question_id', Question::where('score', '!=', 0)->lists('id'))->orderBy('question_id', 'ASC');
		})->where('note', '!=', '')->select('review_question_id', 'note')->get();
		foreach ($notes as $note)
		{
			$summary[] = Question::find(ReviewQuestion::find($note->review_question_id)->question_id)->title.' - '.$note->note;
		}
		if($i!=0)
			return $notes;
		else
			return $summary;
	}
}