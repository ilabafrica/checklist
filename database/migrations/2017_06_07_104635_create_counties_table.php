<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Counties table
		/*Schema::create('counties', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');				
            $table->softDeletes();
			$table->timestamps();
		});
		// Update laboratories table
		Schema::table('labs', function(Blueprint $table)
		{
			$table->integer('county_id')->unsigned()->after('country_id')->default(1);
		});*/
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
			$table->dropColumn('county_id');
		});
		Schema::drop('counties');
	}
}
