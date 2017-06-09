<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model {

	protected $table = 'counties';
	
	public function labs(){
		return $this->hasMany('App\Models\Lab');
	}
}
