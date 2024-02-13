<?php
/**
 * Playground
 *
 */

namespace Tests\Feature\Playground\Matrix\Resource;

use Playground\Test\OrchestraTestCase;
use Tests\Unit\Playground\Matrix\Resource\TestTrait;
use Illuminate\Support\Carbon;

/**
 * \Tests\Feature\Playground\Matrix\Resource\TestCase
 *
 */
class TestCase extends OrchestraTestCase
{
    use TestTrait;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     'path' => dirname(dirname(__DIR__)) . '/database/migrations',
        // ]);
        if (!empty(env('TEST_DB_MIGRATIONS'))) {
            // $this->loadLaravelMigrations();
            $this->loadMigrationsFrom(dirname(dirname(__DIR__)) . '/database/migrations-laravel');
            $this->loadMigrationsFrom(dirname(dirname(__DIR__)) . '/database/migrations-matrix-uuid');
        }
    }
}
