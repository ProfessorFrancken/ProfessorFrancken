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

    // Proof of concept login & logout, currently not using a spcific user
    // so that we can show this potential functionality at the ALV
    Route::get('/login', function() {
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

    Route::get('/admin', function () {
        return redirect('/admin/overview');
    });

    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', function () {
            return redirect('/admin/overview');
        });

        Route::get('overview', 'DashboardController@overview');
        Route::get('analytics', 'DashboardController@analytics');
        Route::get('export', 'DashboardController@export');

        Route::resource('committee', 'CommitteeController', ['except' => ['edit']]);

        Route::resource('post', 'PostController');

        Route::resource('activity', 'Admin\ActivityController');

        //todo: dit moet nog beter
        Route::post('committee/search-member', 'CommitteeController@searchMember');
        Route::post('committee/{committeeId}/member/{memberId}', 'CommitteeController@addMember');
        Route::delete('committee/{committeeId}/member/{memberId}', 'CommitteeController@removeMember');

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
