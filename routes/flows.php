<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Flow
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/flows',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.flows',
        'uses' => 'FlowController@index',
    ])->can('index', Playground\Matrix\Models\Flow::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.flows.create',
        'uses' => 'FlowController@create',
    ])->can('create', Playground\Matrix\Models\Flow::class);

    Route::get('/edit/{flow}', [
        'as' => 'playground.matrix.resource.flows.edit',
        'uses' => 'FlowController@edit',
    ])->whereUuid('flow')
        ->can('edit', 'flow');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.flows.go',
    //     'uses' => 'FlowController@go',
    // ]);

    Route::get('/{flow}', [
        'as' => 'playground.matrix.resource.flows.show',
        'uses' => 'FlowController@show',
    ])->whereUuid('flow')
        ->can('detail', 'flow');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.flows.slug',
    //     'uses' => 'FlowController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.flows.store',
    //     'uses' => 'FlowController@store',
    // ])->can('store', \Playground\Matrix\Models\Flow::class);

    // API

    Route::put('/lock/{flow}', [
        'as' => 'playground.matrix.resource.flows.lock',
        'uses' => 'FlowController@lock',
    ])->whereUuid('flow')
        ->can('lock', 'flow');

    Route::delete('/lock/{flow}', [
        'as' => 'playground.matrix.resource.flows.unlock',
        'uses' => 'FlowController@unlock',
    ])->whereUuid('flow')
        ->can('unlock', 'flow');

    Route::delete('/{flow}', [
        'as' => 'playground.matrix.resource.flows.destroy',
        'uses' => 'FlowController@destroy',
    ])->whereUuid('flow')
        ->can('delete', 'flow')
        ->withTrashed();

    Route::put('/restore/{flow}', [
        'as' => 'playground.matrix.resource.flows.restore',
        'uses' => 'FlowController@restore',
    ])->whereUuid('flow')
        ->can('restore', 'flow')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.flows.post',
        'uses' => 'FlowController@store',
    ])->can('store', Playground\Matrix\Models\Flow::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.flows.put',
    //     'uses' => 'FlowController@store',
    // ])->can('store', \Playground\Matrix\Models\Flow::class);
    //
    // Route::put('/{flow}', [
    //     'as'   => 'playground.matrix.resource.flows.put.id',
    //     'uses' => 'FlowController@store',
    // ])->whereUuid('flow')->can('update', 'flow');

    Route::patch('/{flow}', [
        'as' => 'playground.matrix.resource.flows.patch',
        'uses' => 'FlowController@update',
    ])->whereUuid('flow')->can('update', 'flow');
});
