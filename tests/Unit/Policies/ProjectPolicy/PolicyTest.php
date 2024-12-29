<?php

/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Resource\Policies\ProjectPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Resource\Policies\ProjectPolicy;
use Tests\Unit\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Resource\Policies\ProjectPolicy\PolicyTest
 */
#[CoversClass(ProjectPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new ProjectPolicy;

        $this->assertInstanceOf(ProjectPolicy::class, $instance);
    }
}
