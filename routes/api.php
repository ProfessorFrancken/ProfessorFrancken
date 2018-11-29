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

Route::post('store-jas-events', 'JasController@store');
Route::get('jas-events', function () {
    return DB::table('jas_events')->get();
});

Route::get('/database/streep/afbeeldingen/{url}', function ($url) {
    return redirect('http://old.professorfrancken.nl/database/streep/afbeeldingen/' . $url);
})->where('url', '.*');

Route::group(['middleware' => ['api'], 'prefix' => 'api'], function () : void {
    Route::get('activities', '\Francken\Api\Http\ActivitiesController@index');
    Route::get('books', '\Francken\Api\Http\BooksController@index');
    Route::get('job-openings', '\Francken\Api\Http\JobOpeningsController@index');
});