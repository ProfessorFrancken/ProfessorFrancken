<?php

use Illuminate\Http\Request;

Route::get('/wordpress', function() {
    return redirect('/');
});

Route::get('/wordpress/{wp}', function ($wp) {
    return redirect('http://old.professorfrancken.nl/wordpress/' . $wp);
})->where('wp', '.*');

Route::get('/scriptcie/{url}', function ($url) {
    return redirect('http://old.professorfrancken.nl/scriptcie/' . $url);
})->where('url', '.*');

Route::post('jassen', 'JasController@store');

Route::group(['middleware' => ['web', 'bindings']], function () {

    Route::get('/', 'MainContentController@index');

    Route::get('/register', 'RegistrationController@request');
    Route::post('/register', 'RegistrationController@submitRequest');
    Route::get('/register/success', 'RegistrationController@success');

    Route::get('/login', 'SessionController@getLogin');
    Route::post('/login', 'SessionController@login');
    Route::get('/logout', 'SessionController@logout');

    Route::group(['prefix' => 'study'], function() {
        Route::get('books', 'BookController@index');
        Route::get('books/{book}', 'BookController@show');
        Route::put('books/{bookId}/buy', 'BookController@buy')->middleware('auth');

        Route::get('research-groups', 'ResearchGroupsController@index');
        Route::get('research-groups/{group}', 'ResearchGroupsController@show');
    });

    Route::group(['prefix' => 'association'], function() {

        Route::get('news', 'NewsController@index');
        Route::get('news/archive', 'NewsController@archive');
        Route::get('news/{item}', 'NewsController@show');

        Route::get('committees', 'CommitteesController@index');
        Route::get('committees/{committee}', 'CommitteesController@show');
    });

    Route::group(['prefix' => 'career'], function() {
        Route::get('', 'CareerController@index');
        Route::get('job-openings', 'CareerController@jobs')->name('job-openings');
        Route::get('companies', 'CompaniesController@index');
        Route::get('companies/{company}', 'CompaniesController@show');
        Route::get('events', 'CareerController@redirectEvents');
        Route::get('events/{year}', 'CareerController@events');
    });

    Route::group(['prefix' => 'my-francken', 'middleware' => ['auth']], function() {
        Route::get('', 'MyFranckenController@index');
        Route::get('profile', 'MyFranckenController@profile');
        Route::get('settings', 'MyFranckenController@settings');
        Route::get('members', 'MyFranckenController@members');
        Route::get('committees', 'MyFranckenController@committees');
        Route::get('activities', 'MyFranckenController@activities');
        Route::get('canteen', 'MyFranckenController@canteen');
        Route::get('adtcievements', 'MyFranckenController@adtcievements');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

        Route::get('/', 'DashboardController@redirectToDashboard');
        Route::get('overview', 'DashboardController@overview');
        Route::get('analytics', 'DashboardController@analytics');
        Route::get('export', 'DashboardController@export');

        Route::group(['prefix' => 'study'], function() {
            Route::get('research-groups', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('books', 'Admin\AdminController@showPageIsUnavailable');
        });

        Route::group(['prefix' => 'career'], function() {
            Route::get('companies', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('events', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('job-openings', 'Admin\AdminController@showPageIsUnavailable');

        });

        Route::group(['prefix' => 'association'], function() {
            //posts: NEWS / BLOG
            Route::resource('post', 'PostController');

            Route::resource('activity', 'ActivityController');


            //committees
            Route::resource('committee', 'Admin\CommitteeController', ['except' => ['edit']]);
            Route::post('committee/search-member', 'Admin\CommitteeController@searchMember');
            Route::post('committee/{committeeId}/member/{memberId}', 'Admin\CommitteeController@addMember');
            Route::delete('committee/{committeeId}/member/{memberId}', 'Admin\CommitteeController@removeMember');

            Route::get('member', 'MemberController@index');
            Route::post('member/add-member', 'MemberController@addMember');

            Route::get('registration-requests', 'Admin\RegistrationRequestsController@index');
            Route::get('registration-requests/{requestId}', 'Admin\RegistrationRequestsController@show');
            Route::delete('registration-requests/{requestId}', 'Admin\RegistrationRequestsController@remove');

            // Francken Vrij
            Route::get('francken-vrij', 'Admin\FranckenVrijController@index');
            Route::get('francken-vrij/{edition}', 'Admin\FranckenVrijController@edit');
            Route::put('francken-vrij/{edition}', 'Admin\FranckenVrijController@update');
            Route::delete('francken-vrij/{edition}', 'Admin\FranckenVrijController@destroy');
            Route::post('francken-vrij', 'Admin\FranckenVrijController@store');


            Route::get('blogs', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('activities', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('members', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('committees', 'Admin\AdminController@showPageIsUnavailable');
        });


    });

    Route::get('{page}', 'MainContentController@page')->where('page', '.+');
});
