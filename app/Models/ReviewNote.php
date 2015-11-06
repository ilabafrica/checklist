<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class ReviewNote extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'review_notes';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'review_question_id',
        'note',
        'non_compliance',
    ];
    /**
     * Review relationship
     */
    public function rq()
    {
       return $this->belongsTo('App\Models\ReviewQuestion');
    }
    /**
     * Review relationship
     */
    public function review_question()
    {
       return $this->belongsTo('App\Models\ReviewQuestion');
    }
}