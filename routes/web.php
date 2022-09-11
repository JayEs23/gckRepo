<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();




Route::group(['middleware' => 'auth'], function () {


	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);

	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

	//users
	Route::get('/users', 'App\Http\Controllers\UserController@index')->name('users');
	Route::get('/users/create', 'App\Http\Controllers\UserController@index')->name('users.create');
	Route::post('/users', 'App\Http\Controllers\UserController@store')->name('users.save');
	Route::put('/users', 'App\Http\Controllers\UserController@update')->name('users.update');
	Route::get('/users/{id}', 'App\Http\Controllers\UserController@show')->name('users.show');
	Route::delete('/users/{id}', 'App\Http\Controllers\UserController@destroy')->name('users.destroy');
	Route::get('/users/{id}/makeAdmin', 'App\Http\Controllers\UserController@makeAdmin')->name('users.makeAdmin');
	Route::get('/users/{id}/makeAccount', 'App\Http\Controllers\UserController@makeAccount')->name('users.makeAccount');
	Route::get('/users/{id}/makeUser', 'App\Http\Controllers\UserController@makeUser')->name('users.makeUser');

	//requests
	Route::get('/requests', 'App\Http\Controllers\RequestController@index')->name('requests');

	//create Request
	Route::get('/requests/create', 'App\Http\Controllers\RequestController@create')->name('requests.create');

	//For Approved Requests
	Route::get('/requests/approved', 'App\Http\Controllers\RequestController@approved')->name('requests.approved');

	//Resolved Requests
	Route::get('/requests/resolved', 'App\Http\Controllers\RequestController@resolved')->name('requests.resolved');

	//Create new Request
	Route::post('/requests', 'App\Http\Controllers\RequestController@store')->name('requests.save');

	//Update Request
	Route::put('/requests/{id}', 'App\Http\Controllers\RequestController@update')->name('requests.update');

	//Fetch Request details
	Route::get('/requests/{id}', 'App\Http\Controllers\RequestController@show')->name('requests.show');

	//Delete Request
	Route::delete('/requests/{id}', 'App\Http\Controllers\RequestController@destroy')->name('requests.destroy');
	Route::get('/requests/{id}/approve', 'App\Http\Controllers\RequestController@approve')->name('requests.approve');
	Route::get('/requests/{id}/deny', 'App\Http\Controllers\RequestController@deny')->name('requests.deny');
	Route::get('/requests/{id}/resolve', 'App\Http\Controllers\RequestController@resolve')->name('requests.resolve');
	Route::get('forms', function () {return view('pages.forms');})->name('forms'); 
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade'); 
	Route::get('map', function () {return view('pages.maps');})->name('map');
	Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

