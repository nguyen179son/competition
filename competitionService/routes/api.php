<?php

use Illuminate\Http\Request;

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
Route::prefix('competition')->group(function () {
    Route::get('/','CompetitionController@listCompetition');
    Route::post('/', 'CompetitionController@store');
    Route::prefix('/{competition_id}')->group(function () {
        Route::get('/', 'CompetitionController@show');
        Route::post('/', 'CompetitionController@update');
        Route::delete('/', 'CompetitionController@destroy');
        Route::prefix('/category')->group(function () {
            Route::post('/', 'CategoryController@store');
            Route::prefix('/{category_id}')->group(function () {
                Route::get('/', 'CategoryController@show');
                Route::put('/', 'CategoryController@update');
                Route::delete('/', 'CategoryController@destroy');

                Route::prefix('/dj')->group(function () {
                    Route::post('/', 'DjController@store');
                    Route::put('/{dj_id}', 'DjController@update');
                    Route::delete('/{dj_id}', 'DjController@destroy');
                });
                Route::prefix('/judge')->group(function () {
                    Route::post('/', 'JudgeController@store');
                    Route::put('/{judge_id}', 'JudgeController@update');
                    Route::delete('/{judge_id}', 'JudgeController@destroy');
                });
                Route::prefix('/mc')->group(function () {
                    Route::post('/', 'McController@store');
                    Route::put('/{mc_id}', 'McController@update');
                    Route::delete('/{mc_id}', 'McController@destroy');
                });
                Route::prefix('/prize')->group(function () {
                    Route::post('/', 'PrizeController@store');
                    Route::put('/{prize_id}', 'PrizeController@update');
                    Route::delete('/{prize_id}', 'PrizeController@destroy');
                });
                Route::prefix('/team')->group(function () {
                    Route::post('/', 'TeamController@store');
                    Route::put('/{team_id}', 'TeamController@update');
                    Route::delete('/{team_id}', 'TeamController@destroy');
                });

            });
        });
    });
});
Route::get('/dance-genre','DanceGenreController@show');
