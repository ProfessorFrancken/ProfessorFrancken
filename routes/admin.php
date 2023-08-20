<?php

declare(strict_types=1);

use Francken\Association\Activities\Http\AdminActivitiesController;
use Francken\Association\Activities\Http\AdminActivitySignUpsExportController;
use Francken\Association\Activities\Http\AdminSignUpsController;
use Francken\Association\Activities\Http\AdminSignUpSettingsController;
use Francken\Association\AlumniActivity\Http\AdminAlumniActivityController;
use Francken\Association\Boards\Http\Controllers\AdminBoardsController;
use Francken\Association\Boards\Http\Controllers\AdminExportsController;
use Francken\Association\Boards\Http\Controllers\AdminImportsController;
use Francken\Association\Committees\Http\AdminActiveMembersExportController;
use Francken\Association\Committees\Http\AdminCommitteeMembersController;
use Francken\Association\Committees\Http\AdminCommitteesController;
use Francken\Association\Committees\Http\AdminContinueCommitteesController;
use Francken\Association\Committees\Http\AdminRedirectCommitteesController;
use Francken\Association\FranckenVrij\Http\AdminFranckenVrijController;
use Francken\Association\FranckenVrij\Http\AdminSubscriptionsController;
use Francken\Association\FranckenVrij\Http\AdminSubscriptionsExportController;
use Francken\Association\Members\Http\Controllers\Admin\ConsumptionCounterSettingsController;
use Francken\Association\Members\Http\Controllers\Admin\MembersController;
use Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController;
use Francken\Association\News\Http\AdminNewsController;
use Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController;
use Francken\Association\Symposium\Http\AdminSymposiaController;
use Francken\Association\Symposium\Http\AdminSymposiaMailPreviewController;
use Francken\Association\Symposium\Http\AdminSymposiumParticipantsController;
use Francken\Association\Symposium\Http\AttendanceController;
use Francken\Association\Symposium\Http\ExportController;
use Francken\Association\Symposium\Http\NameTagsController;
use Francken\Auth\Http\Controllers\Admin\AccountPermissionsController;
use Francken\Auth\Http\Controllers\Admin\AccountRolesController;
use Francken\Auth\Http\Controllers\Admin\AccountsController;
use Francken\Auth\Http\Controllers\Admin\RolePermissionsController;
use Francken\Auth\Http\Controllers\Admin\RolesController;
use Francken\Extern\Http\AdminCompanyProfilesController;
use Francken\Extern\Http\AdminFootersController;
use Francken\Extern\Http\AdminPartnerAlumniController;
use Francken\Extern\Http\AdminPartnerContactsController;
use Francken\Extern\Http\AdminPartnerNotesController;
use Francken\Extern\Http\AdminPartnersController;
use Francken\Extern\Http\AdminVacanciesController;
use Francken\Extern\Http\FactSheetController;
use Francken\Shared\Http\Controllers\Admin\AdminController;
use Francken\Shared\Http\Controllers\Admin\PagesController;
use Francken\Shared\Http\Controllers\BoardDashboardController;
use Francken\Shared\Http\Controllers\BoardNotificationsController;
use Francken\Shared\Http\Controllers\DashboardController;
use Francken\Shared\Http\Controllers\MemberDashboardController;
use Francken\Shared\Media\Http\Controllers\MediaController;
use Francken\Shared\Settings\Http\Controllers\SettingsController;
use Francken\Study\BooksSale\Http\AdminBooksController;
use Francken\Treasurer\Http\Controllers\AdminProductExtrasController;
use Francken\Treasurer\Http\Controllers\AdminProductsController;
use Francken\Treasurer\Http\Controllers\AdminTransactionsController;
use Francken\Treasurer\Http\Controllers\DeductionEmailsController;
use Francken\Treasurer\Http\Controllers\DeductionMembersController;
use Francken\Treasurer\Http\Controllers\DeductionsController;

Route::get('/', [DashboardController::class, 'redirectToDashboard']);
Route::get('overview', [DashboardController::class, 'redirectToDashboard']);
Route::get('dashboard/board', [BoardDashboardController::class, 'index']);
Route::get('dashboard/member', [MemberDashboardController::class, 'index']);
Route::delete('dashboard/board/notifications/{notification}', [BoardNotificationsController::class, 'destroy']);

