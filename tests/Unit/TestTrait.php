<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Matrix\Resource;

/**
 * \Tests\Unit\Playground\Matrix\Resource\TestTrait
 */
trait TestTrait
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\ServiceProvider::class,
            \Playground\Auth\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
            \Playground\Login\Blade\ServiceProvider::class,
            \Playground\Matrix\Resource\ServiceProvider::class,
            \Playground\Matrix\ServiceProvider::class,
            \Playground\Blade\ServiceProvider::class,
            \Playground\Site\Blade\ServiceProvider::class,
        ];
    }
}
