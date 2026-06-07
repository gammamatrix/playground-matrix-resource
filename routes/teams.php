<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Matrix\Models\Team;

/*
|--------------------------------------------------------------------------
| Matrix Resource Routes: Team
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/team',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {

    Route::get('/{team:slug}', [
        'as' => 'playground.matrix.resource.teams.slug',
        'uses' => 'TeamController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'resource/matrix/teams',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.teams',
        'uses' => 'TeamController@index',
    ])->can('index', Team::class);

    Route::post('/index', [
        'as' => 'playground.matrix.resource.teams.index',
        'uses' => 'TeamController@index',
    ])->can('index', Team::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.teams.create',
        'uses' => 'TeamController@create',
    ])->can('create', Team::class);

    Route::get('/edit/{team}', [
        'as' => 'playground.matrix.resource.teams.edit',
        'uses' => 'TeamController@edit',
    ])->whereUuid('team')->can('edit', 'team');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.matrix.resource.teams.go',
    //     'uses' => 'TeamController@go',
    // ]);

    Route::get('/{team}', [
        'as' => 'playground.matrix.resource.teams.show',
        'uses' => 'TeamController@show',
    ])->whereUuid('team')->can('detail', 'team')->withTrashed();

    // API

    Route::put('/lock/{team}', [
        'as' => 'playground.matrix.resource.teams.lock',
        'uses' => 'TeamController@lock',
    ])->whereUuid('team')->can('lock', 'team');

    Route::delete('/lock/{team}', [
        'as' => 'playground.matrix.resource.teams.unlock',
        'uses' => 'TeamController@unlock',
    ])->whereUuid('team')->can('unlock', 'team');

    Route::delete('/{team}', [
        'as' => 'playground.matrix.resource.teams.destroy',
        'uses' => 'TeamController@destroy',
    ])->whereUuid('team')->can('delete', 'team')->withTrashed();

    Route::put('/restore/{team}', [
        'as' => 'playground.matrix.resource.teams.restore',
        'uses' => 'TeamController@restore',
    ])->whereUuid('team')->can('restore', 'team')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.teams.post',
        'uses' => 'TeamController@store',
    ])->can('store', Team::class);

    // Route::put('/', [
    //     'as' => 'playground.matrix.resource.teams.put',
    //     'uses' => 'TeamController@store',
    // ])->can('store', Playground\Matrix\Models\Team::class);
    //
    // Route::put('/{team}', [
    //     'as' => 'playground.matrix.resource.teams.put.id',
    //     'uses' => 'TeamController@store',
    // ])->whereUuid('team')->can('update', 'team');

    Route::patch('/{team}', [
        'as' => 'playground.matrix.resource.teams.patch',
        'uses' => 'TeamController@update',
    ])->whereUuid('team')->can('update', 'team');
});
