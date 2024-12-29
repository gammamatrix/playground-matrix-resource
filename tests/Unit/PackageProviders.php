<?php

/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource;

/**
 * \Tests\Unit\Playground\Matrix\Resource\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\ServiceProvider::class,
            \Playground\Auth\ServiceProvider::class,
            \Playground\Blade\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
            \Playground\Login\Blade\ServiceProvider::class,
            \Playground\Site\Blade\ServiceProvider::class,
            \Playground\Matrix\ServiceProvider::class,
            \Playground\Matrix\Resource\ServiceProvider::class,
        ];
    }
}
