<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Matrix\Models\Backlog;

/*
|--------------------------------------------------------------------------
| Matrix Resource Routes: Backlog
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/backlog',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {

    Route::get('/{backlog:slug}', [
        'as' => 'playground.matrix.resource.backlogs.slug',
        'uses' => 'BacklogController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'resource/matrix/backlogs',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.backlogs',
        'uses' => 'BacklogController@index',
    ])->can('index', Backlog::class);

    Route::post('/index', [
        'as' => 'playground.matrix.resource.backlogs.index',
        'uses' => 'BacklogController@index',
    ])->can('index', Backlog::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.backlogs.create',
        'uses' => 'BacklogController@create',
    ])->can('create', Backlog::class);

    Route::get('/edit/{backlog}', [
        'as' => 'playground.matrix.resource.backlogs.edit',
        'uses' => 'BacklogController@edit',
    ])->whereUuid('backlog')->can('edit', 'backlog');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.matrix.resource.backlogs.go',
    //     'uses' => 'BacklogController@go',
    // ]);

    Route::get('/{backlog}', [
        'as' => 'playground.matrix.resource.backlogs.show',
        'uses' => 'BacklogController@show',
    ])->whereUuid('backlog')->can('detail', 'backlog')->withTrashed();

    // API

    Route::put('/lock/{backlog}', [
        'as' => 'playground.matrix.resource.backlogs.lock',
        'uses' => 'BacklogController@lock',
    ])->whereUuid('backlog')->can('lock', 'backlog');

    Route::delete('/lock/{backlog}', [
        'as' => 'playground.matrix.resource.backlogs.unlock',
        'uses' => 'BacklogController@unlock',
    ])->whereUuid('backlog')->can('unlock', 'backlog');

    Route::delete('/{backlog}', [
        'as' => 'playground.matrix.resource.backlogs.destroy',
        'uses' => 'BacklogController@destroy',
    ])->whereUuid('backlog')->can('delete', 'backlog')->withTrashed();

    Route::put('/restore/{backlog}', [
        'as' => 'playground.matrix.resource.backlogs.restore',
        'uses' => 'BacklogController@restore',
    ])->whereUuid('backlog')->can('restore', 'backlog')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.backlogs.post',
        'uses' => 'BacklogController@store',
    ])->can('store', Backlog::class);

    // Route::put('/', [
    //     'as' => 'playground.matrix.resource.backlogs.put',
    //     'uses' => 'BacklogController@store',
    // ])->can('store', Playground\Matrix\Models\Backlog::class);
    //
    // Route::put('/{backlog}', [
    //     'as' => 'playground.matrix.resource.backlogs.put.id',
    //     'uses' => 'BacklogController@store',
    // ])->whereUuid('backlog')->can('update', 'backlog');

    Route::patch('/{backlog}', [
        'as' => 'playground.matrix.resource.backlogs.patch',
        'uses' => 'BacklogController@update',
    ])->whereUuid('backlog')->can('update', 'backlog');
});
