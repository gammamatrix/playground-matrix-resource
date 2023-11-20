<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Backlog
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/backlogs',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\GammaMatrix\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource.backlogs',
        'uses' => 'BacklogController@index',
    ])->can('index', \GammaMatrix\Playground\Matrix\Models\Backlog::class);

    # UI

    Route::get('/create', [
        'as'   => 'playground.matrix.resource.backlogs.create',
        'uses' => 'BacklogController@create',
    ])->can('create', \GammaMatrix\Playground\Matrix\Models\Backlog::class);

    Route::get('/edit/{backlog}', [
        'as'   => 'playground.matrix.resource.backlogs.edit',
        'uses' => 'BacklogController@edit',
    ])->whereUuid('backlog')
        ->can('edit', 'backlog')
    ;

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.backlogs.go',
    //     'uses' => 'BacklogController@go',
    // ]);

    Route::get('/{backlog}', [
        'as'   => 'playground.matrix.resource.backlogs.show',
        'uses' => 'BacklogController@show',
    ])->whereUuid('backlog')
        ->can('detail', 'backlog')
    ;

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.backlogs.slug',
    //     'uses' => 'BacklogController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.backlogs.store',
    //     'uses' => 'BacklogController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Backlog::class);

    # API

    Route::put('/lock/{backlog}', [
        'as'   => 'playground.matrix.resource.backlogs.lock',
        'uses' => 'BacklogController@lock',
    ])->whereUuid('backlog')
        ->can('lock', 'backlog')
    ;

    Route::put('/unlock/{backlog}', [
        'as'   => 'playground.matrix.resource.backlogs.unlock',
        'uses' => 'BacklogController@unlock',
    ])->whereUuid('backlog')
        ->can('unlock', 'backlog')
    ;

    Route::delete('/{backlog}', [
        'as'   => 'playground.matrix.resource.backlogs.destroy',
        'uses' => 'BacklogController@destroy',
    ])->whereUuid('backlog')
        ->can('delete', 'backlog')
        ->withTrashed()
    ;

    Route::put('/restore/{backlog}', [
        'as'   => 'playground.matrix.resource.backlogs.restore',
        'uses' => 'BacklogController@restore',
    ])->whereUuid('backlog')
        ->can('restore', 'backlog')
        ->withTrashed()
    ;

    Route::post('/', [
        'as'   => 'playground.matrix.resource.backlogs.post',
        'uses' => 'BacklogController@store',
    ])->can('store', \GammaMatrix\Playground\Matrix\Models\Backlog::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.backlogs.put',
    //     'uses' => 'BacklogController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Backlog::class);
    //
    // Route::put('/{backlog}', [
    //     'as'   => 'playground.matrix.resource.backlogs.put.id',
    //     'uses' => 'BacklogController@store',
    // ])->whereUuid('backlog')->can('update', 'backlog');

    Route::patch('/{backlog}', [
        'as'   => 'playground.matrix.resource.backlogs.patch',
        'uses' => 'BacklogController@update',
    ])->whereUuid('backlog')->can('update', 'backlog');
});
