<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface
use Illuminate\Support\Facades\DB;
use Lang;

class Country extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'countries';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'name',
        'code',
        'iso_3166_2',
        'iso_3166_3',
        'capital',
    ];
	/**
	 * Laboratories relationship
	 */
	public function labs()
	{
	  return $this->hasMany('App\Models\Lab');
	}
    /**
     * Partners relationship
     */
    public function partners()
    {
        return $this->belongsToMany('App\Models\Partner', 'country_partners', 'country_id', 'partner_id');
    }
    //  Set partners for the country
    public function setPartners($field){

        $fieldAdded = array();
        $countryId = 0;  

        if(is_array($field)){
            foreach ($field as $key => $value) {
                $fieldAdded[] = array(
                    'country_id' => (int)$this->id,
                    'partner_id' => (int)$value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                    );
                $countryId = (int)$this->id;
            }

        }
        // Delete existing parent-child mappings
        DB::table('country_partners')->where('country_id', '=', $countryId)->delete();

        // Add the new mapping
        DB::table('country_partners')->insert($fieldAdded);
    }
}