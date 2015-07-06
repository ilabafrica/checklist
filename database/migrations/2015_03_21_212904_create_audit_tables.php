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
		//	Assessments
		Schema::create('assessments', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description', 100);
			$table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Paragraphs of text within the audit
		Schema::create('notes', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->text('description');
			$table->integer('audit_type_id')->unsigned();
			$table->integer('user_id')->unsigned();

            $table->foreign('audit_type_id')->references('id')->on('audit_types');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit Field Groups - Sections
		Schema::create('sections', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('label')->nullable();
			$table->string('description', 100);
			$table->integer('audit_type_id')->unsigned();
			$table->smallInteger('total_points')->nullable();
			$table->smallInteger('order');
			$table->integer('user_id')->unsigned();

            $table->foreign('audit_type_id')->references('id')->on('audit_types');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit field groups parent-child relationship
		Schema::create('section_parent_child', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('parent_id')->references('id')->on('sections');
            $table->unique(array('section_id','parent_id'));
        });
        //	Section notes
        Schema::create('section_notes', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('section_id')->unsigned();
			$table->integer('note_id')->unsigned();

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('note_id')->references('id')->on('notes');
            $table->unique(array('section_id','note_id'));

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit Fields - Questions
		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('section_id')->unsigned();
			$table->string('name')->nullable();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->tinyInteger('question_type');
			$table->integer('required')->nullable();
			$table->string('info')->nullable();
			$table->string('comment')->nullable();
			$table->integer('score')->nullable();
			$table->tinyInteger('one_star')->nullable();

			$table->integer('user_id')->unsigned();

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit fields parent-child relationship
		Schema::create('question_parent_child', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('parent_id')->references('id')->on('questions');
            $table->unique(array('question_id','parent_id'));
        });
        //	Question notes
        Schema::create('question_notes', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('question_id')->unsigned();
			$table->integer('note_id')->unsigned();

            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('note_id')->references('id')->on('notes');
            $table->unique(array('question_id','note_id'));

            $table->softDeletes();
			$table->timestamps();
		});
        //	Audit answers to the questions
		Schema::create('answers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->integer('user_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
        //	Audit question-answers
		Schema::create('question_answers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('answer_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('answer_id')->references('id')->on('answers');
            $table->unique(array('question_id','answer_id'));
        });
		//	Audit Responses
		Schema::create('reviews', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('lab_id')->unsigned();
			$table->integer('audit_type_id')->unsigned();
			$table->text('summary_commendations')->nullable();
			$table->text('summary_challenges')->nullable();
			$table->text('recommendations')->nullable();
			$table->smallInteger('total_points')->nullable();
			$table->tinyInteger('stars')->nullable();
			$table->integer('status');
			$table->integer('user_id')->unsigned();
			$table->integer('update_user_id')->unsigned();

            $table->foreign('audit_type_id')->references('id')->on('audit_types');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('update_user_id')->references('id')->on('users');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Laboratory profile review
		Schema::create('review_lab_profiles', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_id')->unsigned();
			$table->string('head')->nullable();
			$table->string('head_work_telephone')->nullable();
			$table->string('head_personal_telephone')->nullable();
			$table->tinyInteger('degree_staff')->nullable();
			$table->tinyInteger('degree_staff_adequate')->nullable();
			$table->tinyInteger('diploma_staff')->nullable();
			$table->tinyInteger('diploma_staff_adequate')->nullable();
			$table->tinyInteger('certificate_staff')->nullable();
			$table->tinyInteger('certificate_staff_adequate')->nullable();
			$table->tinyInteger('microscopist')->nullable();
			$table->tinyInteger('microscopist_adequate')->nullable();
			$table->tinyInteger('data_clerk')->nullable();
			$table->tinyInteger('data_clerk_adequate')->nullable();
			$table->tinyInteger('phlebotomist')->nullable();
			$table->tinyInteger('phlebotomist_adequate')->nullable();
			$table->tinyInteger('cleaner')->nullable();
			$table->tinyInteger('cleaner_adequate')->nullable();
			$table->tinyInteger('cleaner_dedicated')->nullable();
			$table->tinyInteger('cleaner_trained')->nullable();
			$table->tinyInteger('driver')->nullable();
			$table->tinyInteger('driver_adequate')->nullable();
			$table->tinyInteger('driver_dedicated')->nullable();
			$table->tinyInteger('driver_trained')->nullable();
			$table->tinyInteger('other_staff')->nullable();
			$table->tinyInteger('other_staff_adequate')->nullable();
			$table->tinyInteger('sufficient_space')->nullable();
			$table->tinyInteger('equipment')->nullable();
			$table->tinyInteger('supplies')->nullable();
			$table->tinyInteger('personnel')->nullable();
			$table->tinyInteger('infrastructure')->nullable();
			$table->tinyInteger('other')->nullable();
			$table->string('other_description')->nullable();

			$table->foreign('review_id')->references('id')->on('reviews');
            
            $table->softDeletes();
			$table->timestamps();
		});
		//	SLMTA Info
		Schema::create('review_slmta_info', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_id')->unsigned();
			$table->tinyInteger('official_slmta')->nullable();
			$table->integer('assessment_id')->unsigned();
			$table->smallInteger('tests_before_slmta')->nullable();
			$table->smallInteger('tests_this_year')->nullable();
			$table->smallInteger('cohort_id')->nullable();
			$table->date('baseline_audit_date')->nullable();
			$table->date('slmta_workshop_date')->nullable();
			$table->date('exit_audit_date')->nullable();
			$table->smallInteger('baseline_score')->nullable();
			$table->smallInteger('baseline_stars_obtained');
			$table->smallInteger('exit_score')->nullable();
			$table->smallInteger('exit_stars_obtained');
			$table->date('last_audit_date')->nullable();
			$table->smallInteger('last_audit_score')->nullable();
			$table->tinyInteger('prior_audit_status');
			$table->date('audit_start_date')->nullable();
			$table->date('audit_end_date')->nullable();

			$table->foreign('review_id')->references('id')->on('reviews');
			$table->foreign('assessment_id')->references('id')->on('assessments');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Questions done for review
		Schema::create('review_questions', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_id')->unsigned();
			$table->integer('question_id')->unsigned();

			$table->foreign('review_id')->references('id')->on('reviews');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->unique(array('review_id', 'question_id'));

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit response sections
		Schema::create('review_question_scores', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_question_id')->unsigned();
			$table->smallInteger('audited_score');

			$table->foreign('review_question_id')->references('id')->on('review_questions');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit data
		Schema::create('review_question_answers', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_question_id')->unsigned();
			$table->string('answer')->nullable();

			$table->foreign('review_question_id')->references('id')->on('review_questions');
            
            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit Comment/Non-compliance
		Schema::create('review_notes', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_question_id')->unsigned();
			$table->text('note')->nullable();
			$table->string('non_compliance')->nullable();

			$table->foreign('review_question_id')->references('id')->on('review_questions');
            
            $table->softDeletes();
			$table->timestamps();
		});
		//	Audit Action plan
		Schema::create('review_action_plans', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_id')->unsigned();
			$table->text('action')->nullable();
			$table->string('responsible_person')->nullable();
			$table->string('timeline')->nullable();

			$table->foreign('review_id')->references('id')->on('reviews');

            $table->softDeletes();
			$table->timestamps();
		});
		//	Auditors
		Schema::create('review_assessors', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('review_id')->unsigned();
			$table->integer('assessor_id')->unsigned();

			$table->foreign('review_id')->references('id')->on('reviews');
			$table->foreign('assessor_id')->references('id')->on('users');
			
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
		Schema::dropIfExists('review_auditors');
		Schema::dropIfExists('review_action_plans');
		Schema::dropIfExists('review_notes');
		Schema::dropIfExists('review_question_answers');
		Schema::dropIfExists('review_sections');
		Schema::dropIfExists('reviews');
		Schema::dropIfExists('question_answers');
		Schema::dropIfExists('answers');
		Schema::dropIfExists('question_notes');
		Schema::dropIfExists('question_parent_child');
		Schema::dropIfExists('questions');
		Schema::dropIfExists('section_notes');
		Schema::dropIfExists('section_parent_child');
		Schema::dropIfExists('sections');
		Schema::dropIfExists('notes');
		Schema::dropIfExists('audit_types');
	}

}
