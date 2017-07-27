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

    Route::get('study/books', 'BookController@index');
    Route::get('study/books/{book}', 'BookController@show');
    Route::put('study/books/{bookId}/buy', 'BookController@buy')->middleware('auth');

    Route::get('/register', 'RegistrationController@request');
    Route::post('/register', 'RegistrationController@submitRequest');

    Route::get('/association/news', 'NewsController@index');
    Route::get('/association/news/archive', 'NewsController@archive');
    Route::get('/association/news/{item}', 'NewsController@show');

    Route::get('/association/committees', 'CommitteesController@index');
    Route::get('/association/committees/{committee}', 'CommitteesController@show');

    Route::get('/study/research-groups', 'ResearchGroupsController@index');
    Route::get('/study/research-groups/{group}', 'ResearchGroupsController@show');

    Route::get('/career', 'CareerController@index');
    Route::get('/career/job-openings', 'CareerController@jobs')->name('job-openings');
    Route::get('/career/companies', 'CompaniesController@index');
    Route::get('/career/companies/{company}', 'CompaniesController@show');
    Route::get('/career/events', 'CareerController@redirectEvents');
    Route::get('/career/events/{year}', 'CareerController@events');

    Route::get('/login', 'SessionController@getLogin');
    Route::post('/login', 'SessionController@login');
    Route::get('/logout', 'SessionController@logout');

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
