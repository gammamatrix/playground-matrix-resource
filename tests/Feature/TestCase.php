<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Playground\Test\OrchestraTestCase;
use Tests\Unit\Playground\Matrix\Resource\TestTrait;

/**
 * \Tests\Feature\Playground\Matrix\Resource\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use DatabaseTransactions;
    use TestTrait;

    protected bool $load_migrations_package = false;

    protected bool $load_migrations_playground = false;

    /**
     * Define database migrations.
     *
     * @api
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        if (! empty(env('TEST_DB_MIGRATIONS'))) {
            // $this->loadLaravelMigrations();
            if ($this->load_migrations_playground) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-playground');
            }
            if ($this->load_migrations_package) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-matrix-uuid');
            }
        }
    }
}
