<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Matrix\Resource\Policies\BacklogPolicy;

use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \ests\Unit\Playground\Matrix\Resource\Policies\BacklogPolicy\PolicyTest
 *
 */
class PolicyTest extends TestCase
{
    protected string $policyClass = \Playground\Matrix\Resource\Policies\BacklogPolicy::class;

    public function test_policy_instance(): void
    {
        $policyClass = $this->policyClass;

        $instance = new $policyClass();

        $this->assertInstanceOf($policyClass, $instance);
    }
}
