<?php

declare(strict_types=1);

use Francken\Association\News\Http\AdminNewsController;
use Francken\Association\Symposium\Http\AdminSymposiaController;
use Francken\Association\Symposium\Http\AdminSymposiumParticipantsController;
use Francken\Association\Symposium\Http\AttendanceController;
use Francken\Association\Symposium\Http\ExportController;
use Francken\Association\Symposium\Http\NameTagsController;
use Francken\Association\Symposium\Http\ParticipantRegistrationController;
use Francken\Auth\Http\Controllers\Admin\AccountPermissionsController;
use Francken\Auth\Http\Controllers\Admin\AccountRolesController;
use Francken\Auth\Http\Controllers\Admin\AccountsController;
use Francken\Auth\Http\Controllers\Admin\RolePermissionsController;
use Francken\Auth\Http\Controllers\Admin\RolesController;
use Francken\Auth\Http\Controllers\ForgotPasswordController;
use Francken\Auth\Http\Controllers\LoginController;
use Francken\Auth\Http\Controllers\ResetPasswordController;
use Francken\Extern\Http\FactSheetController;
use Francken\Infrastructure\Http\Controllers\Admin\CommitteeController as AdminCommitteeController;
use Francken\Infrastructure\Http\Controllers\Admin\FranckenVrijController;
use Francken\Infrastructure\Http\Controllers\Admin\RegistrationRequestsController;
use Francken\Infrastructure\Http\Controllers\BookController;
use Francken\Infrastructure\Http\Controllers\CareerController;
use Francken\Infrastructure\Http\Controllers\CommitteesController;
use Francken\Infrastructure\Http\Controllers\CompaniesController;
use Francken\Infrastructure\Http\Controllers\DashboardController;
use Francken\Infrastructure\Http\Controllers\MainContentController;
use Francken\Infrastructure\Http\Controllers\MemberController;
use Francken\Infrastructure\Http\Controllers\RegistrationController;
use Francken\Infrastructure\Http\Controllers\ResearchGroupsController;
use Francken\Shared\Http\Controllers\RedirectController;
use Francken\Shared\Media\Http\Controllers\MediaController;
use Francken\Treasurer\Http\Controllers\DeductionEmailsController;
use Francken\Treasurer\Http\Controllers\DeductionMembersController;
use Francken\Treasurer\Http\Controllers\DeductionsController;
use Francken\infrastructure\Http\Controllers\Admin\AdminController;

Route::group(['prefix' => 'admin/association', 'middleware' => ['auth']], function () : void {
    Route::put('/news/publish/{item}', [AdminNewsController::class, 'publish']);
    Route::put('/news/archive/{item}', [AdminNewsController::class, 'archive']);
    Route::get('/news/{item}/preview', [AdminNewsController::class, 'preview']);
    Route::resource('news', '\Francken\Association\News\Http\AdminNewsController');
});

