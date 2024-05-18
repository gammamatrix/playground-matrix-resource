<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Resource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Playground\Test\OrchestraTestCase;
use Tests\Unit\Playground\Matrix\Resource\PackageProviders;

/**
 * \Tests\Feature\Playground\Matrix\Resource\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use DatabaseTransactions;
    use PackageProviders;

    protected bool $load_migrations_laravel = false;

    protected bool $load_migrations_package = true;

    protected bool $load_migrations_playground = true;

    /**
     * Define database migrations.
     *
     * @api
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     'env(TEST_DB_MIGRATIONS)' => env('TEST_DB_MIGRATIONS'),
        //     '$this->load_migrations_laravel' => $this->load_migrations_laravel,
        //     '$this->load_migrations_package' => $this->load_migrations_package,
        //     '$this->load_migrations_laravel' => $this->load_migrations_playground,
        //     'database/migrations-laravel' => dirname(dirname(__DIR__)).'/database/migrations-laravel',
        //     'database/migrations-package' => dirname(dirname(__DIR__)).'/database/migrations-package',
        //     'database/migrations-playground' => dirname(dirname(__DIR__)).'/database/migrations-playground',
        // ]);
        if (! empty(env('TEST_DB_MIGRATIONS'))) {
            if ($this->load_migrations_laravel) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-laravel');
            }
            if ($this->load_migrations_package) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-package');
            }
            if ($this->load_migrations_playground) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-playground');
            }
        }
    }
}
