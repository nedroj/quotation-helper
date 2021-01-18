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

    Route::get('issuelists/{issuelist}/push', 'IssuelistController@getPush')->name('issuelists.push');
    Route::post('issuelists/{issuelist}/push', 'IssuelistController@postPush')->name('issuelists.post-push');

    Route::resource('issuelists', 'IssuelistController');
    Route::resource('issuelists.issues', 'IssuelistIssuesController')->except(['index', 'show']);
    Route::resource('issuelists.emails', 'IssuelistEmailsController')->except(['index', 'show']);

    Route::get('push', 'PushController@get')->name('push.get');
    Route::post('push', 'PushController@post')->name('push.post');
    Route::post('push-get-issuestable', 'PushController@getIssueTable')->name('push.get-issuestable');
    Route::post('push-get-issueliststable', 'PushController@getIssuelistsTable')->name('push.get-issueliststable');

    Route::namespace('Postmark')->prefix('email')->group(function () {
        Route::get('bounces', 'EmailController@index')->name('email.bounces');
        Route::get('bounces/message/{bounce}', 'EmailController@message')->name('email.bounces.message');

        Route::get('servers', 'EmailController@serverlist')->name('email.servers');
        Route::post('servers/{servertoken}/{serverid}/webhook/add', 'EmailController@addWebhook')->name('email.servers.webhook.add');
        Route::post('servers/{servertoken}/webhook/delete/{webhookid}', 'EmailController@deleteWebhook')->name('email.servers.webhook.delete');
    });

    Route::resource('projects', 'ProjectController');

    Route::resource('quotations', 'QuotationController');

    Route::resource('project/quotations', 'ProjectQuotationController',[
        'as' => 'projects'
    ]);

    Route::get('quotations/{quotations}/pdf')->name('quotations.pdf')->uses('QuotationController@pdf');

});
