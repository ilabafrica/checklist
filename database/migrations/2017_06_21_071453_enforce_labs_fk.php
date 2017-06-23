<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnforceLabsFk extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Update laboratories table
		Schema::table('labs', function(Blueprint $table)
		{
			$table->foreign('county_id')->references('id')->on('counties');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('labs', function(Blueprint $table)
		{
			$table->dropForeign('labs_county_id_foreign');
		});
	}
}
