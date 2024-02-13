<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Sprint
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/sprints',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource.sprints',
        'uses' => 'SprintController@index',
    ])->can('index', \Playground\Matrix\Models\Sprint::class);

    # UI

    Route::get('/create', [
        'as'   => 'playground.matrix.resource.sprints.create',
        'uses' => 'SprintController@create',
    ])->can('create', \Playground\Matrix\Models\Sprint::class);

    Route::get('/edit/{sprint}', [
        'as'   => 'playground.matrix.resource.sprints.edit',
        'uses' => 'SprintController@edit',
    ])->whereUuid('sprint')
        ->can('edit', 'sprint')
    ;

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.sprints.go',
    //     'uses' => 'SprintController@go',
    // ]);

    Route::get('/{sprint}', [
        'as'   => 'playground.matrix.resource.sprints.show',
        'uses' => 'SprintController@show',
    ])->whereUuid('sprint')
        ->can('detail', 'sprint')
    ;

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.sprints.slug',
    //     'uses' => 'SprintController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.sprints.store',
    //     'uses' => 'SprintController@store',
    // ])->can('store', \Playground\Matrix\Models\Sprint::class);

    # API

    Route::put('/lock/{sprint}', [
        'as'   => 'playground.matrix.resource.sprints.lock',
        'uses' => 'SprintController@lock',
    ])->whereUuid('sprint')
        ->can('lock', 'sprint')
    ;

    Route::delete('/lock/{sprint}', [
        'as'   => 'playground.matrix.resource.sprints.unlock',
        'uses' => 'SprintController@unlock',
    ])->whereUuid('sprint')
        ->can('unlock', 'sprint')
    ;

    Route::delete('/{sprint}', [
        'as'   => 'playground.matrix.resource.sprints.destroy',
        'uses' => 'SprintController@destroy',
    ])->whereUuid('sprint')
        ->can('delete', 'sprint')
        ->withTrashed()
    ;

    Route::put('/restore/{sprint}', [
        'as'   => 'playground.matrix.resource.sprints.restore',
        'uses' => 'SprintController@restore',
    ])->whereUuid('sprint')
        ->can('restore', 'sprint')
        ->withTrashed()
    ;

    Route::post('/', [
        'as'   => 'playground.matrix.resource.sprints.post',
        'uses' => 'SprintController@store',
    ])->can('store', \Playground\Matrix\Models\Sprint::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.sprints.put',
    //     'uses' => 'SprintController@store',
    // ])->can('store', \Playground\Matrix\Models\Sprint::class);
    //
    // Route::put('/{sprint}', [
    //     'as'   => 'playground.matrix.resource.sprints.put.id',
    //     'uses' => 'SprintController@store',
    // ])->whereUuid('sprint')->can('update', 'sprint');

    Route::patch('/{sprint}', [
        'as'   => 'playground.matrix.resource.sprints.patch',
        'uses' => 'SprintController@update',
    ])->whereUuid('sprint')->can('update', 'sprint');
});
