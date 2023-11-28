<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Feature\GammaMatrix\Playground\Matrix\Resource;

use GammaMatrix\Playground\Test\OrchestraTestCase;
use Tests\Unit\GammaMatrix\Playground\Matrix\Resource\TestTrait;

/**
 * \Tests\Feature\GammaMatrix\Playground\Matrix\Resource\TestCase
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
