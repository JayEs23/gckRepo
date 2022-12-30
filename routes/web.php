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
	Route::get('/users/{id}/delete', 'App\Http\Controllers\UserController@destroy')->name('users.destroy');
	Route::get('/users/{id}/makeAdmin', 'App\Http\Controllers\UserController@makeAdmin')->name('users.makeAdmin');
	Route::get('/users/{id}/makeAccount', 'App\Http\Controllers\UserController@makeAccount')->name('users.makeAccount');
	Route::get('/users/{id}/makeUser', 'App\Http\Controllers\UserController@makeUser')->name('users.makeUser');
	Route::get('zone/create', 'ZoneController@create');
	Route::post('zone/store', 'ZoneController@store');
	Route::get('zone/{id}/edit', 'ZoneController@edit');
	Route::patch('zone/{id}', 'ZoneController@update');
	Route::delete('zone/{id}', 'ZoneController@destroy');

	Route::get('department/create', 'DepartmentController@create');
	Route::post('department/store', 'DepartmentController@store');
	Route::get('department/{id}/edit', 'DepartmentController@edit');
	Route::patch('department/{id}', 'DepartmentController@update');
	Route::delete('department/{id}', 'DepartmentController@destroy');

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
	Route::post('/requests/{id}/edit', 'App\Http\Controllers\RequestController@update')->name('requests.update');

	//Fetch Request details
	Route::get('/requests/{id}', 'App\Http\Controllers\RequestController@show')->name('requests.show');

	//Delete Request
	Route::delete('/requests/{id}', 'App\Http\Controllers\RequestController@destroy')->name('requests.destroy');
	Route::get('/requests/{id}/approve', 'App\Http\Controllers\RequestController@approve')->name('requests.approve');
	Route::post('/requests/deny', 'App\Http\Controllers\RequestController@deny')->name('requests.deny');
	Route::post('/requests/decline', 'App\Http\Controllers\RequestController@decline')->name('requests.decline');
	Route::get('/requests/{id}/resolve', 'App\Http\Controllers\RequestController@resolve')->name('requests.resolve');
	
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

