<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Tag
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/tags',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\GammaMatrix\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource.tags',
        'uses' => 'TagController@index',
    ])->can('index', \GammaMatrix\Playground\Matrix\Models\Tag::class);

    # UI

    Route::get('/create', [
        'as'   => 'playground.matrix.resource.tags.create',
        'uses' => 'TagController@create',
    ])->can('create', \GammaMatrix\Playground\Matrix\Models\Tag::class);

    Route::get('/edit/{tag}', [
        'as'   => 'playground.matrix.resource.tags.edit',
        'uses' => 'TagController@edit',
    ])->whereUuid('tag')
        ->can('edit', 'tag')
    ;

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.tags.go',
    //     'uses' => 'TagController@go',
    // ]);

    Route::get('/{tag}', [
        'as'   => 'playground.matrix.resource.tags.show',
        'uses' => 'TagController@show',
    ])->whereUuid('tag')
        ->can('detail', 'tag')
    ;

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.tags.slug',
    //     'uses' => 'TagController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.tags.store',
    //     'uses' => 'TagController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Tag::class);

    # API

    Route::put('/lock/{tag}', [
        'as'   => 'playground.matrix.resource.tags.lock',
        'uses' => 'TagController@lock',
    ])->whereUuid('tag')
        ->can('lock', 'tag')
    ;

    Route::delete('/lock/{tag}', [
        'as'   => 'playground.matrix.resource.tags.unlock',
        'uses' => 'TagController@unlock',
    ])->whereUuid('tag')
        ->can('unlock', 'tag')
    ;

    Route::delete('/{tag}', [
        'as'   => 'playground.matrix.resource.tags.destroy',
        'uses' => 'TagController@destroy',
    ])->whereUuid('tag')
        ->can('delete', 'tag')
        ->withTrashed()
    ;

    Route::put('/restore/{tag}', [
        'as'   => 'playground.matrix.resource.tags.restore',
        'uses' => 'TagController@restore',
    ])->whereUuid('tag')
        ->can('restore', 'tag')
        ->withTrashed()
    ;

    Route::post('/', [
        'as'   => 'playground.matrix.resource.tags.post',
        'uses' => 'TagController@store',
    ])->can('store', \GammaMatrix\Playground\Matrix\Models\Tag::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.tags.put',
    //     'uses' => 'TagController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Tag::class);
    //
    // Route::put('/{tag}', [
    //     'as'   => 'playground.matrix.resource.tags.put.id',
    //     'uses' => 'TagController@store',
    // ])->whereUuid('tag')->can('update', 'tag');

    Route::patch('/{tag}', [
        'as'   => 'playground.matrix.resource.tags.patch',
        'uses' => 'TagController@update',
    ])->whereUuid('tag')->can('update', 'tag');
});
