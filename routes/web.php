<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('welcome');
});

Route::get('tasks_current', 		'TaskController@index')->name('tasks_current');
Route::get('tasks_published', 		'TaskController@published')->name('tasks_published');
Route::get('tasks_shared', 		    'TaskController@shared')->name('tasks_shared');
Route::post('task_create', 			'TaskController@store')->name('task_create');
Route::post('task_delete/{id}', 	'TaskController@destroy')->name('task_delete');
Route::post('task_publish/{id}', 	'TaskController@publish')->name('task_publish');
Route::get('task_show/{id}', 		'TaskController@show_one')->name('task_show.id');
Route::post('task_edit', 			'TaskController@edit')->name('task_edit');
Route::put('task_update/{id}', 		'TaskController@update')->name('task_update');


Route::get('invite_show/{id}', 		'TaskUserController@index')->name('invite_show.id');
Route::post('invite_create', 		'TaskUserController@inviteCreate')->name('invite_create');
Route::post('invite_delete/{id}', 	'TaskUserController@destroy')->name('invite_delete');

Route::get('users_show', 		    'UserController@index')->name('users_show');


Route::post('taskRowData_Create', 	'TaskrowdataController@store')->name('taskRowData_Create');
Route::get('taskRowData_show/{id}', 	'TaskrowdataController@index')->name('taskRowData_show.id');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
