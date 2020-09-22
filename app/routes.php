<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */
	/*if (App::environment('remote')) {
    URL::forceSchema('https');
	}*/
// Admin
Route::group(array('prefix' => 'admin', 'before' => 'admin'), function()
{
    Route::any('/', array('as' => '/', 'uses' => 'Admin_HomeController@index'));
    Route::any('/Dashboard', array('as' => 'admindashboard', 'uses' => 'Admin_HomeController@dashboard'));
    Route::any('/Depatman/{id}', array('as' => 'admindepartment', 'uses' => 'Admin_HomeController@department'));
Route::any('/city/{dept}/{city}', array('as' => 'admincity', 'uses' => 'Admin_HomeController@city'));
    Route::post('/Login', array('as' => 'adminlogin', 'uses' => 'Admin_UsersController@login'));
    Route::any('/Logout', array('as' => 'adminlogout', 'uses' => 'Admin_UsersController@logout'));
    Route::any('/Itilizate-Yo', array('as' => 'adminusers', 'before' => 'auth', 'uses' => 'Admin_UsersController@index'));
    Route::any('/Add-Itilizate', array('as' => 'admincreateuser', 'before' => 'auth', 'uses' => 'Admin_UsersController@create'));
    Route::any('/Edit-Itilizate/{id}', array('as' => 'adminedituser', 'before' => 'auth', 'uses' => 'Admin_UsersController@edit'));
    Route::any('/Remodpas/{id}', array('as' => 'adminresetpass', 'before' => 'auth', 'uses' => 'Admin_UsersController@resetpass'));
    Route::any('/Ajan-Yo/{id?}/{city?}', array('as' => 'adminagents', 'before' => 'auth', 'uses' => 'Admin_AgentsController@index'));
    Route::any('/Add-Ajan', array('as' => 'admincreateagent', 'before' => 'auth', 'uses' => 'Admin_AgentsController@create'));
    Route::any('/Edit-Ajan/{id}', array('as' => 'admineditagent', 'before' => 'auth', 'uses' => 'Admin_AgentsController@edit'));
    Route::any('/Komin-Ajan/{id}', array('as' => 'adminagentscity', 'uses' => 'Admin_AgentsController@city'));
    Route::any('/Ajan-Depatman/', array('as' => 'adminagentdepartment', 'uses' => 'Admin_AgentsController@department'));
	Route::any('/agentBlaklis/', array('as' => 'adminagentsblacklist', 'uses' => 'Admin_AgentsController@blacklist'));
    Route::any('/Bef/{id?}/{city?}', array('as' => 'adminanimals', 'before' => 'auth', 'uses' => 'Admin_AnimalsController@index'));
    // Route::any('/abbatages/{id?}', array('as' => 'adminabbatages', 'before' => 'auth', 'uses' => 'Admin_AnimalsController@abbatage'));
    Route::any('/Add-Bef/{id?}', array('as' => 'admincreateanimal', 'before' => 'auth', 'uses' => 'Admin_AnimalsController@create'));
    Route::any('/Edit-Bef/{id}', array('as' => 'admineditanimal', 'before' => 'auth', 'uses' => 'Admin_AnimalsController@edit'));
    Route::any('/Komin-Bef/{id}', array('as' => 'adminanimalscity', 'uses' => 'Admin_AnimalsController@city'));
    Route::any('/Blaklis/', array('as' => 'adminanimalsblacklist', 'uses' => 'Admin_AnimalsController@blacklist'));
    Route::any('/Elve-Yo/{id?}/{city?}', array('as' => 'admineleveurs', 'before' => 'auth', 'uses' => 'Admin_EleveursController@index'));
    Route::any('/Add-Elve', array('as' => 'admincreateeleveur', 'before' => 'auth', 'uses' => 'Admin_EleveursController@create'));
    Route::any('/Edit-Elve/{id}', array('as' => 'adminediteleveur', 'before' => 'auth', 'uses' => 'Admin_EleveursController@edit'));
    Route::any('/Komin-Elve/{id}', array('as' => 'admineleveurscity', 'uses' => 'Admin_EleveursController@city'));
    Route::any('/Add-Remak/', array('as' => 'admincreatenotification', 'before' => 'auth', 'uses' => 'Admin_NotificationsController@create'));
    Route::any('/Labatwa-Yo/{id?}/{city?}', array('as' => 'adminabattoirs', 'before' => 'auth', 'uses' => 'Admin_AbattoirsController@index'));
    Route::any('/Add-Abatwa/', array('as' => 'admincreateabattoir', 'before' => 'auth', 'uses' => 'Admin_AbattoirsController@create'));
    Route::any('/Edit-Labatwa/{id}', array('as' => 'admineditabattoir', 'before' => 'auth', 'uses' => 'Admin_AbattoirsController@edit'));
    Route::any('/Labatwa-Depatman/', array('as' => 'abbatoirdepartment', 'before' => 'auth', 'uses' => 'Admin_AbattoirsController@abbatoirdepartment'));
    Route::any('/Labatwa/{id?}', array('as' => 'adminabbatages', 'before' => 'auth', 'uses' => 'Admin_AbattoirsController@index'));
    Route::any('/Rapo-Depatman-Yo', array('as' => 'adminstats', 'uses' => 'Admin_HomeController@stats'));
    Route::any('/Bef-Seksyon/{dept}/{cit}/{sec}', array('as' => 'adminanimalscitysection', 'uses' => 'Admin_AnimalsController@section'));
    Route::any('/Ajan-Seksyon/{dept}/{cit}/{sec}', array('as' => 'adminagentscitysection', 'uses' => 'Admin_AgentsController@section'));
    Route::any('/Elve-Seksyon/{dept}/{cit}/{sec}', array('as' => 'admineleveurscitysection', 'uses' => 'Admin_EleveursController@section'));
    Route::any('/Abataj-Seksyon/{dept}/{cit}/{sec}', array('as' => 'adminabattoirscitysection', 'uses' => 'Admin_AbattoirsController@section'));
    Route::any('/Abataj-Vil/{id}', array('as' => 'adminabattoircity', 'uses' => 'Admin_AbattoirsController@city'));
    Route::any('/Idantifikasyon-Dat/', array('as' => 'adminstatinfo', 'uses' => 'Admin_HomeController@statinfo'));
    Route::any('/Abataj-Depatman/', array('as' => 'adminstatabattoir', 'uses' => 'Admin_HomeController@statabattoir'));
    Route::any('/Abataj-Komin/', array('as' => 'adminstatabattoir2', 'uses' => 'Admin_HomeController@statabattoir2'));
    Route::any('/Log/', array('as' => 'adminsystemlogs', 'uses' => 'Admin_HomeController@systemlogs'));
});


