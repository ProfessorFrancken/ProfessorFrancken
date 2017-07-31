<?php

use Illuminate\Http\Request;

Route::get('/wordpress', function() {
    return redirect('/');
});

Route::get('/wordpress/{wp}', function ($wp) {
    return redirect('http://old.professorfrancken.nl/wordpress/' . $wp);
})->where('wp', '.*');

Route::group(['middleware' => ['web', 'bindings']], function () {

    Route::get('/', 'MainContentController@index');

    Route::get('/register', 'RegistrationController@request');
    Route::post('/register', 'RegistrationController@submitRequest');

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

    Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

        Route::get('/', 'DashboardController@redirectToDashboard');
        Route::get('overview', 'DashboardController@overview');
        Route::get('analytics', 'DashboardController@analytics');
        Route::get('export', 'DashboardController@export');


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

        // Francken Vrij
        Route::get('francken-vrij', 'Admin\FranckenVrijController@index');
        Route::get('francken-vrij/{edition}', 'Admin\FranckenVrijController@edit');
        Route::put('francken-vrij/{edition}', 'Admin\FranckenVrijController@update');
        Route::delete('francken-vrij/{edition}', 'Admin\FranckenVrijController@destroy');
        Route::post('francken-vrij', 'Admin\FranckenVrijController@store');
    });

    Route::get('{page}', 'MainContentController@page')->where('page', '.+');
});
