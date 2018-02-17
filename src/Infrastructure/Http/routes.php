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

Route::get('/books', function () {
    return redirect('/study/books');
});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::get('/members', function() {

        // $db = DB::connection('francken-legacy');
        // $db->table('producten')->join('producten_extras', 'producten.id', 'producten_extras.product_id')->get();

        // file_put_contents(database_path('producten.json'), json_encode($producten));

        $db = DB::connection('francken-legacy');
        $selects = ['id', 'voornaam', 'initialen', 'tussenvoegsel', 'achternaam', 'geboortedatum', 'prominent', 'kleur', 'afbeelding', 'bijnaam', 'button_width', 'button_height'];
        $members = $db->table('leden')->leftJoin('leden_extras', 'leden.id', 'leden_extras.lid_id')->select($selects)->where('is_lid', 1)->where('streeplijst', 'Afschrijven')->where('machtiging', 1)->whereNull('einde_lidmaatschap')->whereNull('deleted_at')->get();

        return collect(['members' => $members]);

        // file_put_contents(database_path(leden.json'), json_encode($leden));
    });

    Route::get('products', function () {
        $db = DB::connection('francken-legacy');
        $products = $db->table('producten')->where('beschikbaar', 1)->leftJoin('producten_extras', 'producten.id', 'producten_extras.product_id')->get();
        return collect(['products' => $products]);
    });

    Route::post('orders', function () {
        $member = request()->get('member');
        $order = request()->get('order');

        return [$member, $order];
    });
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
        Route::get('finances', 'MyFranckenController@finances');
        Route::get('finances/{ayear}/{month}', 'MyFranckenController@financesInMonth');
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
