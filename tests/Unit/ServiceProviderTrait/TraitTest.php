<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Matrix\Resource\ServiceProviderTrait;

use Tests\Unit\Playground\Matrix\Resource\TestCase;
use Playground\Test\MockingTrait;

/**
 * \Tests\Unit\Playground\Matrix\Resource\ServiceProviderTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    use MockingTrait;

    public const TRAIT_CLASS = \Playground\Matrix\Resource\ServiceProviderTrait::class;

    public $mock;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->getMockForTrait(
            static::TRAIT_CLASS,
            [],
            '',
            true,
            true,
            true,
            $methods = []
        );
    }

    public function test_setPolicyNamespace_with_invalid_value(): void
    {
        $expected = '';

        $this->assertSame($expected, $this->mock->setPolicyNamespace([]));
    }

    public function test_setPolicyNamespace_with_app_namespace(): void
    {
        $expected = 'App\\Policies';

        $config = [
            'policy_namespace' => $expected,
        ];

        $this->assertSame($expected, $this->mock->setPolicyNamespace($config));
    }

    public function test_registerPolicies_getRegister_with_empty_policy_namespace(): void
    {
        $policy_namespace = '';
        $this->setProtected($this->mock, 'policy_namespace', $policy_namespace);

        $policy = \Playground\Matrix\Resource\Policies\BacklogPolicy::class;
        $expected = $policy;

        $this->assertSame($expected, $this->mock->registerPolicies_getRegister($policy));
    }

    public function test_registerPolicies_getRegister_with_app_policy_namespace(): void
    {
        $policy_namespace = 'App\\Policies';
        $this->setProtected($this->mock, 'policy_namespace', $policy_namespace);

        $policy = 'App\\\Policies\\\BacklogPolicy';
        $expected = $policy;

        $this->assertSame($expected, $this->mock->registerPolicies_getRegister($policy));
    }
}