Route::group(['middleware' => ['web', 'bindings'], ], function () : void {
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'can:can-access-dashboard']], function () : void {
        Route::get('/', [DashboardController::class, 'redirectToDashboard']);
        Route::get('overview', [DashboardController::class, 'overview']);
        Route::get('analytics', [DashboardController::class, 'analytics']);
        Route::get('export', [DashboardController::class, 'export']);

        Route::group(['prefix' => 'study'], function () : void {
            Route::get('research-groups', [AdminController::class, 'showPageIsUnavailable']);

            Route::group(['middleware' => 'can:dashboard:books-write'], function () : void {
                Route::get('books/create', [\Francken\Study\BooksSale\Http\AdminBooksController::class, 'create']);
                Route::post('books', [\Francken\Study\BooksSale\Http\AdminBooksController::class, 'store']);
                Route::put('books/{book}', [\Francken\Study\BooksSale\Http\AdminBooksController::class, 'update']);
                Route::delete('books/{book}', [\Francken\Study\BooksSale\Http\AdminBooksController::class, 'remove']);
            });

            Route::group(['middleware' => 'can:dashboard:books-read'], function () : void {
                Route::get('books', [\Francken\Study\BooksSale\Http\AdminBooksController::class, 'index']);
                Route::get('books/{book}', [\Francken\Study\BooksSale\Http\AdminBooksController::class, 'show']);
            });
        });

        Route::group(['prefix' => 'extern', ], function () : void {
            Route::get('/fact-sheet', [FactSheetController::class, 'index']);

            $unavailable = [AdminController::class, 'showPageIsUnavailable'];

            Route::get('companies', $unavailable);
            Route::get('events', $unavailable);
            Route::get('job-openings', $unavailable);
        });

        Route::group(['prefix' => 'association'], function () : void {
            //committees
            Route::resource('committees', '\Francken\Infrastructure\Http\Controllers\Admin\CommitteeController');
            Route::post('committees/search-member', [AdminCommitteeController::class, 'searchMember']);
            Route::post('committees/{committeeId}/member/{memberId}', [AdminCommitteeController::class, 'addMember']);
            Route::delete('committees/{committeeId}/member/{memberId}', [AdminCommitteeController::class, 'removeMember']);

            Route::get('member', [MemberController::class, 'index']);
            Route::post('member/add-member', [MemberController::class, 'addMember']);

            Route::get('boards/export', [\Francken\Association\Boards\Http\Controllers\AdminExportsController::class, 'index']);
            Route::post('boards/import', [\Francken\Association\Boards\Http\Controllers\AdminImportsController::class, 'store']);
            Route::resource('boards', '\Francken\Association\Boards\Http\Controllers\AdminBoardsController');
            // Route::resource('boards/{board}/members', '\Francken\Association\Boards\Http\Controllers\AdminBoardMembersController']);

            Route::get('registration-requests', [RegistrationRequestsController::class, 'index']);
            Route::get('registration-requests/{requestId}', [RegistrationRequestsController::class, 'show']);
            Route::delete('registration-requests/{requestId}', [RegistrationRequestsController::class, 'remove']);

            // Francken Vrij
            Route::get('francken-vrij', [FranckenVrijController::class, 'index']);
            Route::get('francken-vrij/{edition}', [FranckenVrijController::class, 'edit']);
            Route::put('francken-vrij/{edition}', [FranckenVrijController::class, 'update']);
            Route::delete('francken-vrij/{edition}', [FranckenVrijController::class, 'destroy']);
            Route::post('francken-vrij', [FranckenVrijController::class, 'store']);

            Route::get('activities', [AdminController::class, 'showPageIsUnavailable']);
            Route::get('members', [AdminController::class, 'showPageIsUnavailable']);

            Route::group(['prefix' => 'symposia'], function () : void {
                Route::group(['middleware' => 'can:dashboard:symposia-write'], function () : void {
                    Route::get('/create', [AdminSymposiaController::class, 'create']);
                    Route::post('/', [AdminSymposiaController::class, 'store']);
                    Route::get('/{symposium}/edit', [AdminSymposiaController::class, 'edit']);
                    Route::put('/{symposium}', [AdminSymposiaController::class, 'update']);

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
        });

        Route::group(['prefix' => 'treasurer', 'can:board-treasurer'], function () : void {
            Route::get('deductions', [DeductionsController::class, 'index']);
            Route::post('deductions', [DeductionsController::class, 'store']);
            Route::get('deductions/create', [DeductionsController::class, 'create']);
            Route::get('deductions/{deduction}', [DeductionsController::class, 'show']);
            Route::put('deductions/{deduction}', [DeductionsController::class, 'update']);
            Route::post('deductions/{deduction}/send', [DeductionEmailsController::class, 'create']);
            Route::get('deductions/{deduction}/member/{member}', [DeductionMembersController::class, 'show']);
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

            Route::get('settings', [\Francken\Shared\Settings\Http\Controllers\SettingsController::class, 'index']);
            Route::put('settings', [\Francken\Shared\Settings\Http\Controllers\SettingsController::class, 'update']);

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
    });
});
