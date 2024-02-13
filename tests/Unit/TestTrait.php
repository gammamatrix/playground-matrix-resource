<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Matrix\Resource;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Playground\ServiceProvider as PlaygroundServiceProvider;
use Playground\Auth\ServiceProvider as PlaygroundAuthServiceProvider;
use Playground\Matrix\ServiceProvider as PlaygroundMatrixServiceProvider;
use Playground\Matrix\Resource\ServiceProvider;
use Illuminate\Contracts\Config\Repository;

/**
 * \Tests\Unit\Playground\Matrix\Resource\TestTrait
 *
 */
trait TestTrait
{
    use DatabaseTransactions;

    protected function getPackageProviders($app)
    {
        return [
            PlaygroundAuthServiceProvider::class,
            PlaygroundMatrixServiceProvider::class,
            PlaygroundServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // dd(__METHOD__);
        $app['config']->set('auth.providers.users.model', 'Playground\\Test\\Models\\User');
        $app['config']->set('playground.user', 'Playground\\Test\\Models\\User');
        $app['config']->set('playground.auth.verify', 'user');

        $app['config']->set('playground-matrix.load.migrations', true);

        $middleware = [];
        // api,auth:sanctum,web

        $app['config']->set('playground-matrix-resource.middleware', [
            'auth',
            'web',
        ]);

        $app['config']->set('playground-matrix-resource.routes.matrix', true);
        $app['config']->set('playground-matrix-resource.routes.backlogs', true);
        $app['config']->set('playground-matrix-resource.routes.boards', true);
        $app['config']->set('playground-matrix-resource.routes.epics', true);
        $app['config']->set('playground-matrix-resource.routes.flows', true);
        $app['config']->set('playground-matrix-resource.routes.milestones', true);
        $app['config']->set('playground-matrix-resource.routes.notes', true);
        $app['config']->set('playground-matrix-resource.routes.projects', true);
        $app['config']->set('playground-matrix-resource.routes.releases', true);
        $app['config']->set('playground-matrix-resource.routes.roadmaps', true);
        $app['config']->set('playground-matrix-resource.routes.sources', true);
        $app['config']->set('playground-matrix-resource.routes.sprints', true);
        $app['config']->set('playground-matrix-resource.routes.tags', true);
        $app['config']->set('playground-matrix-resource.routes.teams', true);
        $app['config']->set('playground-matrix-resource.routes.tickets', true);
        $app['config']->set('playground-matrix-resource.routes.versions', true);

        $app['config']->set('playground-matrix-resource.sitemap.enable', true);
        $app['config']->set('playground-matrix-resource.sitemap.guest', true);
        $app['config']->set('playground-matrix-resource.sitemap.user', true);

    }
}