Route::group(['prefix' => 'study'], function () : void {
    Route::get('research-groups', [AdminController::class, 'showPageIsUnavailable']);

    Route::group(['middleware' => 'can:dashboard:books-write'], function () : void {
        Route::get('books/create', [AdminBooksController::class, 'create']);
        Route::post('books', [AdminBooksController::class, 'store']);
        Route::put('books/{book}', [AdminBooksController::class, 'update']);
        Route::delete('books/{book}', [AdminBooksController::class, 'remove']);

        Route::get('books/{book}/print', [AdminBooksController::class, 'print']);
    });

    Route::group(['middleware' => 'can:dashboard:books-read'], function () : void {
        Route::get('books', [AdminBooksController::class, 'index']);
        Route::get('books/{book}', [AdminBooksController::class, 'show']);
    });
});

Route::group(['prefix' => 'extern', ], function () : void {
    Route::get('/fact-sheet', [FactSheetController::class, 'index']);

    $unavailable = [AdminController::class, 'showPageIsUnavailable'];

    Route::get('companies', $unavailable);
    Route::get('events', $unavailable);
    Route::get('job-openings', $unavailable);

    Route::group(['middleware' => ['can:dashboard:companies-read']], function () : void {
        Route::resource('partners', AdminPartnersController::class);

        Route::get('partners/{partner}/company-profile/create', [AdminCompanyProfilesController::class, 'create']);
        Route::post('partners/{partner}/company-profile', [AdminCompanyProfilesController::class, 'store']);
        Route::get('partners/{partner}/company-profile', [AdminCompanyProfilesController::class, 'edit']);
        Route::put('partners/{partner}/company-profile', [AdminCompanyProfilesController::class, 'update']);
        Route::delete('partners/{partner}/company-profile', [AdminCompanyProfilesController::class, 'destroy']);

        Route::post('partners/{partner}/notes', [AdminPartnerNotesController::class, 'store']);

        Route::get('partners/{partner}/footer/create', [AdminFootersController::class, 'create']);
        Route::post('partners/{partner}/footer', [AdminFootersController::class, 'store']);
        Route::get('partners/{partner}/footer', [AdminFootersController::class, 'edit']);
        Route::put('partners/{partner}/footer', [AdminFootersController::class, 'update']);
        Route::delete('partners/{partner}/footer', [AdminFootersController::class, 'destroy']);

        Route::resource('partners.vacancies', AdminVacanciesController::class);
        Route::resource('partners.contacts', AdminPartnerContactsController::class);
        Route::resource('partners.alumni', AdminPartnerAlumniController::class);
    });
});

