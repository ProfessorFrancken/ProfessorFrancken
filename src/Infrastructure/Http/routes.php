<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'MainContentController@index');
    Route::get('/news', 'MainContentController@news');
    Route::get('/study', 'MainContentController@study');
    Route::get('/career', 'MainContentController@career');
    Route::get('/association', 'MainContentController@association');
	
	

    Route::get('/register', 'RegistrationController@request');
    Route::post('/register', 'RegistrationController@submitRequest');

    Route::get('/admin', function () {
        return redirect('/admin/overview');
    });

    Route::get('/admin/overview', 'DashboardController@overview');
    Route::get('/admin/analytics', 'DashboardController@analytics');
    Route::get('/admin/export', 'DashboardController@export');

    Route::group(['prefix' => 'admin'], function () {
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
