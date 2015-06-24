<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class ReviewSlmtaInfo extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'review_slmta_info';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'review_id',
        'official_slmta',
        'assessment_id',
        'tests_before_slmta',
        'tests_this_year',
        'cohort_id',
        'baseline_audit_date',
        'slmta_workshop_date',
        'exit_audit_date',
        'baseline_score',
        'baseline_stars_obtained',
        'exit_score',
        'exit_stars_obtained',
        'last_audit_date',
        'last_audit_score',
        'prior_audit_status',
        'audit_start_date',
        'audit_end_date',
    ];
    /**
     * Review relationship
     */
    public function review()
    {
       return $this->belongsTo('App\Models\Review');
    }
	/**
	 * Assessments relationship
	 */
	public function assessment()
	{
	   return $this->belongsTo('App\Models\Assessment');
	}
}