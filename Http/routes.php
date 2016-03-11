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

    Route::get('/admin', function() {
        return redirect('/admin/overview');
    });

    Route::get('/admin/overview', 'DashboardController@overview');
    Route::get('/admin/analytics', 'DashboardController@analytics');
    Route::get('/admin/export', 'DashboardController@export');

    Route::group(['prefix' => 'admin'], function()
    {
        Route::resource('committee', 'CommitteeController', ['except' => [
            'create', 'edit'
        ]]);

        Route::post('committee/search-member', 'CommitteeController@searchMember');

        Route::post('committee/{committeeId}/member/{memberId}', 'CommitteeController@addMember');
        Route::delete('committee/{committeeId}/member/{memberId}', 'CommitteeController@removeMember');

    });


    Route::get('/admin/member', 'MemberController@index');
    Route::post('/admin/member/add-member', 'MemberController@addMember');
});