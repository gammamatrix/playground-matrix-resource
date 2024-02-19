<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Source
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/sources',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.sources',
        'uses' => 'SourceController@index',
    ])->can('index', Playground\Matrix\Models\Source::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.sources.create',
        'uses' => 'SourceController@create',
    ])->can('create', Playground\Matrix\Models\Source::class);

    Route::get('/edit/{source}', [
        'as' => 'playground.matrix.resource.sources.edit',
        'uses' => 'SourceController@edit',
    ])->whereUuid('source')
        ->can('edit', 'source');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.sources.go',
    //     'uses' => 'SourceController@go',
    // ]);

    Route::get('/{source}', [
        'as' => 'playground.matrix.resource.sources.show',
        'uses' => 'SourceController@show',
    ])->whereUuid('source')
        ->can('detail', 'source');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.sources.slug',
    //     'uses' => 'SourceController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.sources.store',
    //     'uses' => 'SourceController@store',
    // ])->can('store', \Playground\Matrix\Models\Source::class);

    // API

    Route::put('/lock/{source}', [
        'as' => 'playground.matrix.resource.sources.lock',
        'uses' => 'SourceController@lock',
    ])->whereUuid('source')
        ->can('lock', 'source');

    Route::delete('/lock/{source}', [
        'as' => 'playground.matrix.resource.sources.unlock',
        'uses' => 'SourceController@unlock',
    ])->whereUuid('source')
        ->can('unlock', 'source');

    Route::delete('/{source}', [
        'as' => 'playground.matrix.resource.sources.destroy',
        'uses' => 'SourceController@destroy',
    ])->whereUuid('source')
        ->can('delete', 'source')
        ->withTrashed();

    Route::put('/restore/{source}', [
        'as' => 'playground.matrix.resource.sources.restore',
        'uses' => 'SourceController@restore',
    ])->whereUuid('source')
        ->can('restore', 'source')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.sources.post',
        'uses' => 'SourceController@store',
    ])->can('store', Playground\Matrix\Models\Source::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.sources.put',
    //     'uses' => 'SourceController@store',
    // ])->can('store', \Playground\Matrix\Models\Source::class);
    //
    // Route::put('/{source}', [
    //     'as'   => 'playground.matrix.resource.sources.put.id',
    //     'uses' => 'SourceController@store',
    // ])->whereUuid('source')->can('update', 'source');

    Route::patch('/{source}', [
        'as' => 'playground.matrix.resource.sources.patch',
        'uses' => 'SourceController@update',
    ])->whereUuid('source')->can('update', 'source');
});
