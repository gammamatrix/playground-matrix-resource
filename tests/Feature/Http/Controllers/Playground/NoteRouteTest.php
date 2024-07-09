<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Resource\Http\Controllers\NoteTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground\NoteRouteTest
 */
class NoteRouteTest extends NoteTestCase
{
    protected bool $load_migrations_playground = true;

    protected bool $setUpUserForPlayground = true;
}