Route::group(['prefix' => 'association'], function () : void {
    Route::group(['middleware' => 'can:dashboard:news-read'], function () : void {
        Route::put('/news/publish/{news}', [AdminNewsController::class, 'publish']);
        Route::put('/news/archive/{news}', [AdminNewsController::class, 'archive']);
        Route::get('/news/{news}/preview', [AdminNewsController::class, 'preview']);
        Route::resource('news', '\Francken\Association\News\Http\AdminNewsController');
    });

    Route::group(['middleware' => 'can:dashboard:board-members-read'], function () : void {
        Route::get('boards/export', [AdminExportsController::class, 'index']);
        Route::post('boards/import', [AdminImportsController::class, 'store']);
        Route::resource('boards', AdminBoardsController::class);
    });

    Route::group(['middleware' => 'can:dashboard:registrations-write'], function () : void {
        Route::delete('registration-requests/{registration}', [RegistrationRequestsController::class, 'remove']);
        Route::post('registration-requests/{registration}/approve', [RegistrationRequestsController::class, 'approve']);
        Route::post('registration-requests/{registration}/sign', [RegistrationRequestsController::class, 'sign']);
        Route::get('registration-requests/{registration}/edit', [RegistrationRequestsController::class, 'edit']);
        Route::put('registration-requests/{registration}', [RegistrationRequestsController::class, 'update']);
    });

    Route::group(['middleware' => 'can:dashboard:members-read'], function () : void {
        Route::resource('members', MembersController::class);
        Route::get('members/{member}/consumption-counter-settings', [ConsumptionCounterSettingsController::class, 'edit']);
        Route::put('members/{member}/consumption-counter-settings/', [ConsumptionCounterSettingsController::class, 'update']);
    });

    Route::group(['middleware' => 'can:dashboard:registrations-read'], function () : void {
        Route::get('registration-requests', [RegistrationRequestsController::class, 'index']);
        Route::get('registration-requests/{registration}', [RegistrationRequestsController::class, 'show']);
        Route::get('registration-requests/{registration}/print', [RegistrationRequestsController::class, 'print']);
    });

    Route::group(['middleware' => 'can:dashboard:committees-read'], function () : void {
        Route::get('committees', [AdminRedirectCommitteesController::class, 'index']);
        Route::post('boards/{board}/committees/continue', [AdminContinueCommitteesController::class, 'store']);
        Route::get('boards/{board}/committees/export', [AdminActiveMembersExportController::class, 'index']);
        Route::resource('boards.committees', AdminCommitteesController::class);
        Route::resource('boards.committees.members', AdminCommitteeMembersController::class);
    });

    // Francken Vrij
    Route::group(['middleware' => 'can:dashboard:francken-vrij-subscriptions-read'], function () : void {
        Route::get('francken-vrij/subscriptions', [AdminSubscriptionsController::class, 'index']);
        Route::post('francken-vrij/subscriptions', [AdminSubscriptionsController::class, 'store']);
        Route::get('francken-vrij/subscriptions/export', [AdminSubscriptionsExportController::class, 'index']);
        Route::get('francken-vrij/subscriptions/create', [AdminSubscriptionsController::class, 'create']);
        Route::get('francken-vrij/subscriptions/{subscription}/edit', [AdminSubscriptionsController::class, 'edit']);
        Route::put('francken-vrij/subscriptions/{subscription}', [AdminSubscriptionsController::class, 'update']);

        Route::get('francken-vrij/editions', [AdminFranckenVrijController::class, 'index']);
        Route::get('francken-vrij/editions/{edition}', [AdminFranckenVrijController::class, 'edit']);
        Route::put('francken-vrij/editions/{edition}', [AdminFranckenVrijController::class, 'update']);
        Route::delete('francken-vrij/editions/{edition}', [AdminFranckenVrijController::class, 'destroy']);
        Route::post('francken-vrij/editions', [AdminFranckenVrijController::class, 'store']);
    });


    Route::group(['middleware' => 'can:dashboard:activities-read'], function () : void {
        Route::get('activities/{activity}/sign-up-settings/create', [AdminSignUpSettingsController::class, 'create']);
        Route::get('activities/{activity}/sign-up-settings/edit', [AdminSignUpSettingsController::class, 'edit']);
        Route::post('activities/{activity}/sign-up-settings', [AdminSignUpSettingsController::class, 'store']);
        Route::put('activities/{activity}/sign-up-settings', [AdminSignUpSettingsController::class, 'update']);
        Route::delete('activities/{activity}/sign-up-settings', [AdminSignUpSettingsController::class, 'destroy']);

        Route::get('activities/{activity}/sign-ups/export', [AdminActivitySignUpsExportController::class, 'index']);
        Route::resource('activities.sign-ups', AdminSignUpsController::class);
        Route::resource('activities', AdminActivitiesController::class);
    });

    Route::group(['middleware' => 'can:dashboard:alumni-activity'], function () : void {
        Route::get('alumni-activity', [AdminAlumniActivityController::class, 'index']);
        Route::post('alumni-activity', [AdminAlumniActivityController::class, 'store']);
        Route::get('alumni-activity/create', [AdminAlumniActivityController::class, 'create']);
        Route::get('alumni-activity/{alumnus}/edit', [AdminAlumniActivityController::class, 'edit']);
        Route::put('alumni-activity/{alumnus}', [AdminAlumniActivityController::class, 'update']);
        Route::delete('alumni-activity/{alumnus}', [AdminAlumniActivityController::class, 'destroy']);
    });

    Route::get('photo-albums', [AdminPhotoAlbumsController::class, 'index']);
    Route::post('photo-albums/refresh', [AdminPhotoAlbumsController::class, 'refresh']);
    Route::group(['prefix' => 'symposia'], function () : void {
        Route::group(['middleware' => 'can:dashboard:symposia-write'], function () : void {
            Route::get('/create', [AdminSymposiaController::class, 'create']);
            Route::post('/', [AdminSymposiaController::class, 'store']);
            Route::get('/{symposium}/edit', [AdminSymposiaController::class, 'edit']);
            Route::put('/{symposium}', [AdminSymposiaController::class, 'update']);

            Route::get('/{symposium}/mails/notify-committee', [AdminSymposiaMailPreviewController::class, 'notifyCommittee']);
            Route::get('/{symposium}/mails/information', [AdminSymposiaMailPreviewController::class, 'information']);
            Route::get('/{symposium}/mails/verify', [AdminSymposiaMailPreviewController::class, 'verify']);

            Route::get('/{symposium}/participants/create', [AdminSymposiumParticipantsController::class, 'create']);
            Route::post('/{symposium}/participants', [AdminSymposiumParticipantsController::class, 'store']);
            Route::get('/{symposium}/participants/{participant}/edit', [AdminSymposiumParticipantsController::class, 'edit']);
            Route::put('/{symposium}/participants/{participant}', [AdminSymposiumParticipantsController::class, 'update']);
            Route::put('/{symposium}/participants/{participant}/toggle-spam', [AdminSymposiumParticipantsController::class, 'toggleSpam']);
            Route::delete('/{symposium}/participants/{participant}', [AdminSymposiumParticipantsController::class, 'remove']);
        });

        Route::group(['middleware' => 'can:dashboard:symposia-read'], function () : void {
            Route::get('/', [AdminSymposiaController::class, 'index']);
            Route::get('/{symposium}', [AdminSymposiaController::class, 'show']);

            Route::get('/{symposium}/attendance', [AttendanceController::class, 'index']);
            Route::get('/{symposium}/name-tags', [NameTagsController::class, 'index']);
            Route::get('/{symposium}/export', [ExportController::class, 'index']);
        });
    });

    Route::group(['middleware' => 'can:dashboard:settings-read'], function () : void {
        Route::get('pages', [PagesController::class, 'index']);
        Route::get('pages/{page}', [PagesController::class, 'show']);
        Route::get('pages/{page}/edit', [PagesController::class, 'edit']);
        Route::put('pages/{page}', [PagesController::class, 'update']);
    });
});

