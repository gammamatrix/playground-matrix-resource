<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Resource Routes: Milestone
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/milestone',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {

    Route::get('/{milestone:slug}', [
        'as' => 'playground.matrix.resource.milestones.slug',
        'uses' => 'MilestoneController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'resource/matrix/milestones',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource.milestones',
        'uses' => 'MilestoneController@index',
    ])->can('index', Playground\Matrix\Models\Milestone::class);

    Route::post('/index', [
        'as' => 'playground.matrix.resource.milestones.index',
        'uses' => 'MilestoneController@index',
    ])->can('index', Playground\Matrix\Models\Milestone::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.resource.milestones.create',
        'uses' => 'MilestoneController@create',
    ])->can('create', Playground\Matrix\Models\Milestone::class);

    Route::get('/edit/{milestone}', [
        'as' => 'playground.matrix.resource.milestones.edit',
        'uses' => 'MilestoneController@edit',
    ])->whereUuid('milestone')->can('edit', 'milestone');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.matrix.resource.milestones.go',
    //     'uses' => 'MilestoneController@go',
    // ]);

    Route::get('/{milestone}', [
        'as' => 'playground.matrix.resource.milestones.show',
        'uses' => 'MilestoneController@show',
    ])->whereUuid('milestone')->can('detail', 'milestone');

    // API

    Route::put('/lock/{milestone}', [
        'as' => 'playground.matrix.resource.milestones.lock',
        'uses' => 'MilestoneController@lock',
    ])->whereUuid('milestone')->can('lock', 'milestone');

    Route::delete('/lock/{milestone}', [
        'as' => 'playground.matrix.resource.milestones.unlock',
        'uses' => 'MilestoneController@unlock',
    ])->whereUuid('milestone')->can('unlock', 'milestone');

    Route::delete('/{milestone}', [
        'as' => 'playground.matrix.resource.milestones.destroy',
        'uses' => 'MilestoneController@destroy',
    ])->whereUuid('milestone')->can('delete', 'milestone')->withTrashed();

    Route::put('/restore/{milestone}', [
        'as' => 'playground.matrix.resource.milestones.restore',
        'uses' => 'MilestoneController@restore',
    ])->whereUuid('milestone')->can('restore', 'milestone')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.resource.milestones.post',
        'uses' => 'MilestoneController@store',
    ])->can('store', Playground\Matrix\Models\Milestone::class);

    // Route::put('/', [
    //     'as' => 'playground.matrix.resource.milestones.put',
    //     'uses' => 'MilestoneController@store',
    // ])->can('store', Playground\Matrix\Models\Milestone::class);
    //
    // Route::put('/{milestone}', [
    //     'as' => 'playground.matrix.resource.milestones.put.id',
    //     'uses' => 'MilestoneController@store',
    // ])->whereUuid('milestone')->can('update', 'milestone');

    Route::patch('/{milestone}', [
        'as' => 'playground.matrix.resource.milestones.patch',
        'uses' => 'MilestoneController@update',
    ])->whereUuid('milestone')->can('update', 'milestone');
});
