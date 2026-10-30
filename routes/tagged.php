<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Matrix\Models\Tagged;

/*
|--------------------------------------------------------------------------
| Matrix Resource Routes: Tagged
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/tagged',
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {

    // API

    Route::delete('/{tagged}', [
        'as' => 'playground.matrix.resource.tagged.destroy',
        'uses' => 'TaggedController@destroy',
    ])->whereUuid('tagged')->can('delete', 'tagged');

    Route::post('/', [
        'as' => 'playground.matrix.resource.tagged.post',
        'uses' => 'TaggedController@store',
    ])->can('store', Tagged::class);
});
