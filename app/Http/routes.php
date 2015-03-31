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
//	Permission controller
Route::resource('permission', 'PermissionController');
//	Role controller
Route::resource('role', 'RoleController');
//	Privilege controller
Route::resource('privilege', 'PrivilegeController');
//	Authorization controller
Route::resource('authorization', 'AuthorizationController');
//	User controller
Route::resource('user', 'UserController');
//	Facility Types controller
Route::resource('facilityType', 'FacilityTypeController');
//	Facility owners controller
Route::resource('facilityOwner', 'FacilityOwnerController');
//	Job titles controller
Route::resource('title', 'TitleController');
//	County controller
Route::resource('county', 'CountyController');
//	Constituency controller
Route::resource('constituency', 'ConstituencyController');
//	Towns controller
Route::resource('town', 'TownController');
//	Lab Levels controller
Route::resource('labLevel', 'LabLevelController');
//	Lab Affiliations controller
Route::resource('labAffiliation', 'LabAffiliationController');
//	Lab Types controller
Route::resource('labType', 'LabTypeController');
//	Facilities controller
Route::resource('facility', 'FacilityController');
//	Laboratories controller
Route::resource('lab', 'LabController');
//	Audit Types controller
Route::resource('auditType', 'AuditTypeController');
//	Audit field groups controller
Route::resource('auditFieldGroup', 'AuditFieldGroupController');
//	Audit field controller
Route::resource('auditField', 'AuditFieldController');
//	Audits controller
Route::resource('audit', 'AuditController');
//	Audit responses
Route::any("/response", array(
    "as"   => "audit.response",
    "uses" => "AuditController@response"
));
//	Audit data
Route::any("/result", array(
    "as"   => "audit.result",
    "uses" => "AuditController@result"
));