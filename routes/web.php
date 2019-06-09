<?php

declare(strict_types=1);

use Francken\Auth\Http\Controllers\Admin;
Route::redirect('/blog', '/association/news');
Route::permanentRedirect('/wordpress', '/');
Route::redirect('/books', '/study/books');
Route::redirect('/boeken', '/study/books');
Route::redirect('/photos', '/association/photos');

Route::get('/wordpress/{wp}', function ($wp) {
    return redirect('http://old.professorfrancken.nl/wordpress/' . $wp);
})->where('wp', '.*');

Route::get('/scriptcie/{url}', function ($url) {
    return redirect('http://old.professorfrancken.nl/scriptcie/' . $url);
})->where('url', '.*');

Route::group(['middleware' => ['web', 'bindings']], function () : void {
    Route::get('/symposia/{symposium}/participants/{participant}', [
        \Francken\Association\Symposium\Http\ParticipantRegistrationController::class,
        'verify'
    ])->name('symposium.participant.verify')->middleware(['signed', 'throttle:6,1']);

    Route::post('/symposia/{symposium}/participants', [
        \Francken\Association\Symposium\Http\ParticipantRegistrationController::class,
        'store'
    ])->middleware(['throttle:6,1', 'symposium-cors']);

    Route::get('/', 'MainContentController@index')->name('home');

    Route::get('/register', 'RegistrationController@request');
    Route::post('/register', 'RegistrationController@submitRequest');
    Route::get('/register/success', 'RegistrationController@success');

    Route::group(['namespace' => '\Francken\Auth\Http\Controllers'], function () : void {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::post('logout', 'LoginController@logout')->name('logout');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    });

    Route::group(['prefix' => 'study'], function () : void {
        Route::get('books', 'BookController@index');
        Route::get('books/{book}', 'BookController@show');
        Route::put('books/{bookId}/buy', 'BookController@buy')->middleware('auth');

        Route::get('research-groups', 'ResearchGroupsController@index');
        Route::get('research-groups/{group}', 'ResearchGroupsController@show');
    });

    Route::group(['prefix' => 'association'], function () : void {
        Route::get('activities', '\Francken\Association\Activities\Http\ActivitiesController@index');
        Route::get('activities/ical', '\Francken\Association\Activities\Http\IcalController@index');
        Route::get('activities/ical/all', '\Francken\Association\Activities\Http\IcalController@show');
        Route::get('activities/{year}/{month}', '\Francken\Association\Activities\Http\ActivitiesPerMonthController@index');

        Route::get('committees', 'CommitteesController@index');
        Route::get('committees/{committee}', 'CommitteesController@show');

        Route::get('boards/birthdays', '\Francken\Association\Boards\Http\Controllers\BirthdaysController@index')
            ->middleware(['role:Board|Old Board']);

        Route::get('photos', '\Francken\Association\Photos\PhotosController@index');
        Route::post('photos', '\Francken\Association\Photos\PhotosController@post');
        Route::get('photos/{album}', '\Francken\Association\Photos\PhotosController@show');
    });

    Route::group(['prefix' => 'career'], function () : void {
        Route::get('', 'CareerController@index');
        Route::get('job-openings', 'CareerController@jobs')->name('job-openings');
        Route::get('companies', 'CompaniesController@index');
        Route::get('companies/{company}', 'CompaniesController@show');
        Route::get('events', 'CareerController@redirectEvents');
        Route::get('events/{academic_year}', 'CareerController@events');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'can:can-access-dashboard']], function () : void {
        Route::get('/', 'DashboardController@redirectToDashboard');
        Route::get('overview', 'DashboardController@overview');
        Route::get('analytics', 'DashboardController@analytics');
        Route::get('export', 'DashboardController@export');

        Route::group(['prefix' => 'study'], function () : void {
            Route::get('research-groups', 'Admin\AdminController@showPageIsUnavailable');

            Route::group(['middleware' => 'can:dashboard:books-write'], function () : void {
                Route::get('books/create', '\Francken\Study\BooksSale\Http\AdminBooksController@create');
                Route::post('books', '\Francken\Study\BooksSale\Http\AdminBooksController@store');
                Route::put('books/{book}', '\Francken\Study\BooksSale\Http\AdminBooksController@update');
                Route::delete('books/{book}', '\Francken\Study\BooksSale\Http\AdminBooksController@remove');
            });

            Route::group(['middleware' => 'can:dashboard:books-read'], function () : void {
                Route::get('books', '\Francken\Study\BooksSale\Http\AdminBooksController@index');
                Route::get('books/{book}', '\Francken\Study\BooksSale\Http\AdminBooksController@show');
            });
        });

        Route::group(['prefix' => 'extern'], function () : void {
            Route::get('companies', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('events', 'Admin\AdminController@showPageIsUnavailable');
            Route::get('job-openings', 'Admin\AdminController@showPageIsUnavailable');
        });

        Route::group(['prefix' => 'association'], function () : void {
            //committees
            Route::resource('committees', 'Admin\CommitteeController');
            Route::post('committees/search-member', 'Admin\CommitteeController@searchMember');
            Route::post('committees/{committeeId}/member/{memberId}', 'Admin\CommitteeController@addMember');
            Route::delete('committees/{committeeId}/member/{memberId}', 'Admin\CommitteeController@removeMember');

            Route::get('member', 'MemberController@index');
            Route::post('member/add-member', 'MemberController@addMember');

            Route::get('boards/export', '\Francken\Association\Boards\Http\Controllers\AdminExportsController@index');
            Route::post('boards/import', '\Francken\Association\Boards\Http\Controllers\AdminImportsController@store');
            Route::resource('boards', '\Francken\Association\Boards\Http\Controllers\AdminBoardsController');
            Route::resource('boards/{board}/members', '\Francken\Association\Boards\Http\Controllers\AdminBoardMembersController');

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

            Route::group([
                'namespace' => '\Francken\Association\Symposium\Http',
                'prefix' => 'symposia'
            ], function () : void {
                Route::group(['middleware' => 'can:dashboard:symposia-write'], function () : void {
                    Route::get('/create', 'AdminSymposiaController@create');
                    Route::post('/', 'AdminSymposiaController@store');
                    Route::get('/{symposium}/edit', 'AdminSymposiaController@edit');
                    Route::put('/{symposium}', 'AdminSymposiaController@update');

                    Route::get('/{symposium}/participants/create', 'AdminSymposiumParticipantsController@create');
                    Route::post('/{symposium}/participants', 'AdminSymposiumParticipantsController@store');
                    Route::get('/{symposium}/participants/{participant}/edit', 'AdminSymposiumParticipantsController@edit');
                    Route::put('/{symposium}/participants/{participant}', 'AdminSymposiumParticipantsController@update');
                    Route::put('/{symposium}/participants/{participant}/toggle-spam', 'AdminSymposiumParticipantsController@toggleSpam');
                    Route::delete('/{symposium}/participants/{participant}', 'AdminSymposiumParticipantsController@remove');
                });

                Route::group(['middleware' => 'can:dashboard:symposia-read'], function () : void {
                    Route::get('/', 'AdminSymposiaController@index');
                    Route::get('/{symposium}', 'AdminSymposiaController@show');

                    Route::get('/{symposium}/attendance', 'AttendanceController@index');
                    Route::get('/{symposium}/name-tags', 'NameTagsController@index');
                    Route::get('/{symposium}/export', 'ExportController@index');
                });
            });
        });

        Route::group(['prefix' => 'compucie'], function () : void {
            Route::group(['middleware' => 'can:dashboard:accounts-write'], function () : void {
                Route::get('accounts', [Admin\AccountsController::class, 'index']);
                Route::get('accounts/create', [Admin\AccountsController::class, 'create']);
                Route::post('accounts', [Admin\AccountsController::class, 'store']);
                Route::get('accounts/{account}', [Admin\AccountsController::class, 'show']);
            });

            Route::group(['middleware' => 'can:dashboard:accounts-write'], function () : void {
                Route::post('accounts', [Admin\AccountsController::class, 'store']);
                Route::post('accounts/{account}/permissions/', [Admin\AccountPermissionsController::class, 'store']);
                Route::delete('accounts/{account}/permissions/{permission}', [Admin\AccountPermissionsController::class, 'remove']);
                Route::post('accounts/{account}/roles/{role}', [Admin\AccountRolesController::class, 'store']);
                Route::delete('accounts/{account}/roles/{role}', [Admin\AccountRolesController::class, 'remove']);
            });

            Route::get('settings', [\Francken\Shared\Settings\Http\Controllers\SettingsController::class, 'index']);
            Route::put('settings', [\Francken\Shared\Settings\Http\Controllers\SettingsController::class, 'update']);

            Route::group(['middleware' => 'can:dashboard:permissions-write'], function () : void {
                Route::get('roles', [Admin\RolesController::class, 'index']);
                Route::get('roles/{role}', [Admin\RolesController::class, 'show']);
            });

            Route::group(['middleware' => 'can:dashboard:permissions-write'], function () : void {
                Route::post('roles/{role}/permissions', [Admin\RolePermissionsController::class, 'store']);
                Route::delete('roles/{role}/permissions/{permission}', [Admin\RolePermissionsController::class, 'remove']);
            });
        });
    });

    Route::get('{page}', 'MainContentController@page')->where('page', '.+');
});
