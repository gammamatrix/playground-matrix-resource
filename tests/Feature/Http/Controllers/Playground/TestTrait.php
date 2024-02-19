<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Playground\TestTrait
 */
trait TestTrait
{
    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', '\\Playground\\Test\\Models\\PlaygroundUser');

        $app['config']->set('playground-matrix.load.migrations', true);

        $app['config']->set('app.debug', true);
        $app['config']->set('playground-auth.debug', true);

        $app['config']->set('playground-auth.verify', 'roles');
        // $app['config']->set('playground-auth.verify', 'privileges');
        $app['config']->set('playground-auth.sanctum', false);
        $app['config']->set('playground-auth.hasPrivilege', true);
        $app['config']->set('playground-auth.userPrivileges', true);
        $app['config']->set('playground-auth.hasRole', true);
        $app['config']->set('playground-auth.userRole', true);
        $app['config']->set('playground-auth.userRoles', true);

        // $app['config']->set('playground-auth.token.roles', true);
        // $app['config']->set('playground-auth.token.sanctum', true);

        // $middleware = [];
        // api,auth:sanctum,web

        // $app['config']->set('playground-matrix-resource.routes.matrix', true);
        // $app['config']->set('playground-matrix-resource.routes.backlogs', true);
        // $app['config']->set('playground-matrix-resource.routes.boards', true);
        // $app['config']->set('playground-matrix-resource.routes.epics', true);
        // $app['config']->set('playground-matrix-resource.routes.flows', true);
        // $app['config']->set('playground-matrix-resource.routes.milestones', true);
        // $app['config']->set('playground-matrix-resource.routes.notes', true);
        // $app['config']->set('playground-matrix-resource.routes.projects', true);
        // $app['config']->set('playground-matrix-resource.routes.releases', true);
        // $app['config']->set('playground-matrix-resource.routes.roadmaps', true);
        // $app['config']->set('playground-matrix-resource.routes.sources', true);
        // $app['config']->set('playground-matrix-resource.routes.sprints', true);
        // $app['config']->set('playground-matrix-resource.routes.tags', true);
        // $app['config']->set('playground-matrix-resource.routes.teams', true);
        // $app['config']->set('playground-matrix-resource.routes.tickets', true);
        // $app['config']->set('playground-matrix-resource.routes.versions', true);

        // $app['config']->set('playground-matrix-resource.sitemap.enable', true);
        // $app['config']->set('playground-matrix-resource.sitemap.guest', true);
        // $app['config']->set('playground-matrix-resource.sitemap.user', true);

    }
}
