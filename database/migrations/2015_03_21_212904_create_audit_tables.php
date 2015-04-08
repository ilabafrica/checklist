<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//	Audit Types
		Schema::create('audit_types', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description', 100);
			$table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit Field Groups
		Schema::create('audit_field_groups', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description', 100);
			$table->integer('audit_type_id')->unsigned();
			$table->integer('user_id')->unsigned();

            $table->foreign('audit_type_id')->references('id')->on('audit_types');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit field groups parent-child relationship
		Schema::create('afg_parent_child', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('field_group_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('field_group_id')->references('id')->on('audit_field_groups');
            $table->foreign('parent_id')->references('id')->on('audit_field_groups');
            $table->unique(array('field_group_id','parent_id'));
        });
		//	Audit Fields
		Schema::create('audit_fields', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('audit_field_group_id')->unsigned();
			$table->string('name')->nullable();
			$table->text('label')->nullable();
			$table->text('description')->nullable();
			$table->text('comment')->nullable();
			$table->string('field_type', 100);
			$table->integer('required')->nullable();
			$table->integer('textarea')->nullable();
			$table->string('options')->nullable();
			$table->string('iso')->nullable();
			$table->integer('score')->nullable();

			$table->integer('user_id')->unsigned();

            $table->foreign('audit_field_group_id')->references('id')->on('audit_field_groups');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit fields parent-child relationship
		Schema::create('af_parent_child', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('field_id')->references('id')->on('audit_fields');
            $table->foreign('parent_id')->references('id')->on('audit_fields');
            $table->unique(array('field_id','parent_id'));
        });
		//	Audit Responses
		Schema::create('audit_responses', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('lab_id')->unsigned();
			$table->integer('audit_type_id')->unsigned();
			$table->integer('status');
			$table->integer('update_user_id')->unsigned();

            $table->foreign('audit_type_id')->references('id')->on('audit_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('update_user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit
		Schema::create('audits', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('audit_response_id')->unsigned();
			$table->integer('audit_field_id')->unsigned();
			$table->string('value');

			$table->foreign('audit_response_id')->references('id')->on('audit_responses');
            $table->foreign('audit_field_id')->references('id')->on('audit_fields');

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
		Schema::dropIfExists('audits');
		Schema::dropIfExists('audit_responses');
		Schema::dropIfExists('af_parent_child');
		Schema::dropIfExists('audit_fields');
		Schema::dropIfExists('afg_parent_child');
		Schema::dropIfExists('audit_field_groups');
		Schema::dropIfExists('audit_types');
	}

}
