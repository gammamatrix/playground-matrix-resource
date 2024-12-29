<?php

/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource\Policies\FlowPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Policies\FlowPolicy;
use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Policies\FlowPolicy\PolicyTest
 */
#[CoversClass(FlowPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new FlowPolicy;

        $this->assertInstanceOf(FlowPolicy::class, $instance);
    }
}
