<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//	Lab Levels
		Schema::create('lab_levels', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description', 100);
			$table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Lab Affiliations
		Schema::create('lab_affiliations', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description', 100);
			$table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	SLMTA Lab Types
		Schema::create('lab_types', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description', 100);
			$table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Laboratories
		Schema::create('labs', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('facility_id')->unsigned();
			$table->integer('lab_level_id')->unsigned();
			$table->integer('lab_affiliation_id')->unsigned();
			$table->integer('lab_type_id')->unsigned();
			$table->integer('user_id')->unsigned();

            $table->foreign('facility_id')->references('id')->on('facilities');
            $table->foreign('lab_level_id')->references('id')->on('lab_levels');
            $table->foreign('lab_affiliation_id')->references('id')->on('lab_affiliations');
            $table->foreign('lab_type_id')->references('id')->on('lab_types');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('labs');
		Schema::dropIfExists('lab_levels');
		Schema::dropIfExists('lab_affiliations');
		Schema::dropIfExists('lab_types');
	}

}
