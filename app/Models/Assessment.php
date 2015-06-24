<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface

class Assessment extends Model implements Revisionable{

	protected $table = 'assessments';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'name',
        'description',
    ];
	/**
	* Return Assessment type id given the name
	* @param $name the name of the assessment type
	*/
	public static function idByName($name)
	{
		try 
		{
			$assessment = Assessment::where('name', $name)->orderBy('name', 'asc')->firstOrFail();
			return $assessment->id;
		}
		catch (ModelNotFoundException $e) 
		{
			Log::error("The Assessment type ` $name ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
}