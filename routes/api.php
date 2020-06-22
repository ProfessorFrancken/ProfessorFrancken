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

use Francken\Api\Http\ActivitiesController;
use Francken\Study\BooksSale\Http\ApiBooksController;
use Francken\Api\Http\JobOpeningsController;
use Francken\Infrastructure\Http\Controllers\JasController;
use Francken\PlusOne\Http as PlusOne;

Route::get('jas-events', [JasController::class, 'index']);
Route::post('store-jas-events', [JasController::class, 'store']);

Route::get('/database/streep/afbeeldingen/{url}', [PlusOne\PicturesController::class, 'show'])
    ->where('url', '.*');

Route::group(['prefix' => '/api'], function () : void {
    Route::get('activities', [ActivitiesController::class, 'index']);
    Route::get('books', [ApiBooksController::class, 'index']);
    Route::get('job-openings', [JobOpeningsController::class, 'index']);

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
        Route::get('statistics/activities', [ActivitiesController::class, 'index']);
    });
});
