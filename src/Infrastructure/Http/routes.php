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

Route::get('/database/streep/afbeeldingen/{url}', function ($url) {
    return redirect('http://old.professorfrancken.nl/database/streep/afbeeldingen/' . $url);
})->where('url', '.*');

Route::post('store-jas-events', 'JasController@store');
Route::get('jas-events', function () {
    return DB::table('jas_events')->get();
});

Route::get('/books', function () {
    return redirect('/study/books');
});

Route::get('/boeken', function () {
    return redirect('/study/books');
});

Route::group(['middleware' => ['api'], 'prefix' => 'api'], function () {
    Route::get('activities', '\Francken\Api\Http\ActivitiesController@index');
    Route::get('books', '\Francken\Api\Http\BooksController@index');
    Route::get('job-openings', '\Francken\Api\Http\JobOpeningsController@index');
});

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
        Route::get('activities', '\Francken\Association\Activities\Http\ActivitiesController@index');
        Route::get('activities/{year}/{month}', '\Francken\Association\Activities\Http\ActivitiesPerMonthController@index');
        Route::get('activities/{year}/{month}/{activity}', '\Francken\Association\Activities\Http\ActivitiesController@show');


        Route::get('committees', 'CommitteesController@index');
        Route::get('committees/{committee}', 'CommitteesController@show');

        Route::get('boards/birthdays', '\Francken\Association\Boards\BirthdaysController@index');
    });

    Route::group(['prefix' => 'career'], function() {
        Route::get('', 'CareerController@index');
        Route::get('job-openings', 'CareerController@jobs')->name('job-openings');
        Route::get('companies', 'CompaniesController@index');
        Route::get('companies/{company}', 'CompaniesController@show');
        Route::get('events', 'CareerController@redirectEvents');
        Route::get('events/{academic_year}', 'CareerController@events');
    });

    Route::group(['prefix' => 'my-francken', 'middleware' => ['auth']], function() {
        Route::get('', 'MyFranckenController@index');
        Route::get('profile', 'MyFranckenController@profile');
        Route::get('settings', 'MyFranckenController@settings');
        Route::get('members', 'MyFranckenController@members');
        Route::get('committees', 'MyFranckenController@committees');
        Route::get('activities', 'MyFranckenController@activities');
        Route::get('finances', 'MyFranckenController@finances');
        Route::get('finances/{year}/{month}', 'MyFranckenController@financesInMonth');
        Route::get('adtcievements', 'MyFranckenController@adtcievements');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

        Route::get('/', 'DashboardController@redirectToDashboard');
        Route::get('overview', 'DashboardController@overview');
        Route::get('analytics', 'DashboardController@analytics');
        Route::get('export', 'DashboardController@export');

        Route::group(['prefix' => 'study'], function() {
            Route::get('research-groups', 'Admin\AdminController@showPageIsUnavailable');

            Route::get('books', '\Francken\Study\BooksSale\Http\AdminBooksController@index');
            Route::post('books', '\Francken\Study\BooksSale\Http\AdminBooksController@store');
        });

        Route::group(['prefix' => 'career'], function() {
            Route::get('companies', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('events', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('job-openings', 'Admin\AdminController@showPageIsUnavailable');

        });

        Route::group(['prefix' => 'association'], function() {
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

            Route::get('activities', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('members', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('committees', 'Admin\AdminController@showPageIsUnavailable');
        });


    });

    Route::get('{page}', 'MainContentController@page')->where('page', '.+');
});
