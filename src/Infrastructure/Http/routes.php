<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'api', 'middleware' => 'api'], function () {
    Route::get('pluijmpje', function() {

        $pluijmpje = Storage::disk('local')->get('pluijmpje.json');

        $pushups = json_decode($pluijmpje)->pushups;

        return [
            'pushups' => $pushups
        ];
    });

    Route::post('pluijmpje', function(Request $request) {
        $clicks = $request->get('clicks') ?? 1;

        $pluijmpje = Storage::disk('local')->get('pluijmpje.json');

        $pushups = json_decode($pluijmpje)->pushups;
        $pushups += min($clicks, 10);

        Storage::disk('local')->put('pluijmpje.json', json_encode([
            'pushups' => $pushups
        ]));

        return [
            'pushups' => $pushups
        ];
    });
});

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'MainContentController@index');

    Route::resource('study/books', 'BookController');
    Route::put('study/books/{bookId}/buy', 'BookController@buy');

    Route::get('/register', 'RegistrationController@request');
    Route::post('/register', 'RegistrationController@submitRequest');

    Route::get('/association/news', 'NewsController@index');
    Route::get('/association/news/archive', 'NewsController@archive');
    Route::get('/association/news/{item}', 'NewsController@show');

    Route::get('/association/committees', 'CommitteesController@index');
    Route::get('/association/committees/{committee}', 'CommitteesController@show');

    Route::get('/study/research-groups', 'ResearchGroupsController@index');
    Route::get('/study/research-groups/{group}', 'ResearchGroupsController@show');

    Route::get('/career/job-openings', 'CareerController@jobs')->name('job-openings');
    Route::get('/career/companies', 'CompaniesController@index');
    Route::get('/career/companies/{company}', 'CompaniesController@show');
	
    Route::get('/admin', function () {
        return redirect('/admin/overview');
    });

    Route::get('/admin/overview', 'DashboardController@overview');
    Route::get('/admin/analytics', 'DashboardController@analytics');
    Route::get('/admin/export', 'DashboardController@export');

    // Proof of concept login & logout, currently not using a spcific user
    // so that we can show this potential functionality at the ALV
    Route::post('/login', function() {
        Auth::loginUsingId(1);

        return redirect('/');
    });
    Route::get('/logout', function() {
        try {
            Auth::logOut();
        } finally {
            return redirect('/');
        }
    });

    Route::group(['prefix' => 'admin'], function () {


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
