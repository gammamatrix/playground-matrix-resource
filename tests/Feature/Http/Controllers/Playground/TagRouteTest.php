<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground;

use Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\Playground\Matrix\Resource\Http\Controllers\TagTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground\TagRouteTest
 */
class TagRouteTest extends TagTestCase
{
    use Resource\Playground\CreateTrait;
    use Resource\Playground\DestroyTrait;
    use Resource\Playground\EditTrait;
    use Resource\Playground\IndexTrait;
    use Resource\Playground\LockTrait;
    use Resource\Playground\RestoreTrait;
    use Resource\Playground\ShowTrait;
    use Resource\Playground\UnlockTrait;
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}
