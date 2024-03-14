<?php

declare(strict_types=1);

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
    'middleware' => config('playground-matrix-resource.middleware.default'),
    'namespace' => '\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.resource',
        'uses' => 'IndexController@index',
    ])->can('view', Playground\Matrix\Models\Ticket::class);
});
