<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface
use Illuminate\Support\Facades\DB;
use Lang;

class Lab extends Model implements Revisionable{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'labs';

	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'name',
        'lab_type_id',
        'address',
        'postal_code',
        'city',
        'state',
        'country_id',
        'fax',
        'telephone',
        'email',
        'lab_level_id',
        'lab_affiliation_id',
    ];
	/**
	* Relationship with labLevel
	*/
	public function labLevel()
	{
		return $this->belongsTo('App\Models\LabLevel');
	}

	/**
	* Relationship with labAffiliation
	*/
	public function labAffiliation()
	{
		return $this->belongsTo('App\Models\LabAffiliation');
	}

	/**
	* Relationship with labType
	*/
	public function labType()
	{
		return $this->belongsTo('App\Models\LabType');
	}
	/**
	* Return Lab ID given the name
	* @param $name the name of the laboratory
	*/
	public static function labIdName($name)
	{
		try 
		{
			$lab = Lab::where('name', $name)->orderBy('name', 'asc')->firstOrFail();
			return $lab->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The Laboratory ` $name ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
	/**
	* Relationship with country
	*/
	public function country()
	{
		return $this->belongsTo('App\Models\Country');
	}
	/* 
	* Relationship with Review
	*/
	public function review(){
		return $this->hasMany('App\Models\Review');
	}

public function county()
	{
		return $this->belongsTo('App\Models\County');
	}
}
