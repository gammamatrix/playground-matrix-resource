<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Matrix\Resource;

// use Illuminate\Foundation\Testing\DatabaseTransactions;
use Playground\Auth\ServiceProvider as PlaygroundAuthServiceProvider;
use Playground\Blade\ServiceProvider as PlaygroundBladeServiceProvider;
use Playground\Http\ServiceProvider as PlaygroundHttpServiceProvider;
use Playground\Login\Blade\ServiceProvider as PlaygroundLoginBladeServiceProvider;
use Playground\Matrix\Resource\ServiceProvider;
use Playground\Matrix\ServiceProvider as PlaygroundMatrixServiceProvider;
use Playground\ServiceProvider as PlaygroundServiceProvider;
use Playground\Site\Blade\ServiceProvider as PlaygroundSiteBladeServiceProvider;

// use Illuminate\Contracts\Config\Repository;

/**
 * \Tests\Unit\Playground\Matrix\Resource\TestTrait
 */
trait TestTrait
{
    // use DatabaseTransactions;

    protected function getPackageProviders($app)
    {
        return [
            PlaygroundAuthServiceProvider::class,
            PlaygroundBladeServiceProvider::class,
            PlaygroundHttpServiceProvider::class,
            PlaygroundLoginBladeServiceProvider::class,
            PlaygroundSiteBladeServiceProvider::class,
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
        $app['config']->set('auth.providers.users.model', 'Playground\\Test\\Models\\User');
        $app['config']->set('playground-auth.verify', 'user');
        $app['config']->set('auth.testing.password', 'password');
        $app['config']->set('auth.testing.hashed', false);

        $app['config']->set('playground-cms.load.migrations', true);
    }
}
