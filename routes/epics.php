<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Resource Routes: Epic
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/epic',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {

    Route::get('/{epic:slug}', [
        'as' => 'playground.matrix.resource.epics.slug',
        'uses' => 'EpicController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'resource/matrix/epics',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.epics',
        'uses' => 'EpicController@index',
    ])->can('index', Playground\Matrix\Models\Epic::class);

    Route::post('/index', [
        'as' => 'playground.matrix.resource.epics.index',
        'uses' => 'EpicController@index',
    ])->can('index', Playground\Matrix\Models\Epic::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.epics.create',
        'uses' => 'EpicController@create',
    ])->can('create', Playground\Matrix\Models\Epic::class);

    Route::get('/edit/{epic}', [
        'as' => 'playground.matrix.resource.epics.edit',
        'uses' => 'EpicController@edit',
    ])->whereUuid('epic')->can('edit', 'epic');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.matrix.resource.epics.go',
    //     'uses' => 'EpicController@go',
    // ]);

    Route::get('/{epic}', [
        'as' => 'playground.matrix.resource.epics.show',
        'uses' => 'EpicController@show',
    ])->whereUuid('epic')->can('detail', 'epic');

    // API

    Route::put('/lock/{epic}', [
        'as' => 'playground.matrix.resource.epics.lock',
        'uses' => 'EpicController@lock',
    ])->whereUuid('epic')->can('lock', 'epic');

    Route::delete('/lock/{epic}', [
        'as' => 'playground.matrix.resource.epics.unlock',
        'uses' => 'EpicController@unlock',
    ])->whereUuid('epic')->can('unlock', 'epic');

    Route::delete('/{epic}', [
        'as' => 'playground.matrix.resource.epics.destroy',
        'uses' => 'EpicController@destroy',
    ])->whereUuid('epic')->can('delete', 'epic')->withTrashed();

    Route::put('/restore/{epic}', [
        'as' => 'playground.matrix.resource.epics.restore',
        'uses' => 'EpicController@restore',
    ])->whereUuid('epic')->can('restore', 'epic')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.epics.post',
        'uses' => 'EpicController@store',
    ])->can('store', Playground\Matrix\Models\Epic::class);

    // Route::put('/', [
    //     'as' => 'playground.matrix.resource.epics.put',
    //     'uses' => 'EpicController@store',
    // ])->can('store', Playground\Matrix\Models\Epic::class);
    //
    // Route::put('/{epic}', [
    //     'as' => 'playground.matrix.resource.epics.put.id',
    //     'uses' => 'EpicController@store',
    // ])->whereUuid('epic')->can('update', 'epic');

    Route::patch('/{epic}', [
        'as' => 'playground.matrix.resource.epics.patch',
        'uses' => 'EpicController@update',
    ])->whereUuid('epic')->can('update', 'epic');
});
