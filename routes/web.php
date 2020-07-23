<?php

declare(strict_types=1);

use Francken\Association\Activities\Http\ActivitiesController;
use Francken\Association\Activities\Http\ActivitiesPerMonthController;
use Francken\Association\Activities\Http\IcalController;
use Francken\Association\Boards\Http\Controllers\BirthdaysController;
use Francken\Association\Boards\Http\Controllers\BoardsController;
use Francken\Association\Committees\Http\CommitteesController;
use Francken\Association\Committees\Http\RedirectToBoardCommitteesController;
use Francken\Association\FranckenVrij\Http\FranckenVrijController;
use Francken\Association\Members\Http\ContactDetailsController;
use Francken\Association\Members\Http\Controllers\RegistrationController;
use Francken\Association\Members\Http\ExpensesController;
use Francken\Association\Members\Http\PasswordController;
use Francken\Association\Members\Http\ProfileController;
use Francken\Association\News\Http\NewsController;
use Francken\Association\Photos\Http\Controllers\AuthenticationController;
use Francken\Association\Photos\Http\Controllers\PhotosController;
use Francken\Association\Symposium\Http\ParticipantRegistrationController;
use Francken\Auth\Http\Controllers\ForgotPasswordController;
use Francken\Auth\Http\Controllers\LoginController;
use Francken\Auth\Http\Controllers\ResetPasswordController;
use Francken\Extern\Http\CareerController;
use Francken\Extern\Http\CompaniesController;
use Francken\Lustrum\Http\Controllers\AdtchievementController;
use Francken\Lustrum\Http\Controllers\LustrumController;
use Francken\Lustrum\Http\Controllers\PirateCrewController;
use Francken\Lustrum\Http\Controllers\TV;
use Francken\Shared\Http\Controllers\MainContentController;
use Francken\Shared\Http\Controllers\RedirectController;
use Francken\Shared\Http\Controllers\ResearchGroupsController;
use Francken\Study\BooksSale\Http\BooksController;

Route::redirect('/blog', '/association/news');
Route::permanentRedirect('/wordpress', '/');
Route::redirect('/books', '/study/books');
Route::redirect('/boeken', '/study/books');
Route::redirect('/photos', '/association/photos');
Route::get('/wordpress/{url}', [RedirectController::class, 'wordpress'])->where('url', '.*');
Route::get('/scriptcie/{url}', [RedirectController::class, 'scriptcie'])->where('url', '.*');

Route::get('/', [MainContentController::class, 'index'])->name('home');

Route::get('/register', [RegistrationController::class, 'index']);
Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/register/{registration}', [RegistrationController::class, 'show'])
    ->name('registration.show')
    ->middleware(['signed']);

Route::get('/register/{registration}/verify', [RegistrationController::class, 'verify'])
    ->name('registration.verify')
    ->middleware(['signed', 'throttle:6,1']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('get-logout');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::group(['prefix' => 'study'], function () : void {
    Route::get('books', [BooksController::class, 'index']);
    Route::get('books/{book}', [BooksController::class, 'show']);

    Route::get('research-groups', [ResearchGroupsController::class, 'index']);
    Route::get('research-groups/{group}', [ResearchGroupsController::class, 'show']);
});

Route::group(['prefix' => 'association'], function () : void {
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/archive', [NewsController::class, 'archive']);
    Route::get('/news/{news:slug}', [NewsController::class, 'show']);

    Route::get('activities', [ActivitiesController::class, 'index']);
    Route::get('activities/ical', [IcalController::class, 'index']);
    Route::get('activities/ical/all', [IcalController::class, 'show']);
    Route::get('activities/{year}/{month}', [ActivitiesPerMonthController::class, 'index']);

    Route::get('committees', [RedirectToBoardCommitteesController::class, 'index']);
    Route::get('committees/{committee:slug}', [RedirectToBoardCommitteesController::class, 'show']);

    Route::get('{board:board_year_slug}/committees', [CommitteesController::class, 'index']);
    Route::get('{board:board_year_slug}/committees/{committee:slug}', [CommitteesController::class, 'show']);

    Route::get('francken-vrij', [FranckenVrijController::class, 'index']);

    Route::get('boards', [BoardsController::class, 'index']);
    Route::get('boards/birthdays', [BirthdaysController::class, 'index'])
        ->middleware(['role:Board|Old Board|Candidate Board|Demissioned Board|Decharged Board']);

    Route::get('photos/login', [AuthenticationController::class, 'index']);
    Route::post('photos', [AuthenticationController::class, 'store']);
    Route::group(['middleware' => ['login-to-view-photos']], function () : void {
        Route::get('photos', [PhotosController::class, 'index']);
        Route::get('photos/{album}', [PhotosController::class, 'show']);
    });
});

Route::group(['prefix' => 'career'], function () : void {
    Route::get('/', [CareerController::class, 'index']);
    Route::get('job-openings', [CareerController::class, 'jobs'])->name('job-openings');
    Route::get('companies', [CompaniesController::class, 'index']);
    Route::get('companies/{partner:slug}', [CompaniesController::class, 'show']);
    Route::get('events', [CareerController::class, 'redirectEvents']);
    Route::get('events/{academic_year}', [CareerController::class, 'events']);
});

Route::group(['prefix' => 'profile', 'middleware' => ['web', 'auth']], function ($router) : void {
    Route::get('/', [ProfileController::class, 'index']);

    Route::get('expenses', [ExpensesController::class, 'index']);
    Route::get('expenses/{year}/{month}', [ExpensesController::class, 'show']);

    Route::get('password', [PasswordController::class, 'index']);
    Route::put('password', [PasswordController::class, 'update']);

    Route::get('contact-details', [ContactDetailsController::class, 'index']);
    Route::put('contact-details', [ContactDetailsController::class, 'update']);
});

Route::get('/symposia/{symposium}/participants/{participant}', [
    ParticipantRegistrationController::class,
    'verify'
])->name('symposium.participant.verify')->middleware(['signed', 'throttle:6,1']);

Route::post('/symposia/{symposium}/participants', [
    ParticipantRegistrationController::class,
    'store'
])->middleware(['throttle:6,1', 'symposium-cors']);

Route::prefix('lustrum')->group(function () : void {
    Route::prefix('tv')->group(function () : void {
        Route::get('pirate-crews', [TV\PirateCrewsController::class, 'index']);
        Route::get('adtchievements', [TV\AdtchievementsController::class, 'index']);
    });

    Route::get('/', [LustrumController::class, 'index']);

    Route::get('/adtchievements', [AdtchievementController::class, 'index']);
    Route::get('{pirateCrew}', [PirateCrewController::class, 'index']);
});
