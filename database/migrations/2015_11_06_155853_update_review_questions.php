<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReviewQuestions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('review_questions', function($table)
		{
		    $table->tinyInteger('na')->nullable()->after('question_id');
		});
		Schema::table('countries', function(Blueprint $table)
		{
			$table->dropColumn('iso_3166_2');
			$table->dropColumn('iso_3166_3');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('review_questions', function(Blueprint $table)
		{
			$table->dropColumn('na');
		});
	}
}
