<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Playground\Test\OrchestraTestCase;
use Tests\Unit\Playground\Matrix\Resource\TestTrait;

/**
 * \Tests\Feature\Playground\Matrix\Resource\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use DatabaseTransactions;
    use TestTrait;

    protected bool $load_migrations_playground = false;

    protected bool $load_migrations_matrix = false;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        if (! empty(env('TEST_DB_MIGRATIONS'))) {
            // $this->loadLaravelMigrations();
            if ($this->load_migrations_playground) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-playground');
            }
            if ($this->load_migrations_matrix) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-matrix-uuid');
            }
        }
    }
}
