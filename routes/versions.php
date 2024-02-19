<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Version
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/versions',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.versions',
        'uses' => 'VersionController@index',
    ])->can('index', Playground\Matrix\Models\Version::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.versions.create',
        'uses' => 'VersionController@create',
    ])->can('create', Playground\Matrix\Models\Version::class);

    Route::get('/edit/{version}', [
        'as' => 'playground.matrix.resource.versions.edit',
        'uses' => 'VersionController@edit',
    ])->whereUuid('version')
        ->can('edit', 'version');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.versions.go',
    //     'uses' => 'VersionController@go',
    // ]);

    Route::get('/{version}', [
        'as' => 'playground.matrix.resource.versions.show',
        'uses' => 'VersionController@show',
    ])->whereUuid('version')
        ->can('detail', 'version');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.versions.slug',
    //     'uses' => 'VersionController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.versions.store',
    //     'uses' => 'VersionController@store',
    // ])->can('store', \Playground\Matrix\Models\Version::class);

    // API

    Route::put('/lock/{version}', [
        'as' => 'playground.matrix.resource.versions.lock',
        'uses' => 'VersionController@lock',
    ])->whereUuid('version')
        ->can('lock', 'version');

    Route::delete('/lock/{version}', [
        'as' => 'playground.matrix.resource.versions.unlock',
        'uses' => 'VersionController@unlock',
    ])->whereUuid('version')
        ->can('unlock', 'version');

    Route::delete('/{version}', [
        'as' => 'playground.matrix.resource.versions.destroy',
        'uses' => 'VersionController@destroy',
    ])->whereUuid('version')
        ->can('delete', 'version')
        ->withTrashed();

    Route::put('/restore/{version}', [
        'as' => 'playground.matrix.resource.versions.restore',
        'uses' => 'VersionController@restore',
    ])->whereUuid('version')
        ->can('restore', 'version')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.versions.post',
        'uses' => 'VersionController@store',
    ])->can('store', Playground\Matrix\Models\Version::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.versions.put',
    //     'uses' => 'VersionController@store',
    // ])->can('store', \Playground\Matrix\Models\Version::class);
    //
    // Route::put('/{version}', [
    //     'as'   => 'playground.matrix.resource.versions.put.id',
    //     'uses' => 'VersionController@store',
    // ])->whereUuid('version')->can('update', 'version');

    Route::patch('/{version}', [
        'as' => 'playground.matrix.resource.versions.patch',
        'uses' => 'VersionController@update',
    ])->whereUuid('version')->can('update', 'version');
});
