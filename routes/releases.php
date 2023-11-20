<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Release
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/releases',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\GammaMatrix\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource.releases',
        'uses' => 'ReleaseController@index',
    ])->can('index', \GammaMatrix\Playground\Matrix\Models\Release::class);

    # UI

    Route::get('/create', [
        'as'   => 'playground.matrix.resource.releases.create',
        'uses' => 'ReleaseController@create',
    ])->can('create', \GammaMatrix\Playground\Matrix\Models\Release::class);

    Route::get('/edit/{release}', [
        'as'   => 'playground.matrix.resource.releases.edit',
        'uses' => 'ReleaseController@edit',
    ])->whereUuid('release')
        ->can('edit', 'release')
    ;

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.releases.go',
    //     'uses' => 'ReleaseController@go',
    // ]);

    Route::get('/{release}', [
        'as'   => 'playground.matrix.resource.releases.show',
        'uses' => 'ReleaseController@show',
    ])->whereUuid('release')
        ->can('detail', 'release')
    ;

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.releases.slug',
    //     'uses' => 'ReleaseController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.releases.store',
    //     'uses' => 'ReleaseController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Release::class);

    # API

    Route::put('/lock/{release}', [
        'as'   => 'playground.matrix.resource.releases.lock',
        'uses' => 'ReleaseController@lock',
    ])->whereUuid('release')
        ->can('lock', 'release')
    ;

    Route::put('/unlock/{release}', [
        'as'   => 'playground.matrix.resource.releases.unlock',
        'uses' => 'ReleaseController@unlock',
    ])->whereUuid('release')
        ->can('unlock', 'release')
    ;

    Route::delete('/{release}', [
        'as'   => 'playground.matrix.resource.releases.destroy',
        'uses' => 'ReleaseController@destroy',
    ])->whereUuid('release')
        ->can('delete', 'release')
        ->withTrashed()
    ;

    Route::put('/restore/{release}', [
        'as'   => 'playground.matrix.resource.releases.restore',
        'uses' => 'ReleaseController@restore',
    ])->whereUuid('release')
        ->can('restore', 'release')
        ->withTrashed()
    ;

    Route::post('/', [
        'as'   => 'playground.matrix.resource.releases.post',
        'uses' => 'ReleaseController@store',
    ])->can('store', \GammaMatrix\Playground\Matrix\Models\Release::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.releases.put',
    //     'uses' => 'ReleaseController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Release::class);
    //
    // Route::put('/{release}', [
    //     'as'   => 'playground.matrix.resource.releases.put.id',
    //     'uses' => 'ReleaseController@store',
    // ])->whereUuid('release')->can('update', 'release');

    Route::patch('/{release}', [
        'as'   => 'playground.matrix.resource.releases.patch',
        'uses' => 'ReleaseController@update',
    ])->whereUuid('release')->can('update', 'release');
});
