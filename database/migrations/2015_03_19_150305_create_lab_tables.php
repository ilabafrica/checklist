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
		//	Countries
		Schema::create('countries', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('code', 100);
			$table->string('capital', 100);
			$table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//Counties
		Schema::create('counties', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');		
				
            $table->softDeletes();
			$table->timestamps();
		});
		
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
			$table->string('name')->nullable();
			$table->string('lab_number')->nullable();
			$table->integer('lab_type_id')->unsigned();
			$table->integer('lab_level_id')->unsigned();
			$table->integer('lab_affiliation_id')->unsigned();
			$table->string('address', 100)->nullable();
			$table->string('postal_code', 100)->nullable();
			$table->string('postal_address', 100)->nullable();
			$table->integer('county_id')->unsigned();
			$table->string('subcounty')->nullable();
			$table->string('state')->nullable();
			$table->integer('country_id')->unsigned();
			$table->string('fax')->nullable();
			$table->string('telephone')->nullable();
			$table->string('email')->nullable();
			
			$table->integer('user_id')->unsigned();

			$table->foreign('country_id')->references('id')->on('countries');
			$table->foreign('county_id')->references('id')->on('counties');
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
		Schema::dropIfExists('countries');
	}
}