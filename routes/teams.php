<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Team
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/teams',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.teams',
        'uses' => 'TeamController@index',
    ])->can('index', Playground\Matrix\Models\Team::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.teams.create',
        'uses' => 'TeamController@create',
    ])->can('create', Playground\Matrix\Models\Team::class);

    Route::get('/edit/{team}', [
        'as' => 'playground.matrix.resource.teams.edit',
        'uses' => 'TeamController@edit',
    ])->whereUuid('team')
        ->can('edit', 'team');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.teams.go',
    //     'uses' => 'TeamController@go',
    // ]);

    Route::get('/{team}', [
        'as' => 'playground.matrix.resource.teams.show',
        'uses' => 'TeamController@show',
    ])->whereUuid('team')
        ->can('detail', 'team');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.teams.slug',
    //     'uses' => 'TeamController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.teams.store',
    //     'uses' => 'TeamController@store',
    // ])->can('store', \Playground\Matrix\Models\Team::class);

    // API

    Route::put('/lock/{team}', [
        'as' => 'playground.matrix.resource.teams.lock',
        'uses' => 'TeamController@lock',
    ])->whereUuid('team')
        ->can('lock', 'team');

    Route::delete('/lock/{team}', [
        'as' => 'playground.matrix.resource.teams.unlock',
        'uses' => 'TeamController@unlock',
    ])->whereUuid('team')
        ->can('unlock', 'team');

    Route::delete('/{team}', [
        'as' => 'playground.matrix.resource.teams.destroy',
        'uses' => 'TeamController@destroy',
    ])->whereUuid('team')
        ->can('delete', 'team')
        ->withTrashed();

    Route::put('/restore/{team}', [
        'as' => 'playground.matrix.resource.teams.restore',
        'uses' => 'TeamController@restore',
    ])->whereUuid('team')
        ->can('restore', 'team')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.teams.post',
        'uses' => 'TeamController@store',
    ])->can('store', Playground\Matrix\Models\Team::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.teams.put',
    //     'uses' => 'TeamController@store',
    // ])->can('store', \Playground\Matrix\Models\Team::class);
    //
    // Route::put('/{team}', [
    //     'as'   => 'playground.matrix.resource.teams.put.id',
    //     'uses' => 'TeamController@store',
    // ])->whereUuid('team')->can('update', 'team');

    Route::patch('/{team}', [
        'as' => 'playground.matrix.resource.teams.patch',
        'uses' => 'TeamController@update',
    ])->whereUuid('team')->can('update', 'team');
});
