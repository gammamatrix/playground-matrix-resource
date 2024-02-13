<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CMS API Routes
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource',
        'uses' => 'IndexController@index',
    ]);
});
