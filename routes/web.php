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

Auth::routes(['register' => false]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
// Resource is crud
    Route::resource('users', 'UserController')->except(['show']);

    Route::resource('departments', 'DepartmentController')->except(['show']);

    Route::get('departments/showAll', 'DepartmentController@showAll')->name('departments.showAll');

    Route::resource('epics', 'EpicController')->except(['create', 'show', 'edit']);

    //specific actions always call before resource call
    Route::get('tasks/by-epic/{epic}','TaskController@getTasksByEpic')->name('tasks.getTasksByEpic');
    Route::resource('tasks', 'TaskController');

    Route::resource('taskEstimates', 'TaskEstimatesController');

    Route::resource('projects', 'ProjectController');

    Route::resource('quotations', 'QuotationController');

    Route::resource('project/quotations', 'ProjectQuotationController',[
        'as' => 'projects'
    ]);

    Route::get('quotations/{quotations}/pdf')->name('quotations.pdf')->uses('QuotationController@pdf');

});
