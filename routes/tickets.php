<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Ticket
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'resource/matrix/tickets',
    'middleware' => config('playground-matrix-resource.middleware'),
    'namespace' => '\GammaMatrix\Playground\Matrix\Resource\Http\Controllers',
], function () {
    Route::get('/', [
        'as'   => 'playground.matrix.resource.tickets',
        'uses' => 'TicketController@index',
    ])->can('index', \GammaMatrix\Playground\Matrix\Models\Ticket::class);

    # UI

    Route::get('/create', [
        'as'   => 'playground.matrix.resource.tickets.create',
        'uses' => 'TicketController@create',
    ])->can('create', \GammaMatrix\Playground\Matrix\Models\Ticket::class);

    Route::get('/edit/{ticket}', [
        'as'   => 'playground.matrix.resource.tickets.edit',
        'uses' => 'TicketController@edit',
    ])->whereUuid('ticket')
        ->can('edit', 'ticket')
    ;

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.resource.tickets.go',
    //     'uses' => 'TicketController@go',
    // ]);

    Route::get('/{ticket}', [
        'as'   => 'playground.matrix.resource.tickets.show',
        'uses' => 'TicketController@show',
    ])->whereUuid('ticket')
        ->can('detail', 'ticket')
    ;

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.resource.tickets.slug',
    //     'uses' => 'TicketController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.resource.tickets.store',
    //     'uses' => 'TicketController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Ticket::class);

    # API

    Route::put('/lock/{ticket}', [
        'as'   => 'playground.matrix.resource.tickets.lock',
        'uses' => 'TicketController@lock',
    ])->whereUuid('ticket')
        ->can('lock', 'ticket')
    ;

    Route::put('/unlock/{ticket}', [
        'as'   => 'playground.matrix.resource.tickets.unlock',
        'uses' => 'TicketController@unlock',
    ])->whereUuid('ticket')
        ->can('unlock', 'ticket')
    ;

    Route::delete('/{ticket}', [
        'as'   => 'playground.matrix.resource.tickets.destroy',
        'uses' => 'TicketController@destroy',
    ])->whereUuid('ticket')
        ->can('delete', 'ticket')
        ->withTrashed()
    ;

    Route::put('/restore/{ticket}', [
        'as'   => 'playground.matrix.resource.tickets.restore',
        'uses' => 'TicketController@restore',
    ])->whereUuid('ticket')
        ->can('restore', 'ticket')
        ->withTrashed()
    ;

    Route::post('/', [
        'as'   => 'playground.matrix.resource.tickets.post',
        'uses' => 'TicketController@store',
    ])->can('store', \GammaMatrix\Playground\Matrix\Models\Ticket::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.resource.tickets.put',
    //     'uses' => 'TicketController@store',
    // ])->can('store', \GammaMatrix\Playground\Matrix\Models\Ticket::class);
    //
    // Route::put('/{ticket}', [
    //     'as'   => 'playground.matrix.resource.tickets.put.id',
    //     'uses' => 'TicketController@store',
    // ])->whereUuid('ticket')->can('update', 'ticket');

    Route::patch('/{ticket}', [
        'as'   => 'playground.matrix.resource.tickets.patch',
        'uses' => 'TicketController@update',
    ])->whereUuid('ticket')->can('update', 'ticket');
});
