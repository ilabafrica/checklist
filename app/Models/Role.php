<?php namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable; // interface
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole implements Revisionable
{
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
    * Function for getting the admin role, currently the first user
    *  
    */
    public static function getAdminRole()
    {
        return Role::find(1);
    }
}