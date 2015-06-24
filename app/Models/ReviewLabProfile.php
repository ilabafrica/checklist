<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class ReviewLabProfile extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'review_lab_profiles';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'review_id',
        'head',
        'head_work_telephone',
        'head_personal_telephone',
        'degree_staff',
        'degree_staff_adequate',
        'diploma_staff',
        'diploma_staff_adequate',
        'certificate_staff',
        'certificate_staff_adequate',
        'microscopist',
        'microscopist_adequate',
        'data_clerk',
        'data_clerk_adequate',
        'phlebotomist',
        'phlebotomist_adequate',
        'cleaner',
        'cleaner_adequate',
        'cleaner_dedicated',
        'cleaner_trained',
        'driver',
        'driver_adequate',
        'driver_dedicated',
        'driver_trained',
        'other_staff',
        'other_staff_adequate',
        'sufficient_space',
        'equipment',
        'supplies',
        'personnel',
        'infrastructure',
        'other',
        'other_description',
    ];
    /**
     * Review relationship
     */
    public function review()
    {
       return $this->belongsTo('App\Models\Review');
    }
}