<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
/* Routes accessible before logging in */
Route::group(array("before" => "guest"), function()
{
	Route::any('/', array(
	    "as" => "auth.login",
	    "uses" => "WelcomeController@index"
	));

    Route::any('user/login', array(
	    "as" => "user.login",
	    "uses" => "Auth\AuthController@postLogin"
	));
    
});
/* Routes accessible before logging in */
Route::group(['middleware' => 'auth'], function(){
    //	Permission controller
    Route::resource('permission', 'PermissionController');
    //	Role controller
    Route::resource('role', 'RoleController');
    //	Privilege controller
    Route::resource('privilege', 'PrivilegeController');
    //	Authorization controller
    Route::resource('authorization', 'AuthorizationController');
    //  Country controller
    Route::resource('country', 'CountryController');
    /* Partner */
    Route::resource('partner', 'PartnerController');
    Route::any('/partner/dropdown', array(
        "as"    =>  "partner.dropdown",
        "uses"  =>  "CountryController@dropdown"
    ));
    //	User controller
    Route::resource('user', 'UserController');
    Route::get("/user/{id}/delete", array(
        "as"   => "user.delete",
        "uses" => "UserController@delete"
    ));
    //	Lab Levels controller
    Route::resource('labLevel', 'LabLevelController');
    Route::get("/labLevel/{id}/delete", array(
        "as"   => "labLevel.delete",
        "uses" => "LabLevelController@delete"
    ));


    //	Lab Affiliations controller
    Route::resource('labAffiliation', 'LabAffiliationController');
    Route::get("/labAffiliation/{id}/delete", array(
        "as"   => "labAffiliation.delete",
        "uses" => "LabAffiliationController@delete"
    ));
    //	Lab Types controller
    Route::resource('labType', 'LabTypeController');
    Route::get("/labType/{id}/delete", array(
        "as"   => "labType.delete",
        "uses" => "LabTypeController@delete"
    ));
    //	Laboratories controller
    Route::resource('lab', 'LabController');
    Route::get("/lab/{id}/delete", array(
        "as"   => "lab.delete",
        "uses" => "LabController@delete"
    ));
    Route::get("/lab/{id}/select", array(
        "as"   => "lab.select",
        "uses" => "LabController@select"
    ));
    Route::get('search/autocomplete', 'LabController@autocomplete');

    //	Audit Types controller
    Route::resource('auditType', 'AuditTypeController');
    Route::get("/auditType/{id}/delete", array(
        "as"   => "auditType.delete",
        "uses" => "AuditTypeController@delete"
    ));


    //	Audit sections controller
    Route::resource('section', 'SectionController');
    Route::get("/section/{id}/delete", array(
        "as"   => "section.delete",
        "uses" => "SectionController@delete"
    ));

    //	Audit field controller
    Route::resource('auditField', 'AuditFieldController');
    Route::get("/auditField/{id}/delete", array(
        "as"   => "auditField.delete",
        "uses" => "AuditFieldController@delete"
    ));

    //	Audits controller
    Route::resource('review', 'ReviewController');
    //  Start an audit
    Route::any("assess", array(
        "as"   => "review.start",
        "uses" => "ReviewController@start"
    ));
    //  Proceed with audit
    Route::any("review/create/{assessment}/{section}", array(
        "as"   => "review.perform",
        "uses" => "ReviewController@create"
    ));
    //  View assessments done
    Route::any("review/assessment/{id}", array(
        "as"   => "review.assessment",
        "uses" => "ReviewController@assessments"
    ));

    //  View assessments summaries
    Route::any("review/summary/{id}", array(
        "as"   => "review.summary",
        "uses" => "ReviewController@summary"
    ));
    //  Proceed with amendment of the audit
    Route::any("review/{id}/edit/{section}", array(
        "as"   => "review.amend",
        "uses" => "ReviewController@amend"
    ));
    //  Save action plan
    Route::any("action/plan", array(
        "as"   => "review.actionPlan",
        "uses" => "ReviewController@plan"
    ));
    //  Answers controller
    Route::resource('answer', 'AnswerController');

    //  Notes controller
    Route::resource('note', 'NoteController');

    //  Assessments - Baseline, Mid-term, Exit etc
    Route::resource('assessment', 'AssessmentController');

    //  Questions controller
    Route::resource('question', 'QuestionController');

    //	Audit data
    Route::any("/result", array(
        "as"   => "audit.result",
        "uses" => "AuditController@result"
    ));
    //  Start an audit
    Route::any("audit/{response}/create", array(
        "as"   => "audit.start",
        "uses" => "AuditController@start"
    ));
    Route::get("audit/{response}/create/{section}", "AuditController@assess");
    //	Load audit page according to audit type and page
    //Route::get("audit/{lab}/{audit}/{section}", "AuditController@loadPage");

    //  Route for ajax loading of selected audit type
    Route::get('/audit/select', array(
        "as"    =>  "audit.select",
        "uses"  =>  "AuditController@selected"
    ));
    //  Reports
    Route::any('/report/{id}', array(
        "as"    =>  "report.index",
        "uses"  =>  "ReportController@index"
    ));
    Route::any('/bar/{id}', array(
        "as"    =>  "report.bar",
        "uses"  =>  "ReportController@bar"
    ));
    Route::any('/spider/{id}', array(
        "as"    =>  "report.spider",
        "uses"  =>  "ReportController@spider"
    ));

    //  Export to excel
    Route::any('/review/{id}/export', array(
        "as"    =>  "report.excel",
        "uses"  =>  "ReportController@export"
    ));
    //  Export non-compliance report to excel
    Route::any('/review/{id}/non-compliance', array(
        "as"    =>  "report.noncompliance",
        "uses"  =>  "ReportController@noncompliance"
    ));
    //  Export summary
    Route::any('/review/summary/{id}/export', array(
        "as"    =>  "report.summary.export",
        "uses"  =>  "ReportController@download"
    ));
    //  Import Audit Data
    Route::any('/import/{id}', array(
        "as"    =>  "report.import",
        "uses"  =>  "ReviewController@import"
    ));
    //  Import Audit Data
    Route::any('/excel/import', array(
        "as"    =>  "excel.import",
        "uses"  =>  "ReviewController@importUserList"
    ));
    //  Mark audit as complete
    Route::any('/review/{id}/complete', array(
        "as"    =>  "report.complete",
        "uses"  =>  "ReviewController@complete"
    ));
    Route::any("report", array(
        "as"   => "review.report",
        "uses" => "ReviewController@assessments"
    ));
});
