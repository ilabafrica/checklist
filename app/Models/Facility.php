<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model {
 use SoftDeletes;
 protected $dates = ['deleted_at'];
 protected $table = 'facilities';



/**
* Relationship with facility type
*/
public function facilityType()
{
 return $this->belongsTo('App\Models\facilityType');
}
}
