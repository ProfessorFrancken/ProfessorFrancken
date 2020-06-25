<?php

declare(strict_types=1);


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Francken\Association\Activities\Http\ApiActivitiesController;
use Francken\Extern\Http\ApiJobOpeningsController;
use Francken\PlusOne\Http as PlusOne;
use Francken\Shared\Http\Controllers\JasController;
use Francken\Study\BooksSale\Http\ApiBooksController;

Route::get('jas-events', [JasController::class, 'index']);
Route::post('store-jas-events', [JasController::class, 'store']);

Route::get('/database/streep/afbeeldingen/{url}', [PlusOne\PicturesController::class, 'show'])
    ->where('url', '.*');

Route::group(['prefix' => '/api'], function () : void {
    Route::get('activities', [ApiActivitiesController::class, 'index']);
    Route::get('books', [ApiBooksController::class, 'index']);
    Route::get('job-openings', [ApiJobOpeningsController::class, 'index']);

    Route::group(['prefix' => '/plus-one'], function () : void {
        Route::post('authenticate', [PlusOne\AuthenticationController::class, 'post']);
    });

    Route::group(['prefix' => '/plus-one', 'middleware' => 'plus-one'], function () : void {
        Route::get('orders', [PlusOne\OrdersController::class, 'index']);
        Route::post('orders', [PlusOne\OrdersController::class, 'post']);

        Route::get('products', [PlusOne\ProductsController::class, 'index']);
        Route::get('members', [PlusOne\MembersController::class, 'index']);
        Route::get('committees', [PlusOne\CommitteesController::class, 'index']);
        Route::get('boards', [PlusOne\BoardsController::class, 'index']);
        Route::get('sponsors', [PlusOne\SponsorsController::class, 'index']);

        Route::get('statistics/categories/', [PlusOne\CategoryStatisticsController::class, 'index']);
        Route::get('statistics/activities', [ApiActivitiesController::class, 'index']);
    });
});