Route::group(['prefix' => 'treasurer', 'can:board-treasurer'], function () : void {
    Route::get('deductions', [DeductionsController::class, 'index']);
    Route::post('deductions', [DeductionsController::class, 'store']);
    Route::get('deductions/create', [DeductionsController::class, 'create']);
    Route::get('deductions/{deduction}', [DeductionsController::class, 'show']);
    Route::put('deductions/{deduction}', [DeductionsController::class, 'update']);
    Route::post('deductions/{deduction}/send', [DeductionEmailsController::class, 'create']);
    Route::get('deductions/{deduction}/member/{member}', [DeductionMembersController::class, 'show']);

    Route::resource('products', AdminProductsController::class);
    Route::get('products/{product}/extra/create', [AdminProductExtrasController::class, 'create']);
    Route::get('products/{product}/extra/edit', [AdminProductExtrasController::class, 'edit']);
    Route::post('products/{product}/extra', [AdminProductExtrasController::class, 'store']);
    Route::put('products/{product}/extra', [AdminProductExtrasController::class, 'update']);

    Route::resource('transactions', AdminTransactionsController::class)->except(['show']);
});

Route::group(['prefix' => 'compucie'], function () : void {
    Route::group(['middleware' => 'can:dashboard:accounts-write'], function () : void {
        Route::get('accounts', [AccountsController::class, 'index']);
        Route::get('accounts/create', [AccountsController::class, 'create']);
        Route::post('accounts', [AccountsController::class, 'store']);
        Route::get('accounts/{account}', [AccountsController::class, 'show']);
    });

    Route::group(['middleware' => 'can:dashboard:accounts-write'], function () : void {
        Route::post('accounts', [AccountsController::class, 'store']);
        Route::post('accounts/{account}/permissions/', [AccountPermissionsController::class, 'store']);
        Route::delete('accounts/{account}/permissions/{permission}', [AccountPermissionsController::class, 'remove']);
        Route::post('accounts/{account}/roles/{role}', [AccountRolesController::class, 'store']);
        Route::delete('accounts/{account}/roles/{role}', [AccountRolesController::class, 'remove']);
    });

    Route::get('settings', [SettingsController::class, 'index']);
    Route::put('settings', [SettingsController::class, 'update']);

    Route::group(['middleware' => 'can:dashboard:permissions-write'], function () : void {
        Route::get('roles', [RolesController::class, 'index']);
        Route::get('roles/{role}', [RolesController::class, 'show']);
        Route::get('permissions', [AccountsController::class, 'index']);
    });

    Route::group(['middleware' => 'can:dashboard:permissions-write'], function () : void {
        Route::post('roles/{role}/permissions', [RolePermissionsController::class, 'store']);
        Route::delete('roles/{role}/permissions/{permission}', [RolePermissionsController::class, 'remove']);
    });

    Route::group(['middleware' => 'can:media-read'], function () : void {
        Route::get('media/{directory?}', [MediaController::class, 'index'])
            ->where('directory', '.+');

        Route::get('media-item/{media}', [MediaController::class, 'show']);
    });
});

Route::fallback([AdminController::class, 'showPageIsUnavailable']);
