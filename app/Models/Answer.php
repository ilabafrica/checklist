<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {

	protected $table = 'answers';
	/**
	* Answers for questions
	*/
	const INSUFFICIENT = 0;
	const YES = 1;
	const NO = 2;
	/**
	* Notes - Compliant(Comment) vs Non/compliant
	*/
	const NONCOMPLIANT = 1;

}
