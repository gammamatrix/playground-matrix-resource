<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Note
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/notes',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\GammaMatrix\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource.notes',
        'uses' => 'NoteController@index',
    ])->can('index', \GammaMatrix\Playground\Matrix\Models\Note::class);

    # UI

    Route::get('/create', [
        'as'   => 'playground.matrix.resource.notes.create',
        'uses' => 'NoteController@create',
    ])->can('create', \GammaMatrix\Playground\Matrix\Models\Note::class);

    Route::get('/edit/{note}', [
        'as'   => 'playground.matrix.resource.notes.edit',
        'uses' => 'NoteController@edit',
    ])->whereUuid('note')
        ->can('edit', 'note')
    ;

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.notes.go',
    //     'uses' => 'NoteController@go',
    // ]);

    Route::get('/{note}', [
        'as'   => 'playground.matrix.resource.notes.show',
        'uses' => 'NoteController@show',
    ])->whereUuid('note')
        ->can('detail', 'note')
    ;

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.notes.slug',
    //     'uses' => 'NoteController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.notes.store',
    //     'uses' => 'NoteController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Note::class);

    # API

    Route::put('/lock/{note}', [
        'as'   => 'playground.matrix.resource.notes.lock',
        'uses' => 'NoteController@lock',
    ])->whereUuid('note')
        ->can('lock', 'note')
    ;

    Route::delete('/lock/{note}', [
        'as'   => 'playground.matrix.resource.notes.unlock',
        'uses' => 'NoteController@unlock',
    ])->whereUuid('note')
        ->can('unlock', 'note')
    ;

    Route::delete('/{note}', [
        'as'   => 'playground.matrix.resource.notes.destroy',
        'uses' => 'NoteController@destroy',
    ])->whereUuid('note')
        ->can('delete', 'note')
        ->withTrashed()
    ;

    Route::put('/restore/{note}', [
        'as'   => 'playground.matrix.resource.notes.restore',
        'uses' => 'NoteController@restore',
    ])->whereUuid('note')
        ->can('restore', 'note')
        ->withTrashed()
    ;

    Route::post('/', [
        'as'   => 'playground.matrix.resource.notes.post',
        'uses' => 'NoteController@store',
    ])->can('store', \GammaMatrix\Playground\Matrix\Models\Note::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.notes.put',
    //     'uses' => 'NoteController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Note::class);
    //
    // Route::put('/{note}', [
    //     'as'   => 'playground.matrix.resource.notes.put.id',
    //     'uses' => 'NoteController@store',
    // ])->whereUuid('note')->can('update', 'note');

    Route::patch('/{note}', [
        'as'   => 'playground.matrix.resource.notes.patch',
        'uses' => 'NoteController@update',
    ])->whereUuid('note')->can('update', 'note');
});
