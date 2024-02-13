<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Project
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/projects',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource.projects',
        'uses' => 'ProjectController@index',
    ])->can('index', \Playground\Matrix\Models\Project::class);

    # UI

    Route::get('/create', [
        'as'   => 'playground.matrix.resource.projects.create',
        'uses' => 'ProjectController@create',
    ])->can('create', \Playground\Matrix\Models\Project::class);

    Route::get('/edit/{project}', [
        'as'   => 'playground.matrix.resource.projects.edit',
        'uses' => 'ProjectController@edit',
    ])->whereUuid('project')
        ->can('edit', 'project')
    ;

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.projects.go',
    //     'uses' => 'ProjectController@go',
    // ]);

    Route::get('/{project}', [
        'as'   => 'playground.matrix.resource.projects.show',
        'uses' => 'ProjectController@show',
    ])->whereUuid('project')
        ->can('detail', 'project')
    ;

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.projects.slug',
    //     'uses' => 'ProjectController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.projects.store',
    //     'uses' => 'ProjectController@store',
    // ])->can('store', \Playground\Matrix\Models\Project::class);

    # API

    Route::put('/lock/{project}', [
        'as'   => 'playground.matrix.resource.projects.lock',
        'uses' => 'ProjectController@lock',
    ])->whereUuid('project')
        ->can('lock', 'project')
    ;

    Route::delete('/lock/{project}', [
        'as'   => 'playground.matrix.resource.projects.unlock',
        'uses' => 'ProjectController@unlock',
    ])->whereUuid('project')
        ->can('unlock', 'project')
    ;

    Route::delete('/{project}', [
        'as'   => 'playground.matrix.resource.projects.destroy',
        'uses' => 'ProjectController@destroy',
    ])->whereUuid('project')
        ->can('delete', 'project')
        ->withTrashed()
    ;

    Route::put('/restore/{project}', [
        'as'   => 'playground.matrix.resource.projects.restore',
        'uses' => 'ProjectController@restore',
    ])->whereUuid('project')
        ->can('restore', 'project')
        ->withTrashed()
    ;

    Route::post('/', [
        'as'   => 'playground.matrix.resource.projects.post',
        'uses' => 'ProjectController@store',
    ])->can('store', \Playground\Matrix\Models\Project::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.projects.put',
    //     'uses' => 'ProjectController@store',
    // ])->can('store', \Playground\Matrix\Models\Project::class);
    //
    // Route::put('/{project}', [
    //     'as'   => 'playground.matrix.resource.projects.put.id',
    //     'uses' => 'ProjectController@store',
    // ])->whereUuid('project')->can('update', 'project');

    Route::patch('/{project}', [
        'as'   => 'playground.matrix.resource.projects.patch',
        'uses' => 'ProjectController@update',
    ])->whereUuid('project')->can('update', 'project');
});
