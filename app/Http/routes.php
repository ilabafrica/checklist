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
Route::get("/user/{id}/delete", array(
    "as"   => "user.delete",
    "uses" => "UserController@delete"
));



//	Facility controller
Route::resource('facility', 'FacilityController');
Route::get("/facility/{id}/delete", array(
    "as"   => "facility.delete",
    "uses" => "FacilityController@delete"
));

//	Facility Types controller
Route::resource('facilityType', 'FacilityTypeController');
Route::get("/facilityType/{id}/delete", array(
    "as"   => "facilityType.delete",
    "uses" => "FacilityTypeController@delete"
));


//	Facility owners controller
Route::resource('facilityOwner', 'FacilityOwnerController');
Route::get("/facilityOwner/{id}/delete", array(
    "as"   => "facilityOwner.delete",
    "uses" => "FacilityOwnerController@delete"
));


//	Job titles controller
Route::resource('title', 'TitleController');
Route::get("/title/{id}/delete", array(
    "as"   => "title.delete",
    "uses" => "TitleController@delete"
));



//	County controller
Route::resource('county', 'CountyController');
Route::get("/county/{id}/delete", array(
    "as"   => "county.delete",
    "uses" => "CountyController@delete"
));

//	Constituency controller
Route::resource('constituency', 'ConstituencyController');

Route::get("/constituency/{id}/delete", array(
    "as"   => "constituency.delete",
    "uses" => "ConstituencyController@delete"
));



//	Towns controller
Route::resource('town', 'TownController');
Route::get("/town/{id}/delete", array(
    "as"   => "town.delete",
    "uses" => "TownController@delete"
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


//	Audit Types controller
Route::resource('auditType', 'AuditTypeController');
Route::get("/auditType/{id}/delete", array(
    "as"   => "auditType.delete",
    "uses" => "AuditTypeController@delete"
));


//	Audit field groups controller
Route::resource('auditFieldGroup', 'AuditFieldGroupController');
Route::get("/auditFieldGroup/{id}/delete", array(
    "as"   => "auditFieldGroup.delete",
    "uses" => "AuditFieldGroupController@delete"
));

//	Audit field controller
Route::resource('auditField', 'AuditFieldController');
Route::get("/auditField/{id}/delete", array(
    "as"   => "auditField.delete",
    "uses" => "AuditFieldController@delete"
));

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