// Webuser
Route::any('/', array('as' => '/', 'uses' => 'HomeController@index'));
Route::any('/Login', array('as' => 'login', 'uses' => 'UsersController@index'));
Route::any('/Logout', array('as' => 'logout', 'before' => 'auth', 'uses' => 'UsersController@logout'));
Route::any('/Register', array('as' => 'register', 'uses' => 'UsersController@create'));
Route::any('/Konfimasyon/{id}', array('as' => 'confirmation', 'uses' => 'UsersController@confirmation'));
Route::any('/Dashboard', array('as' => 'dashboard', 'before' => 'auth', 'uses' => 'UsersController@dashboard'));
Route::any('/Edit-User', array('as' => 'edituser', 'before' => 'auth', 'uses' => 'UsersController@edit'));
Route::any('/Bliye-Modpas', array('as' => 'forgotpassword', 'uses' => 'UsersController@forgotpassword'));
Route::any('/Ajan-Yo/{id?}/{city?}', array('as' => 'agents', 'before' => 'auth', 'uses' => 'UAgentsController@index'));
Route::any('/Add-Ajan', array('as' => 'createagent', 'before' => 'auth', 'uses' => 'UAgentsController@create'));
Route::any('/Edit-Ajan/{id}', array('as' => 'editagent', 'before' => 'auth', 'uses' => 'UAgentsController@edit'));
Route::any('/Ajan-Dept', array('as' => 'agentdepartment', 'before' => 'auth', 'uses' => 'AgentsController@department'));
Route::any('/Bef-Yo/{id?}/{city?}', array('as' => 'animals', 'before' => 'auth', 'uses' => 'AnimalsController@index'));
Route::any('/Add-Bef/{id?}', array('as' => 'createanimal', 'before' => 'auth', 'uses' => 'AnimalsController@create'));
Route::any('/Edit-Bef/{id}', array('as' => 'editanimal', 'before' => 'auth', 'uses' => 'AnimalsController@edit'));
Route::any('/Elve-Yo/{id?}/{city?}', array('as' => 'eleveurs', 'before' => 'auth', 'uses' => 'EleveursController@index'));
Route::any('/Add-Elve', array('as' => 'createeleveur', 'before' => 'auth', 'uses' => 'EleveursController@create'));
Route::any('/Edit-Elve/{id}', array('as' => 'editeleveur', 'before' => 'auth', 'uses' => 'EleveursController@edit'));
Route::any('/Add-Remak/', array('as' => 'createnotification', 'before' => 'auth', 'uses' =>
    'NotificationsController@create'));
