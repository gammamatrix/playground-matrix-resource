<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Board
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/boards',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.boards',
        'uses' => 'BoardController@index',
    ])->can('index', Playground\Matrix\Models\Board::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.boards.create',
        'uses' => 'BoardController@create',
    ])->can('create', Playground\Matrix\Models\Board::class);

    Route::get('/edit/{board}', [
        'as' => 'playground.matrix.resource.boards.edit',
        'uses' => 'BoardController@edit',
    ])->whereUuid('board')
        ->can('edit', 'board');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.boards.go',
    //     'uses' => 'BoardController@go',
    // ]);

    Route::get('/{board}', [
        'as' => 'playground.matrix.resource.boards.show',
        'uses' => 'BoardController@show',
    ])->whereUuid('board')
        ->can('detail', 'board');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.boards.slug',
    //     'uses' => 'BoardController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.boards.store',
    //     'uses' => 'BoardController@store',
    // ])->can('store', \Playground\Matrix\Models\Board::class);

    // API

    Route::put('/lock/{board}', [
        'as' => 'playground.matrix.resource.boards.lock',
        'uses' => 'BoardController@lock',
    ])->whereUuid('board')
        ->can('lock', 'board');

    Route::delete('/lock/{board}', [
        'as' => 'playground.matrix.resource.boards.unlock',
        'uses' => 'BoardController@unlock',
    ])->whereUuid('board')
        ->can('unlock', 'board');

    Route::delete('/{board}', [
        'as' => 'playground.matrix.resource.boards.destroy',
        'uses' => 'BoardController@destroy',
    ])->whereUuid('board')
        ->can('delete', 'board')
        ->withTrashed();

    Route::put('/restore/{board}', [
        'as' => 'playground.matrix.resource.boards.restore',
        'uses' => 'BoardController@restore',
    ])->whereUuid('board')
        ->can('restore', 'board')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.boards.post',
        'uses' => 'BoardController@store',
    ])->can('store', Playground\Matrix\Models\Board::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.boards.put',
    //     'uses' => 'BoardController@store',
    // ])->can('store', \Playground\Matrix\Models\Board::class);
    //
    // Route::put('/{board}', [
    //     'as'   => 'playground.matrix.resource.boards.put.id',
    //     'uses' => 'BoardController@store',
    // ])->whereUuid('board')->can('update', 'board');

    Route::patch('/{board}', [
        'as' => 'playground.matrix.resource.boards.patch',
        'uses' => 'BoardController@update',
    ])->whereUuid('board')->can('update', 'board');
});
