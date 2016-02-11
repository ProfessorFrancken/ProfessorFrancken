<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'MainContentController@index');
    Route::get('/news', 'MainContentController@news');
    Route::get('/study', 'MainContentController@study');
    Route::get('/career', 'MainContentController@career');

    Route::get('/admin', function(){
    	return redirect('/admin/overview');
    });

    Route::get('/admin/committee', 'CommitteeController@index');
    Route::get('/admin/committee/create-committee', 'CommitteeController@create_committee');
    Route::post('/admin/committee/create-committee', 'CommitteeController@post_create_committee');

    // Route::get('admin/{id}', function ($id) {
    //     return "<h1>".$id."</h1>";
    // });
});