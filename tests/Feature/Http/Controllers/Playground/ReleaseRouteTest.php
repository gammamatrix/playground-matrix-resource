<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Resource\Http\Controllers\ReleaseTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground\ReleaseRouteTest
 */
class ReleaseRouteTest extends ReleaseTestCase
{
    protected bool $load_migrations_package = true;

    protected bool $load_migrations_playground = true;

    protected bool $setUpUserForPlayground = true;
}
