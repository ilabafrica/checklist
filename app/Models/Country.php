<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model {
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'countries';

	/**
	 * Laboratories relationship
	 */
	public function labs()
	{
	  return $this->hasMany('App\Models\Lab');
	}
}