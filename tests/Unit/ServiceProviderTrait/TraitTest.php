<?php
/**
 * GammaMatrix
 *
 */

namespace Tests\Unit\GammaMatrix\Playground\Matrix\Resource\ServiceProviderTrait;

use Tests\Unit\GammaMatrix\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Unit\GammaMatrix\Playground\Matrix\Resource\ServiceProviderTrait\TraitTest
 *
 */
class TraitTest extends TestCase
{
    public const TRAIT_CLASS = \GammaMatrix\Playground\Matrix\Resource\ServiceProviderTrait::class;

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
}
