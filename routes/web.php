<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

// SuperAdmin Middleware

Route::group(['middleware' => ['superadmin']], function () {

    /* Role Groups */
    Route::get('/admin/groups', 'RolesController@groups');
    Route::get('/admin/groups/create', 'RolesController@createGroup');
    Route::post('/admin/groups/create', 'RolesController@createGroup');
    Route::get('/admin/groups/edit/{id}', 'RolesController@editGroup');
    Route::post('/admin/groups/edit/{id}', 'RolesController@editGroup');
    Route::get('/admin/groups/delete/{id}', 'RolesController@deleteGroup');
    Route::post('/admin/groups/delete/{id}', 'RolesController@deleteGroup');Route::get('/admin', 'AdminController@index');

    /* Account */
    Route::get('/admin/editAccount', 'AdminController@editAccount');
    Route::post('/admin/editAccount', 'AdminController@editAccount');

    /* User */
    Route::get('/admin/editUser/{id}', 'AdminController@editUser');
    Route::post('/admin/editUser/{id}', 'AdminController@editUser');
    Route::get('/admin/deleteUser/{id}', 'AdminController@deleteUser');
});

// Users Middleware
Route::group(['middleware' => ['users']], function () {
    // All users that have at least one checked permission for Users
});

/* Home Controller */
Route::get('/home', 'HomeController@index');
Route::get('/tickets', 'HomeController@tickets');
Route::get('/departments', 'HomeController@departments');
Route::post('sendmessage', 'HomeController@sendMessage');

