<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Matrix\Resource\ServiceProviderTrait;

use Tests\Unit\Playground\Matrix\Resource\TestCase;
use Playground\Test\MockingTrait;
// use Playground\Matrix\Resource\ServiceProviderTrait;
use Playground\Matrix\Resource\ServiceProvider;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * \Tests\Unit\Playground\Matrix\Resource\ServiceProviderTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    use MockingTrait;

    public function test_setPolicyNamespace_with_invalid_value(): void
    {
        /**
         * @var MockObject&ServiceProvider
         */
        $stub = $this->createStub(ServiceProvider::class);

        $expected = '';

        $this->assertSame($expected, $stub->setPolicyNamespace([]));
    }

    public function test_setPolicyNamespace_with_app_namespace(): void
    {
        /**
         * @var MockObject&ServiceProvider
         */
        $stub = $this->createStub(ServiceProvider::class);

        $expected = 'App\\Policies';

        $config = [
            'policy_namespace' => $expected,
        ];

        $this->assertSame($expected, $stub->setPolicyNamespace($config));
    }

    public function test_registerPolicies_getRegister_with_empty_policy_namespace(): void
    {
        /**
         * @var MockObject&ServiceProvider
         */
        $stub = $this->createStub(ServiceProvider::class);

        $policy_namespace = '';
        $this->setProtected($stub, 'policy_namespace', $policy_namespace);

        $policy = \Playground\Matrix\Resource\Policies\BacklogPolicy::class;
        $expected = $policy;

        $this->assertSame($expected, $stub->registerPolicies_getRegister($policy));
    }

    public function test_registerPolicies_getRegister_with_app_policy_namespace(): void
    {
        /**
         * @var MockObject&ServiceProvider
         */
        $stub = $this->createStub(ServiceProvider::class);

        $policy_namespace = 'App\\Policies';
        $this->setProtected($stub, 'policy_namespace', $policy_namespace);

        $policy = 'App\\\Policies\\\BacklogPolicy';
        $expected = $policy;

        $this->assertSame($expected, $stub->registerPolicies_getRegister($policy));
    }
}
