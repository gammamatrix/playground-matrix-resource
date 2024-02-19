<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground;

use Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\Playground\Matrix\Resource\Http\Controllers\BacklogTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground\BacklogRouteTest
 */
class BacklogRouteTest extends BacklogTestCase
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

    // public function test_dump_console_about(): void
    // {
    //     $result = $this->withoutMockingConsoleOutput()->artisan('about');
    //     dump(\Illuminate\Support\Facades\Artisan::output());
    // }

    // public function test_dump_console_route_list(): void
    // {
    //     $result = $this->withoutMockingConsoleOutput()->artisan('route:list -vvv');
    //     dump(\Illuminate\Support\Facades\Artisan::output());
    // }
}
