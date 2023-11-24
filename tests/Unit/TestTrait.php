<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Matrix\Resource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use GammaMatrix\Playground\ServiceProvider as PlaygroundServiceProvider;
use GammaMatrix\Playground\Matrix\Resource\ServiceProvider;
use Illuminate\Contracts\Config\Repository;

/**
 * \Tests\Unit\GammaMatrix\Playground\Matrix\Resource\TestTrait
 *
 */
trait TestTrait
{
    use DatabaseTransactions;

    protected function getPackageProviders($app)
    {
        return [
            PlaygroundServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    // /**
    //  * Define database migrations.
    //  *
    //  * @return void
    //  */
    // protected function defineDatabaseMigrations()
    // {
    //     $this->loadLaravelMigrations(['--database' => 'testbench']);
    //     $this->loadMigrationsFrom(workbench_path('database/migrations'));
    // }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // dd(__METHOD__);
        $app['config']->set('auth.providers.users.model', 'GammaMatrix\\Playground\\Test\\Models\\User');
        $app['config']->set('playground.user', 'GammaMatrix\\Playground\\Test\\Models\\User');
        $app['config']->set('playground.auth.verify', 'user');

        $app['config']->set('playground-matrix.load.migrations', true);

        $app['config']->set('playground-matrix-resource.routes.confirm', true);
        $app['config']->set('playground-matrix-resource.routes.forgot', true);
        $app['config']->set('playground-matrix-resource.routes.logout', true);
        $app['config']->set('playground-matrix-resource.routes.login', true);
        $app['config']->set('playground-matrix-resource.routes.register', true);
        $app['config']->set('playground-matrix-resource.routes.reset', true);
        $app['config']->set('playground-matrix-resource.routes.token', true);
        $app['config']->set('playground-matrix-resource.routes.verify', true);

        $app['config']->set('playground-matrix-resource.sitemap.enable', true);
        $app['config']->set('playground-matrix-resource.sitemap.guest', true);
        $app['config']->set('playground-matrix-resource.sitemap.user', true);

    }
}
