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

//Backend
Route::get('/',array('uses' => 'AdminController@login'));
Route::get('register',array('uses' => 'AdminController@register'));
Route::post('/register',array('uses' => 'AdminController@checkregister'));
Route::post('/check',array('uses' => 'AdminController@checklogin'));

Route::group(array('before'=>'auth'),function()
{
	Route::get('logout', array('uses' => 'AdminController@logout'));
	Route::get('{section}', array('uses' => 'AdminController@listing'));
	Route::any('{section}/add', array('uses' => 'AdminController@add'));
	Route::any('{section}/view/{id}', array('uses' => 'AdminController@view'));
	Route::any('{section}/delete/{id}', array('uses' => 'AdminController@delete'));
	Route::any('{section}/edit/{id}', array('uses' => 'AdminController@edit'));
});

//App
Route::group(array('prefix' => 'api/v1'), function()
{
	Route::post('login', array('uses' => 'UserController@login'));
	Route::post('forgotpw', array('uses' => 'UserController@forgotpw'));
	Route::post('signup', array('uses' => 'UserController@signup'));
	Route::get('viewprofile/{id}', array('uses' => 'UserController@viewprofile'));
	Route::post('editprofile/{id}', array('uses' => 'UserController@editprofile'));
	Route::post('addcontact/{id}', array('uses' => 'UserController@addcontact'));
	Route::get('viewallcontacts/{id}', array('uses' => 'UserController@viewallcontacts'));
	Route::post('editcontact/{id}', array('uses' => 'UserController@editcontact'));
	Route::post('delcontact/{id}', array('uses' => 'UserController@delcontact'));
	Route::get('viewalltips', array('uses' => 'UserController@viewalltips'));
	Route::get('viewtip/{id}', array('uses' => 'UserController@viewtip'));
	Route::post('addwitness/{id}', array('uses' => 'UserController@addwitness'));
	Route::post('addreminder/{id}', array('uses' => 'UserController@addreminder'));
	Route::post('editreminder/{id}', array('uses' => 'UserController@editreminder'));
	Route::post('delreminder/{id}', array('uses' => 'UserController@delreminder'));
	Route::get('viewallreminder/{id}', array('uses' => 'UserController@viewallreminder'));
	Route::get('viewallreports', array('uses' => 'UserController@viewallreports'));
});
