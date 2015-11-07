<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface
use Illuminate\Support\Facades\DB;
use Lang;

class Partner extends Model implements Revisionable{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'partners';
	use RevisionableTrait;

    /*
     * Set revisionable whitelist - only changes to any
     * of these fields will be tracked during updates.
     */
    protected $revisionable = [
        'name',
        'head',
        'contact',
    ];
	
    /**
     * Labs relationship
     */
    public function labs()
    {
        return $this->belongsToMany('App\Models\Lab', 'partner_labs', 'partner_id', 'lab_id');
    }
    //  Set labs for the partner
    public function setLabs($field){

        $fieldAdded = array();
        $partnerId = 0;  

        if(is_array($field)){
            foreach ($field as $key => $value) {
                $fieldAdded[] = array(
                    'partner_id' => (int)$this->id,
                    'lab_id' => (int)$value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                    );
                $partnerId = (int)$this->id;
            }

        }
        // Delete existing parent-child mappings
        DB::table('partner_labs')->where('partner_id', '=', $partnerId)->delete();

        // Add the new mapping
        DB::table('partner_labs')->insert($fieldAdded);
    }
}