Route::any('/Remak/{id?}', array('as' => 'remarke', 'before' => 'auth', 'uses' => 'AnimalsController@remarke'));
Route::any('/Depatman/{id}', array('as' => 'department', 'uses' => 'HomeController@department'));
Route::any('/Abatwa-Yo/{id?}/{city?}', array('as' => 'abbatages', 'before' => 'auth', 'uses' => 'AbattoirsController@index'));
Route::any('/Abatwa/{id}', array('as' => 'abattoir', 'before' => 'auth', 'uses' => 'AbattoirsController@edit'));
Route::any('/Add-Abatwa', array('as' => 'usercreateabattoir', 'before' => 'auth', 'uses' => 'AbattoirsController@create'));
Route::any('/validatetag/', array('as' => 'validatetag', 'before' => 'auth', 'uses' => 'AnimalsController@validatetag'));  //ajax
Route::any('/Komin-Bef/{id}', array('as' => 'animalscity', 'uses' => 'AnimalsController@city'));
Route::any('/Komin-Ajan/{id}', array('as' => 'agentscity', 'uses' => 'UAgentsController@city'));
Route::any('/Komin-Elve/{id}', array('as' => 'eleveurscity', 'uses' => 'EleveursController@city'));
Route::any('/Labatwa-Vil/{id}', array('as' => 'abattoircity', 'uses' => 'AbattoirsController@city'));
Route::any('/Bef-Seksyon/{dept}/{cit}/{sec}', array('as' => 'animalscitysection', 'uses' => 'AnimalsController@section'));
Route::any('/Ajan-Seksyon/{dept}/{cit}/{sec}', array('as' => 'agentscitysection', 'uses' => 'UAgentsController@section'));
Route::any('/Elve-Seksyon/{dept}/{cit}/{sec}', array('as' => 'eleveurscitysection', 'uses' => 'EleveursController@section'));
Route::any('/Labatwa-Seksyon/{dept}/{cit}/{sec}', array('as' => 'abattoirscitysection', 'uses' => 'AbattoirsController@section'));
Route::any('/city/{dept}/{city}', array('as' => 'city', 'uses' => 'HomeController@city'));


//Route::any('/abbatages/{?}', array('as' => 'abbatages-s', 'before' => 'auth', 'uses' => 'AbattoirsController@getSelect'));

App::missing(function($exception)
{
    return Redirect::to(URL::route('/'));
    //      return View::make('404');
});
