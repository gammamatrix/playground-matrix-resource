<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Resource\Http\Controllers\BacklogTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground\BacklogRouteTest
 */
class BacklogRouteTest extends BacklogTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}
