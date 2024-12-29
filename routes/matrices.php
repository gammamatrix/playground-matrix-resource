<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Resource Routes: Matrix
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/matrix',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {

    Route::get('/{matrix:slug}', [
        'as' => 'playground.matrix.resource.matrices.slug',
        'uses' => 'MatrixController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'resource/matrix/matrices',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.matrices',
        'uses' => 'MatrixController@index',
    ])->can('index', Playground\Matrix\Models\Matrix::class);

    Route::post('/index', [
        'as' => 'playground.matrix.resource.matrices.index',
        'uses' => 'MatrixController@index',
    ])->can('index', Playground\Matrix\Models\Matrix::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.matrices.create',
        'uses' => 'MatrixController@create',
    ])->can('create', Playground\Matrix\Models\Matrix::class);

    Route::get('/edit/{matrix}', [
        'as' => 'playground.matrix.resource.matrices.edit',
        'uses' => 'MatrixController@edit',
    ])->whereUuid('matrix')->can('edit', 'matrix');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.matrix.resource.matrices.go',
    //     'uses' => 'MatrixController@go',
    // ]);

    Route::get('/{matrix}', [
        'as' => 'playground.matrix.resource.matrices.show',
        'uses' => 'MatrixController@show',
    ])->whereUuid('matrix')->can('detail', 'matrix')->withTrashed();

    // API

    Route::put('/lock/{matrix}', [
        'as' => 'playground.matrix.resource.matrices.lock',
        'uses' => 'MatrixController@lock',
    ])->whereUuid('matrix')->can('lock', 'matrix');

    Route::delete('/lock/{matrix}', [
        'as' => 'playground.matrix.resource.matrices.unlock',
        'uses' => 'MatrixController@unlock',
    ])->whereUuid('matrix')->can('unlock', 'matrix');

    Route::delete('/{matrix}', [
        'as' => 'playground.matrix.resource.matrices.destroy',
        'uses' => 'MatrixController@destroy',
    ])->whereUuid('matrix')->can('delete', 'matrix')->withTrashed();

    Route::put('/restore/{matrix}', [
        'as' => 'playground.matrix.resource.matrices.restore',
        'uses' => 'MatrixController@restore',
    ])->whereUuid('matrix')->can('restore', 'matrix')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.matrices.post',
        'uses' => 'MatrixController@store',
    ])->can('store', Playground\Matrix\Models\Matrix::class);

    // Route::put('/', [
    //     'as' => 'playground.matrix.resource.matrices.put',
    //     'uses' => 'MatrixController@store',
    // ])->can('store', Playground\Matrix\Models\Matrix::class);
    //
    // Route::put('/{matrix}', [
    //     'as' => 'playground.matrix.resource.matrices.put.id',
    //     'uses' => 'MatrixController@store',
    // ])->whereUuid('matrix')->can('update', 'matrix');

    Route::patch('/{matrix}', [
        'as' => 'playground.matrix.resource.matrices.patch',
        'uses' => 'MatrixController@update',
    ])->whereUuid('matrix')->can('update', 'matrix');
});
