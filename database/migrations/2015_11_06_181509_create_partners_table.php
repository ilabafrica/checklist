<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* Partners */
		Schema::create('partners', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('head', 100);
			$table->string('contact', 500);
			$table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		/* Country-partners */
		Schema::create('country_partners', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('country_id')->unsigned();
			$table->integer('partner_id')->unsigned();

			$table->foreign('country_id')->references('id')->on('countries');
			$table->foreign('partner_id')->references('id')->on('partners');
			
            $table->softDeletes();
			$table->timestamps();
		});
		/* partner-labs */
		Schema::create('partner_labs', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('partner_id')->unsigned();
			$table->integer('lab_id')->unsigned();

			$table->foreign('partner_id')->references('id')->on('partners');
			$table->foreign('lab_id')->references('id')->on('labs');
			
            $table->softDeletes();
			$table->timestamps();
		});
		/* user-tiers for partner/country*/
		Schema::create('user_tiers', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->tinyInteger('tier');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->unique(array('user_id','role_id'));

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
		Schema::dropIfExists('partner_assessors');
		Schema::dropIfExists('partner_labs');
		Schema::dropIfExists('country_partners');
		Schema::dropIfExists('partners');
	}
}
