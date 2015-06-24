<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class ReviewQuestion extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'review_questions';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'review_id',
        'question_id',
    ];
    /**
     * Review relationship
     */
    public function review()
    {
       return $this->belongsTo('App\Models\Review');
    }
	/**
	 * Questions relationship
	 */
	public function question()
	{
	   return $this->belongsTo('App\Models\Question');
	}
    /**
     * Question-answer relationship
     */
    public function qa()
    {
       return $this->hasOne('App\Models\ReviewQAnswer');
    }
    /**
     * Question-score relationship
     */
    public function qs()
    {
       return $this->hasOne('App\Models\ReviewQScore');
    }
    /**
     * Question-note relationship
     */
    public function qn()
    {
       return $this->hasOne('App\Models\ReviewNote');
    }
}